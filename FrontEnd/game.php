<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * game.php
 * Runs one typing round: word selection, falling squares, scoring, and the end-of-round summary.
 */
    session_start();

?>  
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Type-Based</title>
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css"
        integrity="sha512-6p+GTq7fjTHD/sdFPWHaFoALKeWOU9f9MPBoPnvJEWBkGS4PKVVbCpMps6IXnTiXghFbxlgDE8QRHc3MU91lJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="../CSS/animate.css">
    <style>
        .titleBar {
            background-color: transparent;
            color: #000;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-family: 'Lexend Deca', sans-serif;
            width: 100%;
            display: flex;
            line-height: 0;
            align-items: center;
            margin: 0px;
            pointer-events: none;
        }

        .titleHPBar {
            font-size: 40px;
            flex-grow: 1;
            text-align: left;
        }

        .titleWidget {
            display: flex;
            white-space: nowrap;
            align-items: center;
            background-color: black;
            color: white;
            line-height: 0;
            padding-left: 15px;
            padding-right: 15px;
            font-size: 17.5px;
            border-radius: 100vmin;
            margin-left: 10px;
            float: right;
        }

        .titleBar .flex-end {
            display: flex;
            flex-grow: 1;
            justify-content: flex-end;
        }
    </style>
</head>

<body>

    <div id="roundSummary" style="display:none; position:fixed; inset:0; background:rgba(242,243,245,0.96); z-index:20; align-items:center; justify-content:center;">
        <div style="text-align:center; font-family:'Lexend Deca', sans-serif;">
            <h2>Round complete</h2>
            <p>Mode: <span id="summaryMode"></span></p>
            <p>Score: <span id="summaryScore"></span></p>
            <p>Accuracy: <span id="summaryAccuracy"></span>%</p>
            <button id="summaryContinue" onclick="playAgain()">Play again</button>
            <button id="summaryMenu" onclick="backToMenu()">Main menu</button>
            <button id="summaryStats" onclick="viewStats()">View stats</button>
        </div>
    </div>



    <div id="roundControls" style="position:fixed; top:12px; left:50%; transform:translateX(-50%); z-index:15;">
        <button id="pauseButton" onclick="togglePause()">Pause</button>
        <button id="restartButton" onclick="restartRound()">Restart</button>
        <label for="volumeSlider">Vol</label>
        <input id="volumeSlider" type="range" min="0" max="100" value="80">
    </div>

<button id = "gameStartButton" onclick="startGame()">
    <i class="ri-play-fill"></i>
    <span>PLAY GAME</span>
</button>

    <div class="titleBar">
        <div class="titleHPBar">
            <i class="ri-heart-fill"></i>
            <i class="ri-heart-fill"></i>
            <i class="ri-heart-fill"></i>
        </div>
        <div class="flex-end">

            <div class="titleWidget">
                <p>
                    <i class="ri-star-fill"></i>
                    <span id="score">0</span>
                </p>
            </div>

            <div class="titleWidget">
                <p>
                    <i class="ri-play-fill"></i>
                    <span id="selectedMode">Mode Select</span>
                </p>
            </div>
            <div style = "display:none" class="titleWidget">
                <p>
                    <i class="ri-album-fill"></i>
                    <span id="selectedSong">Song Select</span>
                </p>
            </div>

            <div class="titleWidget" id="signInStatus" style="background-color:green">
                <p>
                    <i class="ri-checkbox-circle-fill"></i>
                    <span>Signed in</span>
                </p>

            </div>
        </div>
    </div>

    <h1 id="gameWord">
        <span id="letter1">-</span>
        <span id="letter2">-</span>
        <span id="letter3">-</span>
        <span id="letter4">-</span>
        <span id="letter5">-</span>
    </h1>

    <div class="gameSpace">

        <svg xmlns="http://www.w3.org/2000/svg" x="0" y="0" width="100%" height="200" viewBox="0 0 100 200" preserveAspectRatio="none">
            <line x1="0" y1="30" x2="100%" y2="30" stroke-width="7.5px" stroke="black" />
            <line x1="0" y1="70" x2="100%" y2="70" stroke-width="7.5px" stroke="black" />
            <line x1="0" y1="110" x2="100%" y2="110" stroke-width="7.5px" stroke="black" />
            <line x1="0" y1="150" x2="100%" y2="150" stroke-width="7.5px" stroke="black" />
            <line x1="0" y1="190" x2="100%" y2="190" stroke-width="7.5px" stroke="black" />
        </svg>

        <div class="squareContainer">
            <div id="square1" class="square" style="top: 5px; left: 100%; background-color: red;">
                <span id="square1contents">1</span>
            </div>

            <div id="square2" class="square" style="top: 45px; left: 100%; background-color: orange;">
                <span id="square2contents">2</span>
            </div>

            <div id="square3" class="square" style="top: 85px; left: 100%; background-color: yellow;">
                <span id="square3contents">3</span>
            </div>

            <div id="square4" class="square" style="top: 125px; left: 100%; background-color: green;">
                <span id="square4contents">4</span>
            </div>

            <div id="square5" class="square" style="top: 165px; left: 100%; background-color: blue;">
                <span id="square5contents">5</span>
            </div>

            <div id="squareBorder">
                <div id="squareBorderGradient"></div>
            </div>

        </div>

    </div>




    <script>
        var settings = {}

        var squareTransitionProperty = "left 5s linear";
        var squareBPMProperty = 120;

        var squaresSent = 0;
        var squaresCorrect = 0;
        var wrongPresses = 0;

        var userAccuracy = 0;

        /*
         * Shows the saved mode and song on the round screen.
         * return nothing
         */
        function displaySettingsObject() {
            if (localStorage.getItem("settingsObject") == null) {
            } else {
                settings = JSON.parse(localStorage.getItem("settingsObject"));

                if (settings.mode == undefined) {
                    settings.mode = "Mode Select";
                } else if (settings.mode == "easy") {
                    settings.mode = "Easy";
                    squareTransitionProperty = "left 5s linear";
                    squareBPMProperty = 120;
                } else if (settings.mode == "med") {
                    settings.mode = "Medium";
                    squareTransitionProperty = "left 3s linear";
                    squareBPMProperty = 240;
                } else if (settings.mode == "hard") {
                    settings.mode = "Hard";
                    squareTransitionProperty = "left 2s linear";
                    squareBPMProperty = 180;
                }

                if (settings.song == undefined) {
                    settings.song = "Song Select";
                } else if (settings.song == "easy") {
                    settings.song = "Easy";
                } else if (settings.song == "medium") {
                    settings.song = "Medium";
                } else if (settings.song == "hard") {
                    settings.song = "Hard";
                }

                document.getElementById("selectedMode").innerHTML = settings.mode;
                document.getElementById("selectedSong").innerHTML = settings.song;
            }
        }

        /*
         * Reads the saved sign-in and shows the username.
         * return nothing
         */
        function initSignInState() {
            var userObject = JSON.parse(localStorage.getItem("userObject"));
            if (userObject == null || userObject.signedIn == false) {
                document.getElementById('signInStatus').style.display = 'none';
            } else {
                document.getElementById('signInStatus').style.display = 'block';
            }

            if (localStorage.getItem("settingsObject") == null) {
                window.location.href = "../Index.php";
            }
        }

        window.onload = function () {
            initSignInState();
            displaySettingsObject();
            document.body.style.opacity = 1;
        }


        /*
         * Outlines the letter the player should type next.
         * index - the letter position, 1 through 5
         * return nothing
         */
        function markNextLetter(index) {
            for (var i = 1; i <= 5; i++) {
                var el = document.getElementById("letter" + i);
                if (!el) continue;
                el.style.outline = (i === index) ? "2px solid #111" : "none";
            }
        }

        /*
         * Picks a five-letter word from the current list and shows it.
         * Standard rounds use the American list; packs and modes override it.
         * return the selected word
         */
        function selectWord() {
            var pool = (typeof englishFive !== "undefined") ? englishFive : wordbank;
            if (settings.pack === "music" && typeof musicPack !== "undefined") pool = musicPack;
            if (settings.pack === "code" && typeof codePack !== "undefined") pool = codePack;
            if (typeof recentWords === "undefined") recentWords = [];
            var selected_word = pool[Math.floor(Math.random() * pool.length)];
            var tries = 0;
            // Skip repeated letters, and skip a word that was just used.
            while ((selected_word[0] == selected_word[1] || selected_word[0] == selected_word[2] || selected_word[0] == selected_word[3] || selected_word[0] == selected_word[4] || selected_word[1] == selected_word[2] || selected_word[1] == selected_word[3] || selected_word[1] == selected_word[4] || selected_word[2] == selected_word[3] || selected_word[2] == selected_word[4] || selected_word[3] == selected_word[4] || recentWords.indexOf(selected_word) !== -1) && tries < 40) {
                selected_word = pool[Math.floor(Math.random() * pool.length)];
                tries++;
            }
            recentWords.push(selected_word);
            if (recentWords.length > 12) recentWords.shift();
            document.getElementById("letter1").innerHTML = selected_word[0].toUpperCase();
            document.getElementById("letter2").innerHTML = selected_word[1].toUpperCase();
            document.getElementById("letter3").innerHTML = selected_word[2].toUpperCase();
            document.getElementById("letter4").innerHTML = selected_word[3].toUpperCase();
            document.getElementById("letter5").innerHTML = selected_word[4].toUpperCase();
            nextLetterIndex = 0;
            markNextLetter(1);
            return selected_word;

        }

        var score = 0;
        var nextLetterIndex = 0;
        var keysDown = {};
        var streak = 0;
        var wordsCorrect = 0;
        var feverActive = false;


        var toneContext = null;
        /*
         * Plays a short tone when sound is on.
         * frequency - the tone in hertz
         * duration - how long the tone lasts, in seconds
         * return nothing
         */
        function playTone(frequency, duration) {
            if (!settings.sound) return;
            try {
                if (!toneContext) toneContext = new (window.AudioContext || window.webkitAudioContext)();
                var osc = toneContext.createOscillator();
                var gain = toneContext.createGain();
                osc.frequency.value = frequency;
                gain.gain.value = 0.05;
                osc.connect(gain);
                gain.connect(toneContext.destination);
                osc.start();
                osc.stop(toneContext.currentTime + duration);
            } catch (e) {}
        }

        /*
         * Adds points to the score and updates the score display.
         * points - the base points for this hit
         * return nothing
         */
        function updateScore(points) {
            var gained = points * Math.max(1, streak) * (feverActive ? 2 : 1);
            score += gained
            console.log(score);
            document.getElementById("score").innerHTML = score;
        }

        /*
         * Plays a short animation on a falling letter.
         * square - the letter square id
         * animationClass - the animation name
         * return nothing
         */
        function triggerAnimation(square, animationClass) {
            var squareElement = document.getElementById(square);
            squareElement.style.animation = "none"; // Reset animation
            squareElement.offsetHeight; // Force a reflow
            squareElement.style.animation = `${animationClass} 0.5s 1`; // Apply new animation
        }


        var gamePaused = false;
        var roundTimer = null;
        /*
         * Author: Kevin Tieu
         * Pauses or resumes the falling letters.
         * return nothing
         */
        function togglePause() {
            gamePaused = !gamePaused;
            document.getElementById("pauseButton").textContent = gamePaused ? "Resume" : "Pause";
            var audio = document.getElementById("roundMusic");
            if (audio) {
                if (gamePaused) audio.pause();
                else audio.play().catch(function () {});
            }
            var ids = ["square1", "square2", "square3", "square4", "square5"];
            ids.forEach(function (id) {
                var el = document.getElementById(id);
                if (!el) return;
                if (gamePaused) {
                    var currentLeft = window.getComputedStyle(el).left;
                    el.style.transition = "none";
                    el.style.left = currentLeft;
                } else if (el.style.left && el.style.left !== "100%") {
                    el.style.transition = squareTransitionProperty;
                    el.style.left = "-10%";
                }
            });
        }


        /*
         * Author: Kevin Tieu
         * Clears the round timer and score, then starts a new round.
         * return nothing
         */
        function restartRound() {
            if (roundTimer) { clearInterval(roundTimer); roundTimer = null; }
            gamePaused = false;
            var pauseButton = document.getElementById("pauseButton");
            if (pauseButton) pauseButton.textContent = "Pause";
            score = 0;
            streak = 0;
            wordsCorrect = 0;
            feverActive = false;
            squaresSent = 0;
            squaresCorrect = 0;
            wrongPresses = 0;
            userInputs = {};
            document.getElementById("score").textContent = "0";
            document.querySelectorAll(".titleHPBar i").forEach(function (heart) {
                heart.classList.remove("ri-heart-line");
                heart.classList.add("ri-heart-fill");
            });
            ["square1", "square2", "square3", "square4", "square5"].forEach(function (id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.style.transition = "none";
                el.style.left = "100%";
                el.style.opacity = "1";
            });
            startGame();
        }



        /*
         * Stops and removes the round audio element.
         * return nothing
         */
        function stopMusic() {
            var audio = document.getElementById("roundMusic");
            if (audio) { audio.pause(); audio.remove(); }
        }

        /*
         * Starts the round audio when music is on.
         * return nothing
         */
        var currentSongList = [];
        var songIndex = 0;
        var musicVolume = 0.8;

        /*
         * Author: Kevin Tieu
         * Returns easy, medium, or hard from the selected mode.
         * return the mode folder name
         */
        function songModeName() {
            var mode = (settings.mode || "easy").toLowerCase();
            if (mode.indexOf("hard") !== -1) return "hard";
            if (mode.indexOf("med") !== -1) return "medium";
            return "easy";
        }

        /*
         * Author: Kevin Tieu
         * Sets the playing song to the slider volume.
         * return nothing
         */
        function applyVolume() {
            var audio = document.getElementById("roundMusic");
            if (audio) audio.volume = musicVolume;
        }

        /*
         * Author: Kevin Tieu
         * Plays one song from the current list and advances when it ends.
         * index - the position in the song list
         * return nothing
         */
        function playSongAt(index) {
            if (!currentSongList.length) return;
            songIndex = ((index % currentSongList.length) + currentSongList.length) % currentSongList.length;
            var audio = document.getElementById("roundMusic");
            if (!audio) {
                audio = document.createElement("audio");
                audio.id = "roundMusic";
                audio.addEventListener("ended", function () {
                    playSongAt(songIndex + 1);
                });
                document.body.appendChild(audio);
            }
            audio.volume = musicVolume;
            audio.src = "../Assets/audio/" + songModeName() + "/" + currentSongList[songIndex];
            audio.play().catch(function () {});
        }

        /*
         * Author: Kevin Tieu
         * Loads the mode folder, shuffles it, and starts playback.
         * return nothing
         */
        function startMusic() {
            if (!settings.music) { stopMusic(); return; }
            if (document.getElementById("roundMusic")) return;
            var saved = localStorage.getItem("musicVolume");
            if (saved !== null) musicVolume = Number(saved);
            var slider = document.getElementById("volumeSlider");
            if (slider) slider.value = Math.round(musicVolume * 100);
            var mode = songModeName();
            var request = new XMLHttpRequest();
            request.open("GET", "../BackEnd/list_songs.php?mode=" + mode, true);
            request.onreadystatechange = function () {
                if (request.readyState !== 4 || request.status !== 200) return;
                var songs = JSON.parse(request.responseText || "[]");
                for (var i = songs.length - 1; i > 0; i--) {
                    var j = Math.floor(Math.random() * (i + 1));
                    var swap = songs[i];
                    songs[i] = songs[j];
                    songs[j] = swap;
                }
                var picked = settings.song || "all";
                if (picked !== "all" && songs.indexOf(picked) !== -1) {
                    currentSongList = [picked];
                } else {
                    currentSongList = songs;
                }
                songIndex = 0;
                playSongAt(0);
            };
            request.send();
        }

        var volumeSlider = document.getElementById("volumeSlider");
        if (volumeSlider) {
            volumeSlider.addEventListener("input", function () {
                musicVolume = Number(volumeSlider.value) / 100;
                localStorage.setItem("musicVolume", String(musicVolume));
                applyVolume();
            });
        }

        /*
         * Starts a round: picks a word and sends the letters in order.
         * return nothing
         */
        function startGame() {
            startMusic();

            document.getElementById('gameStartButton').style.display = "none";

            // Clear previous states
            userInputs = {}; // Reset user inputs for the new game

            var squareInterval = 60000 / squareBPMProperty;
            var squares = ["square1", "square2", "square3", "square4", "square5"];
            var activeSquares = new Set();
            var sentSquares = new Set();

            var selectedWord = selectWord();
            var selectedWordArray = selectedWord.split("");
            console.log(selectedWordArray);

            squares.forEach(function (square, index) {
            document.getElementById(`${square}contents`).innerHTML = selectedWordArray[index].toUpperCase();
            });

            setupZoneObserver(squares, activeSquares);
            setupGlobalInputListener(squares, activeSquares, userInputs);

            var nextLetter = 0;
            roundTimer = setInterval(function () {
            if (gamePaused) { return; }
            if (nextLetter < squares.length) {
                var selectedSquare = squares[nextLetter];
                nextLetter++;
                sendSquare(selectedSquare);
                squaresSent++;
                sentSquares.add(selectedSquare);
                activeSquares.add(selectedSquare);
            } else {
                clearInterval(interval);
            }

            // Speed up the interval gradually
            if (squareInterval > 1000) { // Set a minimum interval limit
                squareInterval *= 0.975; // Decrease interval by 2.5%
            }
            }, squareInterval);
            var interval = roundTimer;
        }

        let observer; // Declare globally to track the observer.

        /*
         * Watches which letters are on screen so only those can be typed.
         * squares - the five letter square ids
         * activeSquares - the set of letters currently on screen
         * return nothing
         */
        function setupZoneObserver(squares, activeSquares) {
            // Disconnect any existing observer to prevent multiple observers
            if (observer) observer.disconnect();

            observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    var square = entry.target.id;
                    if (entry.isIntersecting) {
                        var letter = document.getElementById(`${square}contents`).innerHTML;
                        activeSquares.add(square);
                        console.log(`Square ${square} entered zone with letter: ${letter}`);
                    } else {
                        activeSquares.delete(square);
                        console.log(`Square ${square} left zone`);
                    }
                });
            }, { root: null, threshold: 0.5 });

            squares.forEach(square => {
                observer.observe(document.getElementById(square));
            });
        }


        var onKeyPress = null;
        /*
         * Author: Kevin Tieu
         * Accepts only the next letter in the word and ignores extra keys.
         * squares - the five letter square ids
         * activeSquares - the set of letters currently on screen
         * userInputs - the letters already typed
         * return nothing
         */
        function setupGlobalInputListener(squares, activeSquares, userInputs) {
            if (onKeyPress) document.removeEventListener('keydown', onKeyPress);
            onKeyPress = function (event) {
                if (gamePaused || event.repeat) { return; }
                if (event.key.length !== 1) { return; }
                var userLetter = event.key.toUpperCase();
                keysDown[userLetter] = true;
                if (Object.keys(keysDown).length > 1) { return; }
                if (nextLetterIndex >= squares.length) { return; }
                var square = squares[nextLetterIndex];
                var correctLetter = document.getElementById("letter" + (nextLetterIndex + 1)).textContent.trim().toUpperCase();
                if (userLetter !== correctLetter) {
                    wrongPresses++;
                    updateAccuracy();
                    var expected = document.getElementById("letter" + (nextLetterIndex + 1));
                    expected.style.color = "red";
                    setTimeout(function () { if (expected.style.color === "red") expected.style.color = "black"; }, 150);
                    return;
                }
                if (!activeSquares.has(square)) { return; }
                userInputs[square] = true;
                nextLetterIndex++;
                markNextLetter(nextLetterIndex + 1);
                triggerAnimation(square, "tada");
                squaresCorrect++;
                streak++;
                playTone(660, 0.08);
                updateScore(100);
                var letterEl = document.getElementById("letter" + nextLetterIndex);
                letterEl.style.color = "green";
                letterEl.style.filter = "opacity(0%)";
                letterEl.style.animation = "hinge 1.5s 1";
                letterEl.addEventListener('animationend', function hideLetter() {
                    letterEl.style.visibility = "hidden";
                    letterEl.removeEventListener('animationend', hideLetter);
                });
            };
            document.addEventListener('keydown', onKeyPress);
            document.addEventListener('keyup', function (event) {
                if (event.key.length !== 1) return;
                delete keysDown[event.key.toUpperCase()];
            });
        }
        document.removeEventListener('transitionend', checkForWin);
        document.addEventListener('transitionend', checkForWin);

        /*
         * Checks the finished word and calls a win or a loss.
         * event - the transition end event
         * return nothing
         */
        function checkForWin(event) {
            // Ensure userInputs is accessible and that the game logic correctly checks if the user won
            if (event.propertyName === "left") {
                var squares = ["square1", "square2", "square3", "square4", "square5"];
                var allSquaresSent = squares.every(square => {
                    return document.getElementById(square).style.left === "100%";
                });

                if (allSquaresSent) {
                    var allCorrect = squares.every(square => {
                        return userInputs[square]; // This now works since userInputs is global
                    });

                    if (allCorrect) {
                        console.log("You win!");
                        userWins();
                    } else {
                        console.log("You lose!");
                        userLoses();
                    }
                }
            }
        }


        /*
         * Fills the end panel with mode, score, and accuracy.
         * return nothing
         */
        function fillRoundSummary() {
            document.getElementById("summaryMode").textContent = settings.mode || "Easy";
            document.getElementById("summaryScore").textContent = score;
            document.getElementById("summaryAccuracy").textContent = userAccuracy;
        }


        /*
         * Author: Kevin Tieu
         * Hides the summary panel and starts the next word.
         * return nothing
         */
        function hideSummary() {
            document.getElementById("roundSummary").style.display = "none";
            document.body.style.opacity = "1";
        }

        /*
         * Author: Kevin Tieu
         * Hides the end panel and starts another round.
         * return nothing
         */
        function playAgain() {
            hideSummary();
            restartRound();
        }

        /*
         * Author: Kevin Tieu
         * Leaves the round and opens the main menu.
         * return nothing
         */
        function backToMenu() {
            window.location.href = "../Index.php";
        }

        /*
         * Author: Kevin Tieu
         * Opens the user stats page.
         * return nothing
         */
        function viewStats() {
            window.location.href = "user_Stats.php";
        }

        /*
         * Author: Kevin Tieu
         * Starts another round from the end panel.
         * return nothing
         */
        function continueAfterSummary() {
            playAgain();
        }


        /*
         * Author: Kevin Tieu
         * Saves the guest round so the stats page can show it once.
         * return nothing
         */
        function saveGuestRound() {
            if (localStorage.getItem("userObject")) return;
            var raw = (settings.mode || "easy").toLowerCase();
            var difficulty = "easy";
            if (raw.indexOf("med") !== -1) difficulty = "medium";
            else if (raw.indexOf("hard") !== -1) difficulty = "hard";
            localStorage.setItem("guestRound", JSON.stringify({
                mode: difficulty,
                score: score,
                accuracy: userAccuracy,
                wrongKeys: wrongPresses
            }));
        }


        /*
         * Author: Kevin Tieu
         * Sets accuracy from correct keys and wrong keys.
         * return nothing
         */
        function updateAccuracy() {
            var attempts = squaresCorrect + wrongPresses;
            userAccuracy = attempts === 0 ? 0 : Math.round((squaresCorrect / attempts) * 100);
        }

        /*
         * Sends the signed-in score to the stats script.
         * return nothing
         */
        function sendScore(){
            // Send the score and difficulty to set_user_stats.php
            var raw = (settings.mode || "easy").toLowerCase();
            var difficulty = "easy";
            if (raw.indexOf("med") !== -1) difficulty = "medium";
            else if (raw.indexOf("hard") !== -1) difficulty = "hard";
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../BackEnd/set_User_Stats.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Score and difficulty sent successfully");
                }
            };
            console.log("Sending score:", score, "and difficulty:", difficulty, "and wpm:", userAccuracy);
            xhr.send("score=" + encodeURIComponent(score) + "&difficulty=" + encodeURIComponent(difficulty) + "&wpm=" + encodeURIComponent(userAccuracy));
        }

        /*
         * Starts one letter moving across the screen.
         * square - the letter square id
         * return nothing
         */
        function sendSquare(square) {
            var squareElement = document.getElementById(square);
            squareElement.style.transition = squareTransitionProperty;
            squareElement.style.left = "-10%";

            squareElement.addEventListener('transitionend', function resetPosition() {
                if (squareElement.style.left === "-10%") {
                    squareElement.style.transition = "none";
                    squareElement.style.left = "100%";
                    squareElement.style.opacity = "1"; // Reset opacity
                    squareElement.removeEventListener('transitionend', resetPosition);
                }
            });
        }

        /*
         * Spends one heart for a missed word and ends the round on the third miss.
         * return nothing
         */
        function userLoses() {
    playTone(180, 0.16);
    markNextLetter(0);
    wordsCorrect = 0;
    feverActive = false;
    streak = 0;
    if (settings.practice) { setTimeout(resetWord, 800); return; }
    // Get a static array of heart elements
    var heartElements = Array.from(document.getElementsByClassName("ri-heart-fill"));
    var heartCount = heartElements.length;

    // A miss always spends one heart. Three hearts means three misses.
    if (heartCount > 0) {
        var lastHeart = heartElements[heartCount - 1];
        lastHeart.classList.remove("ri-heart-fill");
        lastHeart.classList.add("ri-heart-line");
        heartCount = heartCount - 1;
    }

    if (heartCount <= 0) {
        document.body.style.opacity = "1";
        updateAccuracy();
        console.log("User accuracy: " + userAccuracy + "%");
        if (!settings.practice && localStorage.getItem('userObject')) { sendScore(); }
        saveGuestRound();
        fillRoundSummary();
        document.getElementById("roundSummary").style.display = "flex";
    } else {

        // Trigger animation and color change for the word
        document.getElementById('gameWord').style.animation = "shakeX 1s 1";
        document.getElementById('letter1').style.color = "red";
        document.getElementById('letter2').style.color = "red";
        document.getElementById('letter3').style.color = "red";
        document.getElementById('letter4').style.color = "red";
        document.getElementById('letter5').style.color = "red";

        setTimeout(resetWord, 1500);
    }

    // Update accuracy after the event
    updateAccuracy();
}
        /*
         * Scores a finished word and loads the next one.
         * return nothing
         */
        function userWins() {
            wordsCorrect++;
            feverActive = wordsCorrect >= 3;
            setTimeout(function () {
                document.getElementById('gameWord').style.animation = "bounce 1s 1";
                document.getElementById('gameWord').style.color = "green";

                document.getElementById('letter1').style.transition = "all 0.5s";
                document.getElementById('letter2').style.transition = "all 0.5s";
                document.getElementById('letter3').style.transition = "all 0.5s";
                document.getElementById('letter4').style.transition = "all 0.5s";
                document.getElementById('letter5').style.transition = "all 0.5s";

                document.getElementById('letter1').style.filter = "none";
                document.getElementById('letter2').style.filter = "none";
                document.getElementById('letter3').style.filter = "none";
                document.getElementById('letter4').style.filter = "none";
                document.getElementById('letter5').style.filter = "none";

                document.getElementById('letter1').style.visibility = "visible";
                document.getElementById('letter2').style.visibility = "visible";
                document.getElementById('letter3').style.visibility = "visible";
                document.getElementById('letter4').style.visibility = "visible";
                document.getElementById('letter5').style.visibility = "visible";

                document.getElementById('gameWord').style.animation = "bounce 1s 1";

                setTimeout(resetWord, 1500);

            }, 1000);

        }

        /*
         * Clears the word display and starts the next word.
         * return nothing
         */
        function resetWord() {
    document.getElementById('gameWord').style.animation = "flipOutX 1s 1";
    document.getElementById('gameWord').style.color = "black";
    document.getElementById('letter1').style.color = "black";
    document.getElementById('letter2').style.color = "black";
    document.getElementById('letter3').style.color = "black";
    document.getElementById('letter4').style.color = "black";
    document.getElementById('letter5').style.color = "black";

    setTimeout(function () {
        document.getElementById('gameWord').style.visibility = "hidden";
        document.getElementById('letter1').style.animation = "none";
        document.getElementById('letter2').style.animation = "none";
        document.getElementById('letter3').style.animation = "none";
        document.getElementById('letter4').style.animation = "none";
        document.getElementById('letter5').style.animation = "none";

        // Reset filter and visibility properties
        document.getElementById('letter1').style.filter = "none";
        document.getElementById('letter2').style.filter = "none";
        document.getElementById('letter3').style.filter = "none";
        document.getElementById('letter4').style.filter = "none";
        document.getElementById('letter5').style.filter = "none";
        document.getElementById('letter1').style.visibility = "visible";
        document.getElementById('letter2').style.visibility = "visible";
        document.getElementById('letter3').style.visibility = "visible";
        document.getElementById('letter4').style.visibility = "visible";
        document.getElementById('letter5').style.visibility = "visible";

        setTimeout(function () {
            document.getElementById('gameWord').style.visibility = "visible";
            document.getElementById('gameWord').style.animation = "flipInX 1s 1";
            startGame();
        }, 1);
    }, 1000);
}

    </script>
    <script src="five-letter-words.js"></script>
    <script src="english-five.js"></script>
    <script src="word-packs.js"></script>
</body>

</html>