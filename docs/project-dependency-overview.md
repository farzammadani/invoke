Here’s a clear **dependency map** for each of your 6 core files in `src/JobSystem/` — showing **which classes depend on which**.

---

## 📁 `src/JobSystem/` Dependency Overview

---

### ✅ `PerformDueJobsCommand.php`

**Top-level controller of the process. Depends on:**

* `YamlJobParser`
* `DueTimeEvaluator`
* `PerformedJobsRepository`
* `JobRunner`

> 💡 Think of this as the "orchestrator" that ties everything together.

---

### ✅ `YamlJobParser.php`

**Parses YAML into `Job` objects. Depends on:**

* Symfony YAML component (`Yaml`)
* `Job` (constructs instances)

---

### ✅ `DueTimeEvaluator.php`

**Checks if a job is due. Depends on:**

* `Job`
* `dragonmantank/cron-expression`

---

### ✅ `PerformedJobsRepository.php`

**Handles state tracking & persistence. Depends on:**

* Doctrine DB (or Symfony DBAL)
* `Job` (uses job name)
* Optionally: `JobRunResult` class (if you create one)

---

### ✅ `JobRunner.php`

**Executes the HTTP request. Depends on:**

* `Job`
* Symfony HTTP Client (or Guzzle)

---

### ✅ `Job.php`

**Pure value object. Depends on:**

* Nothing
* Used by: **All other files**

---

## 📊 Visual Overview (Dependency Direction)

```text
PerformDueJobsCommand
├── YamlJobParser
│   └── Job
├── DueTimeEvaluator
│   └── Job
├── PerformedJobsRepository
│   └── Job
├── JobRunner
    └── Job
```

✅ `Job` is the only class that everyone else uses
✅ `PerformDueJobsCommand` is the only one that depends on *everything*

---

Let me know if you'd like me to generate all of these files now (with full code or just annotated skeletons).
