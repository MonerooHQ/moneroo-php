# CLAUDE.md

Guidance for Claude Code and other AI agents working in this repository.

## Project overview

moneroo-php is the official PHP SDK for the Moneroo payment API, enabling PHP applications to initialize and verify payment collections and payouts across African mobile money providers. It is distributed as a Composer package (`moneroo/moneroo-php`) and targets PHP 7.4+. It has no framework dependency and can be used in plain PHP, Laravel, or any other PHP project.

## Tech stack

- PHP 7.4, 8.0, 8.1, 8.2 (all supported)
- GuzzleHttp/Guzzle ^7.7 (HTTP client)
- PHPUnit ^9.6 (testing)
- PHPStan level 4 (static analysis)
- axazara/php-cs (php-cs-fixer wrapper, AxaZara house style)
- fakerphp/faker ^1.23 (test data generation)

## Getting started

```bash
# Install production dependency
composer require moneroo/moneroo-php

# For development / contributing
composer install
```

No `.env` file is required. Pass your Moneroo secret key directly when instantiating the SDK.

## Common commands

| Task | Command |
|---|---|
| Test | `composer test` |
| Lint (dry-run) | `composer sniff` |
| Format | `composer format` |
| Static analysis | `composer analyse` |
| Unused deps scan | `composer unused` |

## Architecture

The SDK is a small, framework-agnostic library with no config files or service providers.

- `src/Moneroo.php` — base class; accepts `$secretKey`, optional `$devMode` flag and `$baseUrl` override; uses the `Request` trait for HTTP communication.
- `src/Payment.php` — extends `Moneroo`; exposes `init()`, `verify()`, `get()`, and `markAsProcessed()` for payment collection flows.
- `src/Payout.php` — extends `Moneroo`; exposes `init()`, `verify()`, and `get()` for payout flows.
- `src/Payment/Status.php` and `src/Payout/Status.php` — typed constants for transaction states (`INITIATED`, `PENDING`, `SUCCESS`, `FAILED`, `CANCELLED`).
- `src/Traits/Request.php` — sends HTTP requests via Guzzle, decodes JSON responses, and maps HTTP status codes to typed exceptions.
- `src/Exceptions/` — one exception class per HTTP error condition (400, 401, 403, 404, 406, 422, 503, 5xx).
- `src/Configs/Config.php` — SDK version (`1.0.0`), default base URL (`https://api.moneroo.io/v1`), and request timeout (30 s).
- `tests/` — PHPUnit test suite; run with random execution order and strict settings.

## Conventions

- Code style is enforced by `axazara/php-cs` (php-cs-fixer), configured in `.php-cs-fixer.dist.php`. Run `composer format` before every commit.
- Static analysis uses PHPStan at level 4 (`composer analyse`). All new code must pass without errors.
- Every change must be accompanied by new or updated tests, an updated `CHANGELOG.md`, and a version bump in `Config::VERSION`.
- `devMode` flag: set to `true` in tests or local development to point the SDK at a custom `$baseUrl` instead of the production API.
- `sendRequest()` is injectable with a `GuzzleHttpClient` instance, enabling mock-based unit tests without real HTTP calls.
- KISS principle: keep classes small, single-purpose, and free of framework coupling.

## Git Conventions

### 1. Branch names

Enforced regex (`branch_name_pattern`):
```
^(feature|fix|hotfix|chore|docs|refactor|test|ci|perf|build|style)/[a-z0-9._-]+$
```

- Lowercase only, kebab-case after the prefix, **max 50 characters** total.
- Use the full word `feature/` — **never** `feat/` (the short `feat` form is only for commit message types).
- Include the ticket id when relevant: `feature/AXA-123-add-stripe` (the ticket id is lowercased to satisfy the pattern — e.g. `feature/axa-123-add-stripe`).
- **Never** use a `claude/` prefix or any prefix outside the allowed set.
- `main`, `release`, `staging` are permanent protected branches — never push to them directly.
- If a branch is misnamed, rename it before pushing: `git branch -m <old> <new>`.

### 2. Commit messages
Enforced regex (`commit_message_pattern`), applied to **every** commit:
```
^(feat|fix|docs|style|refactor|perf|test|build|ci|chore|revert)(\([^)]+\))?!?: .+
```
- Lowercase type, optional scope in parens, optional `!` for breaking changes, subject after `: `.
- Subject starts with a lowercase letter and has no trailing period.
- Examples: `feat(checkout): add Apple Pay support`, `fix(api): handle expired tokens`, `chore(deps): bump axios from 1.7.2 to 1.15.2`, `refactor!: drop Node 18 support`.
- Do not rewrite Dependabot commits — `chore(deps): bump X from a to b` is already enforced via `.github/dependabot.yml`.

### 3. Files that are always rejected
Never stage or commit:
- `.env`, `.env.*` (only `.env.example` and `.env.sample` are allowed), `**/.env`, `**/.env.*`
- Private keys: `**/id_rsa{,.pub}`, `**/id_dsa`, `**/id_ecdsa`, `**/id_ed25519`, `**/.ssh/id_*`
- Credentials: `**/.aws/credentials`, `**/credentials.json`, `**/service-account.json`, `**/firebase-adminsdk-*.json`, `**/secrets.{yml,yaml}`
- Extensions: `*.pem`, `*.key`, `*.p12`, `*.pfx`, `*.jks`, `*.keystore`, `*.ppk`, `*.asc`, `*.gpg`
- Any file larger than 100 MB (use git LFS)
If a secret is needed, use `.env.example` for env vars and an external secret manager for credentials.

### Pull requests targeting `main`, `release`, `staging`
All three are protected — a PR is required (direct push blocked):
- 1 approval, all conversations resolved, **squash or rebase merge only** (linear history enforced — no merge commits).
- Commits must be GPG- or SSH-signed. Signing is required for `main` (`required-signatures-main` ruleset).
- The PR **title** becomes the squash commit message and must match the commit-message regex above (enforced on all three branches).

**Required workflows run on PRs whose base is `main` only** (not `release`/`staging`): `Branch naming convention`, `PR title — Conventional Commits`, and `PR size labeler`.
If a check shows `Waiting for workflow to run` for over a minute, the third-party action is likely missing from the enterprise allowlist.

When the branch-naming or PR-title check fails, the baseline bot auto-posts rename/title suggestions, following the enforced regex patterns.
If the bot's suggestions are incorrect, edit the PR title or branch name to match the required format.

### Pre-push checklist
Before running `git push`:
1. Branch name matches the regex.
2. Every commit in `origin/main..HEAD` matches the commit pattern (`git log --format=%s origin/main..HEAD`).
3. No staged file is in the blocked paths/extensions list.
4. Commits are signed if the target is `main`.

If any check fails, fix it locally rather than letting the server reject the push.
