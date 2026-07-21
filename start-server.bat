@echo off
echo ================================================
echo Starting Monarch Hotel Development Server
echo ================================================
echo.
echo Server will start at: http://127.0.0.1:8000
echo Press Ctrl+C to stop the server
echo.
echo ================================================
echo.

cd /d "%~dp0"
php -S 127.0.0.1:8000 -t public

pause
