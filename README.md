# 勤怠管理ミニアプリ（Laravel + Vue3 + TypeScript + Docker構成）

## 概要
- Laravel (Fortify認証) + Vue3 + TypeScript + Docker の統合開発環境です。
- SPAによるログイン、ユーザー情報取得、セッション維持を実装。
- 本番応募・ポートフォリオ想定の「実案件ミニマム構成」例。

## 本番デモURL
- フロントエンド: http://153.126.164.246:5173/
- APIサーバー: http://153.126.164.246:8080/

## サンプルユーザー
- Email: test@example.com
- Password: password

## 技術スタック
- Laravel 12.x（Fortify/認証/Sanctum）
- Vue 3.x (TypeScript, Vite)
- Docker（nginx, php-fpm, mysql, node）
- API認証（セッションベース）
- GitHub Actions（CI/CD対応予定の場合）

## 機能一覧
- ログイン/ログアウト
- ユーザー情報取得・表示
- 未ログイン時リダイレクト（ルートガード）
- SPA+APIサーバー分離運用

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
