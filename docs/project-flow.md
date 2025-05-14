Perfect — those are clearer and more descriptive. Here's the **updated minimal architecture** using your preferred names:

---

## ✅ Final Pragmatic File Plan (with your names)

### 📁 `src/JobSystem/`

| File                          | Purpose                                                |
| ----------------------------- | ------------------------------------------------------ |
| `YamlJobParser.php`           | Load and parse all YAML files into Job objects         |
| `DueTimeEvaluator.php`        | Checks if a job is due based on current time           |
| `JobRunner.php`               | Executes job via HTTP and returns result               |
| `PerformedJobsRepository.php` | Persists execution logs and checks last-run timestamps |
| `Job.php`                     | Value object representing a job                        |
| `PerformDueJobsCommand.php`   | Symfony command that drives the whole process          |

---

## 🔁 Final Execution Flow (Every Minute)

1. `PerformDueJobsCommand` runs (via system cron)
2. `YamlJobParser` loads all YAML files → `Job` objects
3. `DueTimeEvaluator` checks each job for "due now"
4. `PerformedJobsRepository` checks if already ran this minute
5. If not:

    * `JobRunner` sends HTTP request
    * Result is stored in `PerformedJobsRepository`

---

## ✅ Next Step Options

Would you like me to now:

* ✅ Generate **all 6 PHP files** (skeletons or full)?
* ✅ Create **migration** for `performed_jobs` table?
* ✅ Register the Symfony console command?

Let me know how much you'd like scaffolded right now, and I’ll generate exactly that.
