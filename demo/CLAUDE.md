# Demo App – CLAUDE.md

## What is this

A simple Symfony 7.2 user management app used for **live Claude Code demos**. It has intentionally planted bugs that will be found and fixed during training sessions.

## Tech Stack

- Symfony 7.2, PHP 8.4
- MySQL 8.0 (Doctrine ORM)
- Docker Compose (app + db)
- No frontend framework – Twig templates only

## Running

```bash
docker compose up -d
```

App: http://localhost:8080 | DB: localhost:3307 (user: demo / pass: demo123)

## Project Structure & Commands

Managed by CARL domain `DEMO_APP` – automatically injected when recall keywords match.
To inspect: ask Claude to show the DEMO_APP CARL domain.

## Lessons

When you find a bug, issue, or notable problem in this project, **always** create a lesson file:

- **Location**: `lessons/` directory in this project root
- **Format**: One Markdown file per finding, named descriptively (e.g., `bug-email-validation.md`)
- **Template**:
  ```markdown
  # [Short title]

  ## What was wrong
  [Description of the issue]

  ## Root cause
  [Why it happened — not just where]

  ## Fix
  [What was changed to resolve it]

  ## Takeaway
  [What to watch out for in the future]
  ```
- **When**: Create the lesson file immediately after fixing a bug or identifying an issue — do not wait for the user to ask
- **Read on session start**: Check `lessons/` for existing lessons before starting bugfix work, to avoid re-investigating known issues
