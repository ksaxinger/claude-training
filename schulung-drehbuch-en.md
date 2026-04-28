# Training: Claude Code for Webconia Developers

Duration: ~40 min | Just follow step by step.

---

## Before the Training

Start the demo app (in the `claude-training` folder):

```bash
cd demo && docker compose up -d
```

Verify it's running: open http://localhost:8080 in the browser.
Should show a user management page with 4 test users.

Then start Claude Code (in the `claude-training` folder):

```bash
cd .. && claude
```

---

## Block 1: My Setup (~10 min)

"Let me show you how my Claude Code is configured."

---

### 1.1 – Global CLAUDE.md

"This is the most important file. It applies to ALL projects."

```
Show me my global CLAUDE.md
```

Show: Rules like "No code without being asked", "Never commit", CliftonStrengths table, workflow preferences.

---

### 1.2 – Project CLAUDE.md

"Each project can have its own CLAUDE.md. Here's the one for this training repo."

```
Show me the CLAUDE.md of this project
```

Show: Project-specific context (stack, purpose, conventions).

---

### 1.3 – Settings & Environment Variables

"This is where I configure which model I use and how Claude behaves."

```
Show me my settings.json
```

Explain:
- `"model": "opus"` → main model
- `"CLAUDE_CODE_EFFORT_LEVEL": "max"` → maximum analysis depth
- `"CLAUDE_CODE_SUBAGENT_MODEL": "sonnet"` → sub-agents use cheaper model
- `hooks` → scripts that run automatically on every prompt (CARL)

---

### 1.4 – User Profile

"Claude knows me. Here's my profile that it loads every session."

```
Show me my user profile
```

Show: Name, stack, projects, workflow, rules.

---

### 1.5 – Memory Files

"Claude remembers things between sessions for each project."

```
Which memory files do I have for the Sybos project?
```

Explain: "When I say 'never do that again', it ends up here. Next session he still knows."

---

### 1.6 – Skills

"You can also teach Claude custom workflows – so-called Skills."

```
Show me the sybos-bugfix skill
```

Explain: "This is a structured bugfix workflow that Claude activates when needed."

---

### 1.7 – MCP Servers (brief)

"Claude can also use external tools – like a browser or our ticket system."

```
Show me my MCP server configuration
```

Explain: Playwright = browser automation, Linear = ticket system.

---

### 1.8 – CARL (Context-Aware Rule Layer)

"CARL is my rule system. It injects context-specific rules into every Claude session – automatically, based on keywords."

```
Show me all CARL domains
```

Show: List of domains (GLOBAL, BUGFIX, DEMO_APP, etc.) with rule counts and recall keywords.

Then drill into the demo domain:

```
Show me the DEMO_APP CARL domain
```

Show: The 5 rules with project structure, tech stack, commands, and test users.

Explain:
- "I moved the project structure out of CLAUDE.md into CARL"
- "When I mention 'demo app' in any session, these rules get injected automatically"
- "CARL has domains for different contexts – BUGFIX, ARCHITECTURE, DATABASE, etc."
- "Rules can be added, staged for review, or created from decisions"

"This means Claude always has the right context – without me having to repeat things."

---

## Block 2: The Demo App & Its Bugs (~5 min)

"We have a small Symfony app running – a user management system. Before we let Claude loose on it, let me show you what we're working with."

Browser: http://localhost:8080

---

### 2.1 – Show the App

Walk through the UI briefly:
- User list with 4 test users (admin, korbi, testuser, inactive)
- You can create users, toggle status, change roles, delete users
- Search function

---

### 2.2 – Reveal the Hidden Bugs

"We've intentionally planted 5 bugs in the codebase. Here's what Claude needs to find:"

Show this list (on a slide or just tell them):

| # | Bug | Where | Severity |
|---|-----|-------|----------|
| 1 | **SQL Injection** – string interpolation instead of prepared statement | `searchUsers()` | Critical |
| 2 | **MD5 password hashing** instead of `password_hash()` | `createUser()` | Critical |
| 3 | **Null pointer** – no check if user exists before `remove()` | `deleteUser()` | High |
| 4 | **Logic bug** – toggle always sets `active = true` instead of toggling | `toggleUserStatus()` | Medium |
| 5 | **Missing role validation** – accepts any string | `changeRole()` | Medium |

"Let's see how many Claude catches – and how it explains and fixes them."

---

## Block 3: Live Coding with Claude (~15 min)

---

### 3.1 – Have Claude Explain the Code

```
Explain the code in demo/src/Service/UserService.php – what does the class do, how is it structured?
```

The team sees: Claude reads the file, analyzes the structure, explains clearly.

---

### 3.2 – Find Bugs

```
Find all bugs and security vulnerabilities in demo/src/Service/UserService.php
```

The team sees: Claude systematically discovers the problems.

Compare with the list from Block 2 – did it find all 5?

---

### 3.3 – Fix a Bug

Take the most critical one:

```
Fix the SQL injection bug in the searchUsers method in demo/src/Service/UserService.php
```

The team sees: Claude changes the code precisely, explains root cause and fix.

---

### 3.4 – Create a Custom Agent

"Now let me show you how to create your own custom agent – a reusable workflow that Claude can execute on demand."

```
/skill-writer
```

When prompted, describe the agent:

```
Create a skill called "bug-finder". It should analyze a given file for bugs, security issues, and code smells. For each finding it should report: what the problem is, why it's dangerous, and how to fix it. Output should be a structured list sorted by severity.
```

Claude creates the skill interactively. Show the result briefly.

Then test it immediately:

```
/bug-finder demo/src/Controller/UserController.php
```

"You can create agents for any repeatable workflow – code reviews, migrations, documentation, anything."

---

### 3.5 – Bonus: Strategic Planning

If there's time left:

```
Create a plan for how to secure the entire demo app and fix all bugs. Just plan, don't change anything.
```

Shows: Claude can also think strategically, not just write code.

---

## Block 4: Q&A (~5 min)

Just answer questions. If someone wants to see something specific, show it spontaneously.

Useful spontaneous demos:
- `What do you know about me?`
- `Explain the difference between Opus and Sonnet`
- `Which skills do I have installed?`

---

## Checklist Before the Training

- [ ] `cd demo && docker compose up -d` → app running on http://localhost:8080
- [ ] 4 test users visible in browser (admin, korbi, testuser, inactive)
- [ ] Claude Code started in the `claude-training` folder
- [ ] Screen sharing works
- [ ] Terminal font size large enough for everyone

## Cleanup After the Training

```bash
cd demo && docker compose down
```
