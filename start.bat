@echo off
REM by: Chan Rain, Garrett Willis, Kevin Tieu
REM Type-Based
REM start.bat
REM Starts the local PHP server and opens the menu.

cd /d "%~dp0"
where php >nul 2>&1
if errorlevel 1 (
    echo PHP was not found. Install PHP and add it to PATH.
    pause
    exit /b 1
)
start "" php -S localhost:8000
timeout /t 1 >nul
start "" http://localhost:8000/Index.php
