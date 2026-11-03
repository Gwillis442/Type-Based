#!/bin/sh
# by: Chan Rain, Garrett Willis, Kevin Tieu
# Type-Based
# start.sh
# Starts the local PHP server and opens the menu.

cd "$(dirname "$0")"

if ! command -v php >/dev/null 2>&1; then
    echo "PHP was not found. Install PHP and try again."
    exit 1
fi

php -S localhost:8000 &
sleep 1

if command -v open >/dev/null 2>&1; then
    open "http://localhost:8000/Index.php"
elif command -v xdg-open >/dev/null 2>&1; then
    xdg-open "http://localhost:8000/Index.php"
else
    echo "Open http://localhost:8000/Index.php"
fi

wait
