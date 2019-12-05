@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../anax/anax-cli/src/anax.bash
bash "%BIN_TARGET%" %*
