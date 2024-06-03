import json
import logging
from .base_executor import BaseExecutor
from .modelfile import Modelfile

logger = logging.getLogger(__name__)

class LLMExecutor(BaseExecutor):
    """
    The specialized class for serving LLM process.
    """

    async def serve(self, header, content):
        param = dict(content)
        history = json.loads(param.pop("input", "[]"))
        history = to_openai_chat_format(history)
        history = rectify_chat_history(history)
        modelfile = Modelfile.from_json(param.pop("modelfile", "[]"))
        modelfile.parameters["_lang"] = header.get("Accept-Language")
        for k, v in param.items():
            modelfile.parameters[f"_{k}"] = v
        
        logger.debug(f"History: {history}")
        logger.debug(f"Modelfile: {modelfile}")
        async for chunk in self.llm_compute(history=history, modelfile=modelfile):
            yield chunk

    async def llm_compute(self, history: list[dict], modelfile:Modelfile):
        raise NotImplementedError("LLM Executor should implement the \"llm_compute\" method.")

def to_openai_chat_format(history: list):
    """
    Convert the chat history from Kuwa's format to OpenAI's format.
    """
    history = [
        {
            "role": "assistant" if i["isbot"] else "user",
            "content": i["msg"]
        }
        for i in history
    ]
    return history

def rectify_chat_history(history: list):
    """
    Ensure the history begin with "user."
    """
    if len(history)==0: return history
    first_user_idx = 0
    while history[first_user_idx]["role"] != "user" and first_user_idx+1 < len(history)-1:
        first_user_idx += 1
    history = history[first_user_idx:]
    return history

if __name__ == "__main__":
    executor = LLMExecutor()
    executor.run()