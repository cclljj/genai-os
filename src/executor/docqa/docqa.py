#!/bin/python3
# -#- coding: UTF-8 -*-

import os
import re
import sys
import logging
import asyncio
import functools
import itertools
import requests
import json
import i18n
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from typing import Generator
from urllib.parse import urljoin
from kuwa.executor import LLMExecutor

from src.docqa import DocQa
from src.kuwa_llm_client import KuwaLlmClient
from src.document_store import DocumentStore

logger = logging.getLogger(__name__)

class NoUrlException(Exception):
    def __init__(self, msg):
        self.msg = msg
    def __str__(self):
        return self.msg

class DocQaExecutor(LLMExecutor):
    def __init__(self):
        super().__init__()
        
    def _try_register(self):
        super()._try_register()
        if self.alt_access_code:
            resp = requests.post(
                url=urljoin(self.kernel_url, f"{self.executor_iface_version}/worker/register"),
                data={"name": self.alt_access_code, "endpoint": self.get_reg_endpoint()}
            )
            if not resp.ok or resp.text == "Failed":
                raise RuntimeWarning("The server failed to register to kernel.")

    def _shut_down(self):
        super()._shut_down()
        if self.alt_access_code:
            try:
                response = requests.post(
                    urljoin(self.kernel_url, f"{self.executor_iface_version}/worker/unregister"),
                    data={"name": self.alt_access_code,"endpoint": self.get_reg_endpoint()}
                )
                if not response.ok or response.text == "Failed":
                    raise RuntimeWarning()
                else:
                    logger.info("Unregistered from kernel.")
            except requests.exceptions.ConnectionError as e:
                logger.warning("Failed to unregister from kernel")

    def extend_arguments(self, parser):
        parser.add_argument('--lang', default="en", help='The language code to internationalize the aplication. See \'lang/\'')
        parser.add_argument('--database', default=None, type=str, help='The path the the pre-built database.')
        parser.add_argument('--api_base_url', default="http://127.0.0.1/", help='The API base URL of Kuwa multi-chat WebUI')
        parser.add_argument('--api_key', default=None, help='The API authentication token of Kuwa multi-chat WebUI')
        parser.add_argument('--limit', default=3072, type=int, help='The limit of the LLM\'s context window')
        parser.add_argument('--model', default=None, help='The model name (access code) on Kuwa multi-chat WebUI')
        parser.add_argument('--mmr_k', default=6, type=int, help='Number of chunk to retrieve after Maximum Marginal Relevance (MMR).')
        parser.add_argument('--mmr_fetch_k', default=12, type=int, help='Number of chunk to retrieve before Maximum Marginal Relevance (MMR).')
        parser.add_argument('--chunk_size', default=512, type=int, help='The charters in the chunk.')
        parser.add_argument('--chunk_overlap', default=128, type=int, help='The overlaps between chunks.')
        parser.add_argument('--alt_access_code', default=None, type=str, help='The alternate access code.')

    def setup(self):
        i18n.load_path.append(f'lang/{self.args.lang}/')
        i18n.config.set("error_on_missing_translation", True)
        i18n.config.set("locale", self.args.lang)

        self.pre_built_db = self.args.database
        self.llm = KuwaLlmClient(
            base_url = self.args.api_base_url,
            kernel_base_url = self.kernel_url,
            model=self.args.model,
            auth_token=self.args.api_key
        )
        self.document_store = DocumentStore(
            mmr_k = self.args.mmr_k,
            mmr_fetch_k = self.args.mmr_fetch_k,
            chunk_size = self.args.chunk_size,
            chunk_overlap = self.args.chunk_overlap
        )
        self.docqa = DocQa(
            document_store = self.document_store,
            vector_db = self.pre_built_db,
            llm = self.llm,
            lang = self.args.lang
        )
        self.alt_access_code = self.args.alt_access_code
        self.proc = False

    def extract_last_url(self, chat_history: list):
        """
        Find the latest URL provided by the user and trim the chat history to there.
        """

        url = None
        begin_index = 0
        user_records = list(filter(lambda x: not x["isbot"], chat_history))
        for i, record in enumerate(reversed(user_records)):

            urls_in_msg = re.findall(r'^(https?://[^\s]+)$', record["msg"])
            if len(urls_in_msg) != 0: 
                url = urls_in_msg[-1]
                begin_index = len(chat_history) - i - 1
                break
        
        return url, chat_history[begin_index:]

    async def llm_compute(self, data):
        chat_history = json.loads(data.get("input"))
        auth_token = data.get("user_token") or self.args.api_key
        url = None

        try:
            if self.pre_built_db == None:
                url, chat_history = self.extract_last_url(chat_history)
                if url == None : raise NoUrlException(i18n.t('docqa.no_url_exception'))
            
                chat_history = [{"isbot": False, "msg": None}] + chat_history[1:]
            self.proc = True
            response_generator = self.docqa.process(urls=[url], chat_history=chat_history, auth_token=auth_token)
            async for reply in response_generator:
                if not self.proc:
                    await response_generator.aclose()
                yield reply

        except NoUrlException as e:
            yield str(e)

        except Exception as e:
            await asyncio.sleep(2) # To prevent SSE error of web page.
            logger.exception('Unexpected error')
            yield i18n.t("docqa.default_exception_msg")
    
    async def abort(self):
        if self.proc:
            self.proc = False
            logger.debug("aborted")
            return "Aborted"
        return "No process to abort"

if __name__ == "__main__":
    executor = DocQaExecutor()
    executor.run()