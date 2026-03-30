#!/usr/bin/env node
// Hook script: git add + commit + push the file that was just edited/written
const { execSync } = require("child_process");

const REPO = "c:/Users/optit/OneDrive/.wdc/Documentos/rentaturista-remastered";

let raw = "";
process.stdin.on("data", (chunk) => (raw += chunk));
process.stdin.on("end", () => {
  let filePath = "";
  try {
    const payload = JSON.parse(raw);
    filePath = payload.tool_input?.file_path ?? payload.tool_response?.filePath ?? "";
  } catch {
    process.exit(0);
  }

  // Only act on files inside this repo
  const normalized = filePath.replace(/\\/g, "/");
  if (!normalized.startsWith(REPO)) process.exit(0);

  const rel = normalized.slice(REPO.length + 1);

  try {
    execSync(`git add "${rel}"`, { cwd: REPO, stdio: "inherit" });

    // Only commit if there's something staged
    const diff = execSync("git diff --cached --name-only", { cwd: REPO }).toString().trim();
    if (!diff) process.exit(0);

    const msg = `auto: update ${rel}`;
    execSync(`git commit -m "${msg}"`, { cwd: REPO, stdio: "inherit" });
    execSync("git push", { cwd: REPO, stdio: "inherit" });
  } catch (e) {
    // Never block Claude on git errors
    process.exit(0);
  }
});
