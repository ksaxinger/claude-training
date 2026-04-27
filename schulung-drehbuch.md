# Schulung: Claude Code für Webconia-Entwickler

Dauer: ~35 min | Einfach Schritt für Schritt abtippen.

---

## Vor der Schulung

Demo-App starten (im `claude-training` Ordner):

```bash
cd demo && docker compose up -d
```

Prüfen ob es läuft: http://localhost:8080 im Browser öffnen.
Sollte eine Benutzerverwaltung mit 4 Testusern zeigen.

Danach Claude Code starten (im `claude-training` Ordner):

```bash
cd .. && claude
```

---

## Block 1: Mein Setup (~10 min)

"Ich zeig euch erstmal wie mein Claude Code konfiguriert ist."

---

### 1.1 – Globale CLAUDE.md

"Das hier ist die wichtigste Datei. Gilt für ALLE Projekte."

```
Zeig mir meine globale CLAUDE.md
```

Zeigen: Regeln wie "Kein Code ohne Aufforderung", "Nie committen", CliftonStrengths-Tabelle, Arbeitsweise.

---

### 1.2 – Projekt-CLAUDE.md

"Jedes Projekt kann eine eigene CLAUDE.md haben. Hier ist die von diesem Training-Repo."

```
Zeig mir die CLAUDE.md von diesem Projekt
```

Zeigen: Projektspezifischer Kontext (Stack, Zweck, Konventionen).

---

### 1.3 – Settings & Environment-Variablen

"Hier stell ich ein welches Modell ich nutze und wie Claude sich verhält."

```
Zeig mir meine settings.json
```

Erklären:
- `"model": "opus"` → Hauptmodell
- `"CLAUDE_CODE_EFFORT_LEVEL": "max"` → maximale Analysetiefe
- `"CLAUDE_CODE_SUBAGENT_MODEL": "sonnet"` → Sub-Agents nutzen günstigeres Modell
- `hooks` → Scripts die bei jedem Prompt automatisch laufen (CARL)

---

### 1.4 – User Profile

"Claude kennt mich. Hier ist mein Profil das er jede Session lädt."

```
Zeig mir mein User-Profil
```

Zeigen: Name, Stack, Projekte, Arbeitsweise, Regeln.

---

### 1.5 – Memory Files

"Pro Projekt merkt sich Claude Dinge zwischen Sessions."

```
Welche Memory-Files habe ich für das Sybos-Projekt?
```

Erklären: "Wenn ich sage 'mach das nie wieder', landet das hier. Nächste Session weiß er es noch."

---

### 1.6 – Skills

"Man kann Claude auch eigene Workflows beibringen – sogenannte Skills."

```
Zeig mir den sybos-bugfix Skill
```

Erklären: "Das ist ein strukturierter Bugfix-Workflow den Claude bei Bedarf aktiviert."

---

### 1.7 – MCP Servers (kurz)

"Claude kann auch externe Tools nutzen – z.B. einen Browser oder unser Ticket-System."

```
Zeig mir meine MCP Server Konfiguration
```

Erklären: Playwright = Browser-Automatisierung, Linear = Tickets.

---

## Block 2: Live Demo mit der App (~15 min)

"Wir haben eine kleine Symfony-App laufen – eine Benutzerverwaltung mit ein paar eingebauten Problemen."

Browser zeigen: http://localhost:8080

---

### 2.1 – Code erklären lassen

```
Erkläre mir den Code in demo/src/Service/UserService.php – was macht die Klasse, wie ist sie aufgebaut?
```

Die Kollegen sehen: Claude liest die Datei, analysiert Struktur, erklärt verständlich.

---

### 2.2 – Bugs finden lassen

```
Finde alle Bugs und Sicherheitslücken in demo/src/Service/UserService.php
```

Die Kollegen sehen: Claude findet systematisch die Probleme.

Erwartete Funde:
1. **SQL Injection** in `searchUsers()` – String-Interpolation statt Prepared Statement
2. **MD5 Passwort-Hashing** in `createUser()` – unsicher, sollte `password_hash()` sein
3. **Null-Pointer** in `deleteUser()` – kein Check ob User existiert
4. **Logik-Bug** in `toggleUserStatus()` – setzt immer `active = true` statt zu toggeln
5. **Fehlende Rollen-Validierung** in `changeRole()` – akzeptiert jeden String

---

### 2.3 – Bug fixen lassen

Den schlimmsten Bug nehmen:

```
Fix den SQL Injection Bug in der searchUsers Methode in demo/src/Service/UserService.php
```

Die Kollegen sehen: Claude ändert gezielt den Code, erklärt Root Cause und Fix.

---

### 2.4 – Skill live erstellen

"Jetzt zeig ich euch wie man Claude eigene Workflows beibringt."

```
Erstelle einen Skill namens "code-erklaerer". Er soll eine Datei lesen und verständlich erklären: Was macht der Code, welche Abhängigkeiten hat er, wie ist er strukturiert. Zielgruppe sind Entwickler die den Code zum ersten Mal sehen.
```

Claude erstellt den Skill mit dem Skill-Writer. Kurz das Ergebnis zeigen.

---

### 2.5 – Bonus: Planen lassen

Falls noch Zeit:

```
Erstelle einen Plan wie man die gesamte Demo-App absichern und die Bugs fixen könnte. Nur planen, nichts ändern.
```

Zeigt: Claude kann auch strategisch denken, nicht nur Code schreiben.

---

## Block 3: Fragen (~5 min)

Einfach Fragen beantworten. Falls jemand was Bestimmtes sehen will, spontan zeigen.

Nützliche Spontan-Demos:
- `Was weißt du über mich?`
- `Erkläre mir den Unterschied zwischen Opus und Sonnet`
- `Welche Skills habe ich installiert?`

---

## Checkliste vor der Schulung

- [ ] `cd demo && docker compose up -d` → App läuft auf http://localhost:8080
- [ ] 4 Testuser sichtbar im Browser (admin, korbi, testuser, inactive)
- [ ] Claude Code im `claude-training` Ordner gestartet
- [ ] Screen-Sharing funktioniert
- [ ] Terminal-Schriftgröße groß genug für alle

## Aufräumen nach der Schulung

```bash
cd demo && docker compose down
```
