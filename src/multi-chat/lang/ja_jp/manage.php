<?php

return [
    'route' => '管理',
    'interface.header' => '管理者管理インターフェース',
    'button.delete' => '削除',
    'button.update' => '更新',
    'button.create' => '作成',
    'button.save' => '保存',
    'button.yes' => 'はい、確認します',
    'button.no' => 'いいえ、キャンセル',
    'button.cancel' => 'キャンセル',
    'button.close' => '閉じる',
    'button.accept' => '同意する',

    //Tabs
    'tab.groups' => 'グループ',
    'tab.users' => 'ユーザー',
    'tab.llms' => 'モデル',
    'tab.settings' => 'システム設定',

    //Groups
    'button.new_group' => '新規グループ',
    'header.create_group' => '新しいグループを作成',
    'label.tab_permissions' => 'タブの権限',
    'label.invite_code' => '招待コード',
    'label.group_name' => '名前',
    'label.invite_code' => '招待コード',
    'placeholder.invite_code' => '招待コード',
    'label.describe' => '説明',
    'placeholder.group_name' => 'グループ名',
    'placeholder.group_detail' => 'グループの詳細',
    'label.read' => '読み取り',
    'label.delete' => '削除',
    'label.update' => '更新',
    'label.llm_permission.disabled' => 'モデル使用権限（無効化されたモデル）',
    'label.llm_permission.enabled' => 'モデル使用権限（有効化されたモデル）',
    'header.edit_group' => 'グループの編集',
    'hint.group_updated' => 'グループが正常に更新されました！',
    'hint.group_created' => 'グループが正常に作成されました！',
    'modal.delete_group.header' => '本当にこのグループを削除しますか',

    //Users
    'header.menu' => 'メインメニュー',
    'header.group_selector' => 'グループ選択',
    'header.fuzzy_search' => '曖昧検索',
    'header.create_user' => 'ユーザー作成',
    'label.group_selector' => 'グループからユーザーを絞り込む',
    'label.fuzzy_search' => '名前またはメールアドレスでユーザーを検索',
    'label.create_user' => 'ユーザー設定を作成',

    'create_user.header' => '新規アカウントを作成',
    'create_user.joined_group' => '参加したグループ',
    'label.members' => 'メンバー',
    'label.other_users' => 'グループ外のユーザー',
    'button.return_group_list' => 'グループリストに戻る',
    'placeholder.search_user' => 'メールアドレスまたは名前を検索',
    'hint.enter_to_search' => '検索するにはEnterキーを押してください',

    'group_selector.header' => 'ユーザーの編集',
    'placeholder.email' => 'ユーザーのメールアドレス',
    'placeholder.username' => 'ユーザー名',
    'label.name' => '名前',
    'modal.delete_user.header' => '本当にユーザーを削除しますか',
    'label.email' => 'メールアドレス',
    'label.password' => 'パスワード',
    'label.update_password' => 'パスワードを更新',
    'label.detail' => '詳細',
    'placeholder.new_password' => '新しいパスワード',
    'label.require_change_password' => '次回のログイン時にパスワードの変更を要求する',
    'label.extra_setting'=>'追加設定',
    'label.created_at'=>"作成日時",
    'label.updated_at'=>'更新日時',

    //LLMs
    'button.new_model' => '新規モデル',
    'label.enabled_models' => '有効なモデル',
    'label.disabled_models' => '無効なモデル',
    'header.create_model' => 'モデル設定を作成',
    'modal.create_model.header' => 'この設定を作成しますか？',
    'label.model_image' => 'モデル画像',
    'label.model_name' => 'モデル名',
    'label.order' => '表示順',
    'label.link' => '外部リンク',
    'placeholder.description' => 'このモデルの説明',
    'label.version' => 'バージョン',
    'label.access_code' => 'アクセスコード',
    'placeholder.link' => 'モデルの外部関連リンク',
    'header.update_model' => 'モデル設定の編集',
    'label.description' => '説明',
    'modal.update_model.header' => 'この言語モデル設定を更新しますか',
    'modal.delete_model.header' => 'この言語モデル設定を削除しますか',

    //setting
    'header.settings' => 'システム設定',
    'label.settings' => 'すべてのシステム設定についてはこちらを調整してください',
    'label.agent_API' => 'エージェントAPI接続先',
    'label.allow_register' => '登録を許可する',
    'button.reset_redis' => 'Redisキャッシュをリセット',
    'hint.saved' => '保存されました',
    'hint.redis_cache_cleared' => 'Redisキャッシュがクリアされました',
    'label.need_invite' => '登録には招待コードが必要です',
    'label.footer_warning' => 'ダイアログの下部警告',
    'label.safety_guard_API' => '安全保護API接続先',
    'label.anno' => 'システム公告',
    'label.tos' => '利用規約',

    //Permissions
    'perm.Room_update_import_chat' => 'チャットのインポート',
    'perm.Room_update_new_chat' => '新規チャットの作成',
    'perm.Room_update_feedback' => 'フィードバックの提供',
    'perm.Room_update_send_message' => 'メッセージの送信',
    'perm.Room_update_react_message' => '追加のメッセージ操作ボタン',
    'perm.Room_read_export_chat' => 'チャットのエクスポート',
    'perm.Room_delete_chatroom' => 'チャットルームの削除',
    'perm.Chat_update_react_message' => '追加のメッセージ操作ボタン',
    'perm.Dashboard_read_statistics' => '統計情報の閲覧',
    'perm.Dashboard_read_blacklist' => 'ブラックリストの閲覧',
    'perm.Dashboard_read_feedbacks' => 'フィードバックの閲覧',
    'perm.Dashboard_read_logs' => 'システムログの閲覧',
    'perm.Dashboard_read_safetyguard' => 'セキュリティガードの閲覧',
    'perm.Dashboard_read_inspect' => 'メッセージブラウザの閲覧',
    'perm.Chat_update_detail_feedback' => '詳細なフィードバック',
    'perm.Room_update_detail_feedback' => '詳細なフィードバック',
    'perm.Chat_update_send_message' => 'メッセージの送信',
    'perm.Chat_update_new_chat' => '新規チャットの作成',
    'perm.Chat_update_upload_file' => 'ファイルのアップロード',
    'perm.Chat_update_feedback' => 'モデル使用のフィードバック',
    'perm.Chat_update_import_chat' => 'チャットのインポート',
    'perm.Chat_read_access_to_api' => 'ウェブサイトAPIの使用',
    'perm.Chat_read_export_chat' => 'チャットのエクスポート',
    'perm.Chat_delete_chatroom' => 'チャットルームの削除',
    'perm.Profile_update_api_token' => 'ウェブサイトAPIキーの更新',
    'perm.Profile_update_name' => 'ユーザー名の変更',
    'perm.Profile_update_email' => 'メールアドレスの変更',
    'perm.Profile_update_password' => 'パスワードの変更',
    'perm.Profile_update_external_api_token' => '外部APIトークンの更新',
    'perm.Profile_read_api_token' => 'ウェブサイトAPIトークンの読み取り',
    'perm.Profile_delete_account' => 'アカウントの削除',

    'perm.Chat_update_detail_feedback.describe' => 'より詳細なフィードバックを提供するための回答の更新',
    'perm.Room_update_detail_feedback.describe' => 'より詳細なフィードバックを提供するための回答の更新',
    'perm.Profile_update_name.describe' => '自分のアカウント名を更新する権限',
    'perm.Profile_update_email.describe' => '自分の電子メールアドレスを更新する権限',
    'perm.Profile_update_password.describe' => '自分のパスワードを更新する権限',
    'perm.Profile_update_external_api_token.describe' => 'ウェブサイトに保存されている外部APIトークンを更新する権限',
    'perm.Profile_read_api_token.describe' => 'ウェブサイトAPIキーを読み取る権限',
    'perm.Profile_delete_account.describe' => '自分のアカウントを削除する権限',
    'perm.Profile_update_api_token.describe' => 'ウェブサイトAPIキーの更新権限',
    'perm.Chat_read_access_to_api.describe' => 'ウェブサイトAPIの使用権限',
    'perm.Chat_update_send_message.describe' => 'チャットでメッセージを送信する権限（作成は影響しません）',
    'perm.Room_update_send_message.describe' => 'チャットでメッセージを送信する権限（作成は影響しません）',
    'perm.Chat_update_new_chat.describe' => 'チャットを作成する権限',
    'perm.Room_update_new_chat.describe' => 'チャットを作成する権限',
    'perm.Chat_update_upload_file.describe' => 'ファイルをアップロードする権限（チャットの作成権限も必要です）',
    'perm.Chat_update_feedback.describe' => 'モデル使用のフィードバックを送信する権限',
    'perm.Room_update_feedback.describe' => 'モデル使用のフィードバックを送信する権限',
    'perm.Room_delete_chatroom.describe' => 'チャットルームを削除する権限',
    'perm.Chat_delete_chatroom.describe' => 'チャットルームを削除する権限',
    'perm.Chat_read_export_chat.describe' => 'チャット履歴をエクスポートする権限',
    'perm.Room_read_export_chat.describe' => 'チャット履歴をエクスポートする権限',
    'perm.Chat_update_import_chat.describe' => 'チャット履歴をインポートする権限（チャットの作成権限も必要です）',
    'perm.Room_update_import_chat.describe' => 'チャット履歴をインポートする権限（チャットの作成権限も必要です）',
    'perm.Chat_update_react_message.describe' => 'メッセージに追加の操作ボタンを使用する権限（引用、翻訳などの機能）',
    'perm.Room_update_react_message.describe' => 'メッセージに追加の操作ボタンを使用する権限（引用、翻訳などの機能）',
    'perm.Dashboard_read_statistics.describe' => '統計情報にアクセスする権限',
    'perm.Dashboard_read_blacklist.describe' => 'ブラックリストにアクセスする権限',
    'perm.Dashboard_read_feedbacks.describe' => 'フィードバックにアクセスする権限',
    'perm.Dashboard_read_logs.describe' => 'システムログにアクセスする権限',
    'perm.Dashboard_read_safetyguard.describe' => 'セキュリティガードにアクセスする権限',
    'perm.Dashboard_read_inspect.describe' => 'メッセージブラウザにアクセスする権限',
];
