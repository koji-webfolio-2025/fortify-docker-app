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