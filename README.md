![Type-Based](Assets/images/type-based-logo.jpg)

# Type-Based

A browser typing game with falling letters, difficulty modes, accounts, and player statistics.

**Version:** 2.0  
**Stack:** PHP, JavaScript, CSS, SQLite

## Running the project
PHP is required. On a Mac or Linux, also install the SQLite extension. Accounts and stats use the game’s own sign-in.

Windows:

```bat
start.bat
```

Mac or Linux:

```bash
chmod +x start.sh
./start.sh
```

Or start it by hand from the project folder:

```bash
php -S localhost:8000
```

Then open http://localhost:8000/Index.php

A local run uses the SQLite file in `data/`.

## Screenshots
Menu

![Menu](Assets/images/readme-menu.png)

Game

![Game](Assets/images/readme-game.png)

Stats

![Stats](Assets/images/readme-stats.png)

## Project structure
- `Index.php` — main menu: mode and song selection, sign-in, and account creation
- `FrontEnd/` — the game page, the stats page, and the word lists
- `BackEnd/` — login, account creation, and saving or loading player stats
- `Database/` — the local SQLite schema
- `nrs-projects/` — old campus Oracle files, not used locally
- `CSS/` — layout and control styles
- `Assets/` — images and audio used by the game

## Future updates for version 4.0
- `Security` — Improve potential Security flaws related to the game.
- `Grade-Based Dictionary Game` — Source vocabulary words from 1st-12th grade as well as common words one may encounter after 12th grade. And add it to a custom game that require player to type properly by copying Word-Parts of Speech-Meaning as well as repeating what was just learnt by typing without copying.
## Team
Type-Based

## Contributors
- Chan Rain
- Garrett Willis
- Kevin Tieu

## License
See `LICENSE`.

**Last updated:** October 20, 2026
