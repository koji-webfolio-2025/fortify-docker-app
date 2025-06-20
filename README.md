# 勤怠管理ミニアプリ（Laravel + Vue3 + TypeScript + Docker構成）

## 概要
- Laravel (Fortify認証) + Vue3 + TypeScript + Docker の統合開発環境
- SPAによるログイン、ユーザー情報取得、セッション認証対応
- ポートフォリオ・実案件応募向けの最小構成例

## 本番デモURL
- フロントエンド: https://spa.codeshift-lab.com
- APIサーバー: https://api.codeshift-lab.com

## サンプルユーザー
- Email: test@example.com
- Password: password

## 技術スタック
- Laravel 12.x（Fortify/認証/Sanctum）
- Vue 3.x (TypeScript, Vite)
- Docker（nginx, php-fpm, mysql, node）
- API認証（セッションベース）
- GitHub Actions（CI/CD対応自動デプロイ）

## 機能一覧
- ログイン/ログアウト
- ユーザー情報取得・表示
- 未ログイン時リダイレクト（ルートガード）
- SPA+APIサーバー分離運用

## ディレクトリ構成（抜粋）
- apps/
- fortify-docker-app/
- backend/ # Laravel API
- frontend/ # Vue3 SPA
- docker/ # Docker設定

## ローカル開発・起動方法

```sh
# clone & 環境変数設定
git clone https://github.com/koji-webfolio-2025/fortify-docker-app.git
cd fortify-docker-app
cp backend/.env.example backend/.env
# .envを必要に応じて修正

# Docker起動
docker compose up -d --build

# DB初期化
docker compose exec app php artisan migrate --seed
```

## SPAをローカルで開発ビルドしたい場合
```sh
cd frontend
cp .env.example .env
npm install
npm run dev
# → http://localhost:5173 でSPA確認
```

## 本番デプロイ構成
- 本番SPAの静的ファイル（dist）は VPSサーバ `/var/www/spa-portfolio/dist/` 配置が唯一の配信ディレクトリ
- GitHub Actions（CI/CD）で `frontend/dist/*` を `/var/www/spa-portfolio/dist/` へ自動上書きデプロイ
- サーバroot, nginx設定も `/var/www/spa-portfolio/dist` 配下のみ参照

# サブドメインSPA＋API構成テンプレ（Vue3 + Laravel + Docker）

## 概要
- 本構成はVue3 SPA（TypeScript）とLaravel API（Fortify/Sanctum認証）をDocker＋Nginx＋SSL（Let's Encrypt）で運用
- SPA, API, 管理画面…全てサブドメイン単位で分離可能
- 本番環境の自動デプロイにGitHub Actionsを使用

## 構成図
- [spa.codeshift-lab.com] → Vue3 SPA（ビルド済み静的ファイル配信）
- [api.codeshift-lab.com] → Laravel API（Fortify認証/CSRF対策/セッション運用）

## 認証方式のハマりポイントと対策
- CSRF token mismatch対策：SPA→API連携時、`X-XSRF-TOKEN`を明示的にヘッダ付与
- .env：`SESSION_SAME_SITE=None` を**必ず明記**
- Docker再起動でenv・設定の反映漏れ防止

## 開発・運用Tips
- サーバー構築・SSL・Nginx設定もテンプレート化
- 複数アプリを同時運用可能
- CI/CDによる自動反映、デプロイ時のサービス一時停止防止策も解説

## 詳細手順・FAQ
- よくあるエラーと解決策
  - 419: Cookie/SameSite/ヘッダ/CORS全部を点検せよ！
  - Actions失敗: デプロイ先パスと本番ディレクトリを一致させよ！
- ディレクトリ構成・ボリューム管理・Nginxの具体例も付属
