## graphify

This project has a knowledge graph at graphify-out/ with god nodes, community structure, and cross-file relationships.

When the user types `/graphify`, invoke the `skill` tool with `skill: "graphify"` before doing anything else.

Rules:
- For codebase questions, first run `graphify query "<question>"` when graphify-out/graph.json exists. Use `graphify path "<A>" "<B>"` for relationships and `graphify explain "<concept>"` for focused concepts. These return a scoped subgraph, usually much smaller than GRAPH_REPORT.md or raw grep output.
- Dirty graphify-out/ files are expected after hooks or incremental updates; dirty graph files are not a reason to skip graphify. Only skip graphify if the task is about stale or incorrect graph output, or the user explicitly says not to use it.
- If graphify-out/wiki/index.md exists, use it for broad navigation instead of raw source browsing.
- Read graphify-out/GRAPH_REPORT.md only for broad architecture review or when query/path/explain do not surface enough context.
- After modifying code, run `graphify update .` to keep the graph current (AST-only, no API cost).

## dependencies documentation

This skeleton depends on multiple klan1 composer packages. Each ships MD docs that are the source of truth for how the package is used in this project.

Required reading before working on any task in this project:

- Search `vendor/klan1/*/` for all `*.md` files and load them (README.md, PHP_COMPATIBILITY.md, AGENTS.md, CLAUDE.md, MAZER.md, etc.).
- Also scan `vendor/**/README.md` and `vendor/**/CHANGELOG.md` for any other dependency that ships docs (smarty, phpmailer, brick/math, ramsey/uuid, whichbrowser/parser, endyjasmi/cuid, gettext, psr/*).
- Do not skip these on the assumption they are generic READMEs — klan1 packages ship project-specific instructions in their MDs (k1.lib-html especially).
- Re-read affected package MDs after any `composer update` since upstream docs may have changed.
- When a task touches a specific package, prefer reading its MD over guessing from PHP source.

Other dependency package sources live at sibling paths under `../` (k1.lib, k1.lib-bootstrap, k1.lib-html, k1.lib-crudlexs, k1app-template-mazer) and may also be referenced — consult them when the vendor MD is missing or stale.
