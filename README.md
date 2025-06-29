# 日報・メモ管理ミニアプリ（Laravel + Vue3 + TypeScript + Docker構成）

本リポジトリは、本番サブドメイン分離（SPA＋API）でCSRF/CORS/セッションも突破した日報・メモ管理アプリを、
Docker＋Nginx＋SSL＋GitHub Actions（CI/CD）で自動デプロイまで一気通貫で構築した実践テンプレです。

---

## 📢 デモ・サンプルユーザー

- **SPA本番デモ:** [https://spa.codeshift-lab.com](https://spa.codeshift-lab.com)
- **API本番:** [https://api.codeshift-lab.com](https://api.codeshift-lab.com)
- **サンプルユーザー**
    - Email: `test@example.com`
    - Password: `password`

---

## 🛠 技術スタック

- **Laravel 12.x**（Fortify認証／Sanctum／API／MySQL）
- **Vue 3.x**（TypeScript, Vite, SPA構成）
- **Docker**（nginx, php-fpm, mysql, node）
- **CI/CD:** GitHub Actions（自動デプロイ、docker-compose再起動）
- **SSL:** Let's Encrypt（Nginx/サブドメイン運用）

---

## 🗂 ディレクトリ構成（抜粋）

- apps/
- fortify-docker-app/
- backend/ # Laravel API（Fortify認証・Sanctum対応）
- frontend/ # Vue3 SPA（TypeScript + Vite）
- docker/ # Nginx/PHP/MySQL/Docker設定
- www/
- spa-portfolio/ # デプロイ済みSPA静的ファイル
- portfolio-attendance/ # 勤怠管理アプリ
- portfolio-flea-market/ # フリマアプリ

## 機能一覧
- ログイン/ログアウト
- ユーザー情報取得・表示
- 未ログイン時リダイレクト（ルートガード）
- SPA+APIサーバー分離運用（CORS/CSRF/セッション対応済）

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
- SPAビルド成果物（dist） → /var/www/spa-portfolio/dist/
- APIサーバー → /apps/fortify-docker-app/backend
- GitHub ActionsでCI/CD自動化（SPA静的ファイルを本番サーバーに自動上書き）
- Nginx/SSL/サブドメイン設定もDockerイメージに組み込み済み

# サブドメインSPA＋API構成テンプレ（Vue3 + Laravel + Docker）
flowchart LR
    A[Vue3 SPA<br>https://spa.codeshift-lab.com] --API通信/認証--> B[Laravel API<br>https://api.codeshift-lab.com]
    B --セッションクッキー/Sanctum--> A

## 🚧 よくあるハマりポイント・FAQ

| 症状                         | 主な原因                              | 解決策・チェックポイント                               |
|------------------------------|---------------------------------------|--------------------------------------------------------|
| 419: CSRF token mismatch     | SPA→APIのCSRFヘッダ自動付与ミス       | `X-XSRF-TOKEN` を**手動でヘッダ付与**                  |
| Cookieが送られない           | `.env`のSESSION_SAME_SITE設定ミス     | `.env`で `SESSION_SAME_SITE=None` を**必ず明記**       |
| Actionsのデプロイ失敗        | ディレクトリ構成やパス指定の不一致    | デプロイ先のパス・本番ディレクトリを**一致させる**      |
| Cookieドメイン不一致         | `.env`のSESSION_DOMAINの設定ミス      | `.env`で `SESSION_DOMAIN=.codeshift-lab.com` を指定     |
| ブラウザでログイン状態が飛ぶ | Dockerや.env反映漏れ・キャッシュ残存  | `docker-compose restart`やブラウザのCookie全削除       |
| POSTがCORSエラー             | CORS/Cookie設定・Nginx漏れ            | Nginx/axiosで`withCredentials`とCORS設定を再点検       |

---

### 📝 補足解説

- **CSRF token mismatch**  
  → axiosの`withCredentials: true`でも自動付与されない場合、手動で`X-XSRF-TOKEN`ヘッダを付与すると確実です。
- **SESSION_SAME_SITE**  
  → クロスドメイン運用時は`None`を必ず明記。SSL環境必須です。
- **デプロイ失敗**  
  → GitHub ActionsやSCPの「cd先」や「Gitリポジトリのルート」が現状と合っているかを常に確認。

---