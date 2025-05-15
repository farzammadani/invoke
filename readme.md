# 🚀 Invoke

![Invoke Logo](https://i.imgur.com/HfXxZso.png)


**Invoke** is a lightweight, YAML-driven cronjob runner built with Symfony and Docker.

It allows developers to define HTTP-based jobs as simple `.yaml` files, and have them executed on schedule — with minimal dependencies, no dashboard, and no database configuration overhead (except for tracking execution history).

---

## ✨ Features

- 🧾 Jobs defined in `config/cronjobs/*.yaml`
- 📆 Cron-style scheduling (via `dragonmantank/cron-expression`)
- 🔄 Runs jobs every minute using Symfony console command
- 💾 Stores run history (UUID, timestamp, status, duration, message) in PostgreSQL
- 🧪 Includes a local stub server for testing HTTP behavior
- 🐳 Docker-based with clean separation of app + database + cron

---

## 📁 YAML Job Format Example

```yaml
name: "Notify"
schedule: "53 11 * * *"
url: "http://localhost:9999"
method: POST
payload:
  keep_days: 30
headers:
  env:
    valueFrom: "CronValueProviders\\ApiEndpointTokenProvider"
enabled: true
````

---

## 🚀 Usage

### 1. Clone & boot

```bash
git clone https://github.com/your-org/invoke.git
cd invoke
cp .env .env.local
make up
make composer-install
```

### 2. Run the stub server (for local testing)

```bash
make stub-server
```

Then test a real HTTP job via:

```bash
php bin/console dev:job:run
```

### 3. Apply database migration

```bash
make doctrine-create-db
make doctrine-make-migration
make doctrine-migrate
```

### 4. Run scheduled jobs manually

```bash
php bin/console job:perform-due
```

---

## ⏱ Automate: Run Jobs Every Minute via Docker

Add a cron container in `docker-compose.yml` that runs:

```bash
php bin/console job:perform-due
```

Or use host cron to call it into the container:

```bash
* * * * * docker exec invoke_app php /var/www/bin/console job:perform-due
```

---

## 🧠 Architecture Summary

* `YamlJobParser` — parses all `.yaml` files
* `DueTimeEvaluator` — checks if job is due
* `JobRunner` — executes via HTTP
* `PerformedJobsRepository` — tracks if job ran, stores run metadata
* `PerformDueJobsCommand` — the orchestrator

---

## 🧪 Testing

```bash
make test-integration GROUP=kiwi
```

You can also run stubbed `dev:job:run` commands against a local stub server.

---

## 🧰 Tools

* PHP 8.2
* Symfony 6+
* PostgreSQL 16
* Docker / Docker Compose
* Codeception (for integration tests)

---

## 🧑‍💻 Contributing

This project is meant to be simple by design. Please keep contributions lightweight and config-first wherever possible.
