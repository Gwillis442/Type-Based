<?php
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

<button id = "gameStartButton" onclick="startGame()">
    <i class="ri-play-fill"></i>
    <span>PLAY GAME</span>
</button>

    <div class="titleBar">
        <div class="titleHPBar">
            <i class="ri-heart-fill"></i>
            <i class="ri-heart-line"></i>
            <i class="ri-heart-line"></i>
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

        var userAccuracy = 0;

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
                    squareTransitionProperty = "left 1s linear";
                    squareBPMProperty = 360;
                }

                if (settings.song == undefined) {
                    settings.song = "Song Select";
                } else if (settings.song == "song1") {
                    settings.song = "Song 1";
                } else if (settings.song == "song2") {
                    settings.song = "Song 2";
                } else if (settings.song == "song3") {
                    settings.song = "Song 3";
                }

                document.getElementById("selectedMode").innerHTML = settings.mode;
                document.getElementById("selectedSong").innerHTML = settings.song;
            }
        }

        function initSignInState() {
            var userObject = JSON.parse(localStorage.getItem("userObject"));
            if (userObject == null || userObject.signedIn == false) {
                document.getElementById('signInStatus').style.display = 'none';
            } else {
                document.getElementById('signInStatus').style.display = 'block';
            }

            if (localStorage.getItem("settingsObject") == null) {
                window.location.href = "index.html";
            }
        }

        window.onload = function () {
            initSignInState();
            displaySettingsObject();
            document.body.style.opacity = 1;
        }

        function selectWord() {
            var selected_word = wordbank[Math.floor(Math.random() * wordbank.length)];
            // check to make sure that the word does not reuse any letters.
            while (selected_word[0] == selected_word[1] || selected_word[0] == selected_word[2] || selected_word[0] == selected_word[3] || selected_word[0] == selected_word[4] || selected_word[1] == selected_word[2] || selected_word[1] == selected_word[3] || selected_word[1] == selected_word[4] || selected_word[2] == selected_word[3] || selected_word[2] == selected_word[4] || selected_word[3] == selected_word[4]) {
                selected_word = wordbank[Math.floor(Math.random() * wordbank.length)];
            }
            document.getElementById("letter1").innerHTML = selected_word[0].toUpperCase();
            document.getElementById("letter2").innerHTML = selected_word[1].toUpperCase();
            document.getElementById("letter3").innerHTML = selected_word[2].toUpperCase();
            document.getElementById("letter4").innerHTML = selected_word[3].toUpperCase();
            document.getElementById("letter5").innerHTML = selected_word[4].toUpperCase();
            return selected_word;

        }

        var score = 0;

        function updateScore(points) {
            score += points
            console.log(score);
            document.getElementById("score").innerHTML = score;
        }

        function triggerAnimation(square, animationClass) {
            var squareElement = document.getElementById(square);
            squareElement.style.animation = "none"; // Reset animation
            squareElement.offsetHeight; // Force a reflow
            squareElement.style.animation = `${animationClass} 0.5s 1`; // Apply new animation
        }

        function startGame() {

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

            var interval = setInterval(function () {
            if (sentSquares.size < squares.length) {
                var availableSquares = squares.filter(square => !sentSquares.has(square));
                if (availableSquares.length > 0) {
                var randomIndex = Math.floor(Math.random() * availableSquares.length);
                var selectedSquare = availableSquares[randomIndex];
                sendSquare(selectedSquare);
                squaresSent++;
                sentSquares.add(selectedSquare);
                activeSquares.add(selectedSquare);
                }
            } else {
                clearInterval(interval);
            }

            // Speed up the interval gradually
            if (squareInterval > 1000) { // Set a minimum interval limit
                squareInterval *= 0.975; // Decrease interval by 2.5%
            }
            }, squareInterval);
        }

        let observer; // Declare globally to track the observer.

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


        function setupGlobalInputListener(squares, activeSquares, userInputs) {
            document.removeEventListener('keydown', onKeyPress);
            document.addEventListener('keydown', onKeyPress);

            function onKeyPress(event) {
                var userLetter = event.key.toUpperCase();
                squares.forEach(square => {
                    var squareElement = document.getElementById(square);
                    var correctLetter = document.getElementById(`${square}contents`).innerHTML;
                    if (!userInputs[square] && activeSquares.has(square)) {
                        if (userLetter === correctLetter) {
                            userInputs[square] = true;
                            triggerAnimation(square, "tada");
                            squaresCorrect++;
                            updateScore(100);
                            document.getElementById("letter" + (squares.indexOf(square) + 1)).style.color = "green";
                            document.getElementById("letter" + (squares.indexOf(square) + 1)).style.filter = "opacity(0%)";
                            document.getElementById("letter" + (squares.indexOf(square) + 1)).style.animation = "hinge 1.5s 1";
                            // when the animation is done, hide the letter
                            document.getElementById("letter" + (squares.indexOf(square) + 1)).addEventListener('animationend', function hideLetter() {
                                document.getElementById("letter" + (squares.indexOf(square) + 1)).style.visibility = "hidden";
                                document.getElementById("letter" + (squares.indexOf(square) + 1)).removeEventListener('animationend', hideLetter);
                                document.getElementById("letter" + (squares.indexOf(square) + 1)).style.filter = "opacity(0%)";
                            });
                        } else {
                        }
                    }
                });
            }
        }
        document.removeEventListener('transitionend', checkForWin);
        document.addEventListener('transitionend', checkForWin);

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

        function sendScore(){
            // Send the score and difficulty to set_user_stats.php
            var difficulty = settings.mode.toLowerCase();
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "./BackEnd/set_User_Stats.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Score and difficulty sent successfully");
                }
            };
            console.log("Sending score:", score, "and difficulty:", difficulty, "and wpm:", userAccuracy);
            xhr.send("score=" + encodeURIComponent(score) + "&difficulty=" + encodeURIComponent(difficulty) + "&wpm=" + encodeURIComponent(userAccuracy));
        }

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

        function userLoses() {
    // Get a static array of heart elements
    var heartElements = Array.from(document.getElementsByClassName("ri-heart-fill"));
    var heartCount = heartElements.length;

    // Check if the player has no hearts left
    if (heartCount <= 0) {
        document.body.style.transition = "opacity 5s";
        document.body.style.opacity = 0;
        userAccuracy = Math.round((squaresCorrect / squaresSent) * 100);
        console.log("User accuracy: " + userAccuracy + "%");
        sendScore();
        setTimeout(function () {
            window.location.href = "user_Stats.php";
        }, 2500);
    } else {
        // Replace the last heart element with a heart-line element
        var lastHeart = heartElements[heartCount - 1];
        lastHeart.classList.remove("ri-heart-fill");
        lastHeart.classList.add("ri-heart-line");

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
    userAccuracy = Math.round((squaresCorrect / squaresSent) * 100);
}
        function userWins() {
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
</body>

</html>