# System_IM

## Deploying the PHP app to Render

GitHub Pages only serves static files and cannot run this app's PHP pages or MySQL-backed APIs. Deploy the repository to Render as a Docker web service instead; the root `index.php` remains the app entry point.

1. Create a MySQL database. Render's managed relational database is PostgreSQL, which this app does not use. One compatible option is Railway MySQL; enable its public TCP connection so the Render service can reach it. Public database traffic may incur network charges.
2. Initialize the database with `database/schema.sql`. The schema creates and selects a database named `roadtrip_db`.
3. In Render, create a Blueprint from this repository and use `render.yaml`. Set `DB_HOST`, `DB_PORT`, `DB_NAME` (`roadtrip_db`), `DB_USER`, and `DB_PASSWORD` using the connection details from your MySQL provider. Keep these values in Render's environment settings; do not commit credentials.
4. Deploy and open the Render service URL. The health check at `/login.php` verifies that the PHP app can start and connect to MySQL.
5. The schema seeds `admin@roadtrip.local` with the default password `admin123`. Change it immediately after the first login.

For local XAMPP use, the app retains its existing defaults (`localhost:3307`, database `roadtrip_db`, user `root`, empty password). You can override them with the same `DB_*` environment variables.
