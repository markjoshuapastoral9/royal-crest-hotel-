#!/usr/bin/env pwsh
# Push to GitHub script

Write-Host "Pulling latest changes from GitHub..." -ForegroundColor Cyan
git pull origin main --rebase --no-edit

Write-Host "`nPushing local commits to GitHub..." -ForegroundColor Cyan
git push origin main

Write-Host "`nDone! Check Railway for auto-deployment." -ForegroundColor Green
