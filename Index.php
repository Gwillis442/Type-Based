<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <!--
    by: Chan Rain, Garrett Willis, Kevin Tieu
    last modified: 11/6/2024 

    you can run this using the URL:
    https://nrs-projects.humboldt.edu/~gdw48/Type-Based/Index.php
-->

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
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />

    <style>
        #signInModalContainer {
            position: fixed;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(10px);
            transform: scale(1);
            transition: all 0.25s;
            opacity: 0%;
            pointer-events: none;
        }

        #signInModalContainer #signInForm {
            background-color: #f2f3f5;
            position: relative;
        }

        .modalCloseButton {
            position: absolute;
            right: 0;
            top: 0;
            margin: 15px;
            font-size: 30px;
            cursor: pointer;
        }

        .tippy-box[data-theme~='translucent'] {
            background-color: #000;
            color: #f2f3f5;
            border-radius: 0px;
            transition: all 0.25s;
        }

        .tippy-box[data-theme~='translucent'] .tippy-arrow {
            color: #000;
        }
    </style>
</head>

<body>

    <div class="w3-container w3-half">
        <h1 id="menuLogo">LOGO</h1>
        <div class="w3-container button-container">

            <button id="menuPlayButton" onclick="startGame()">
                <i class="ri-play-fill"></i>
                <span>START GAME</span>
            </button>

            <div style="display: flex; justify-content: space-between;">
                <button id="menuSignInButton" style="flex: 1; margin-right: 5px;" onclick="signIn()">
                    <i class="ri-login-box-line"></i>
                    <span style="font-size:20px;vertical-align: text-top;">SIGN IN</span>
                </button>
                <button id="menuConfigButton" style="flex: 1; margin-left: 5px;opacity:10%;pointer-events:none"
                    onclick="viewData()">
                    <i style="font-weight:900" class="ri-file-chart-2-line"></i>
                    <span style="font-size:20px;vertical-align: text-top;">VIEW DATA</span>
                </button>
            </div>

        </div>
    </div>
    <div class="w3-container w3-half">
        <div class="w3-container config-container">
            <h2>SETTINGS</h2>
            <div class="w3-container">
                <table CELLSPACING="0px">
                    <tr>
                        <td>
                            <i class="ri-play-fill"></i>
                            <span>Mode Select</span>
                            <select name="mode" id="modeSelect">
                                <option value="easy">Easy</option>
                                <option value="med">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="ri-album-fill"></i>
                            <span>Song Select</span>
                            <select name="song" id="songSelect">
                                <option value="song1">Song 1</option>
                                <option value="song2">Song 2</option>
                                <option value="song3">Song 3</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="ri-volume-down-fill"></i>
                            <span>Sound</span>
                            <select name="sound" id="soundState">
                                <option value="true">Enabled</option>
                                <option value="false">Disabled</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="ri-music-2-fill"></i>
                            <span>Music</span>
                            <select name="music" id="musicState">
                                <option value="true">Enabled</option>
                                <option value="false">Disabled</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="ri-history-fill" style="font-weight:900"></i>
                            <span>Play History</span>
                            <select name="history" id="historyState">
                                <option value="true">Enabled</option>
                                <option value="false">Disabled</option>
                            </select>
                            <br>
                            <div class="w3-blurb">
                                <i class="ri-information-line"></i>
                                <p>Play History lets you view past games and scores to track progress and improvement
                                    over time.</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div id="signInModalContainer">
        <div id="signInModal" class="w3-container w3-display-middle w3-center" style="width: 50%">
            <div class="w3-container button-container">
                <form id="signInForm" method="post" action="BackEnd/User_Authentication.php" onsubmit="signIn(event)" class="w3-container w3-card-4 w3-margin">
                    <h2 class="w3-left w3-margin-top">Sign In</h2>
                    <i class="ri-close-line modalCloseButton" onclick="closeSignInModal()"></i>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px;margin:1px;margin-left:-5px;"><i
                                class="w3-xlarge ri-user-line"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input" type="text" id="username" name="username" placeholder="Username"
                                required>
                        </div>
                    </div>

                    <div class="w3-row w3-section">
                        <div class="w3-col" style="width:50px;margin:1px;margin-left:-5px"><i
                                class="w3-xlarge ri-lock-line"></i></div>
                        <div class="w3-rest">
                            <input class="w3-input" type="password" id="password" name="password" placeholder="Password"
                                required>
                        </div>
                    </div>

                    <button class="w3-block w3-section" type="submit" id="menuModalSignInButton"
                        onclick="modalSignIn(event)">
                        <i class="ri-login-box-line"></i>
                        <span style="font-size:20px;vertical-align: text-top;">SIGN IN</span>
                    </button>

                    <button class="w3-block w3-section" type="submit" id="menuModalCreateAccountButton"
                        onclick="modalCreateAccount(event)">
                        <i class="ri-add-box-line"></i>
                        <span style="font-size:20px;vertical-align: text-top;">CREATE ACCOUNT</span>
                    </button>

                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

    <script>
        const settings = {
            mode: 'easy',
            song: 'song1',
            sound: true,
            music: true,
            history: true,
        };

        const user = {
            signedIn: false,
            username: '',
        };

        const dummyUser = {
            username: 'username',
            password: 'password',
        };

        function initSettingsListener() {

            if (localStorage.getItem('settingsObject') === null) {
                localStorage.setItem('settingsObject', JSON.stringify(settings));
            }

            const settingsMapping = {
                modeSelect: 'mode',
                songSelect: 'song',
                soundState: 'sound',
                musicState: 'music',
                historyState: 'history',
            };

            Object.keys(settingsMapping).forEach(id => {
                document.getElementById(id).addEventListener('change', function () {
                    const settingKey = settingsMapping[id];
                    settings[settingKey] = id.includes("State") ? (this.value === "true") : this.value;
                    writeSettingsToLocalStorage(settingKey, settings[settingKey]);
                    if (settingKey === 'history') updateConfigButtonDisplay();
                });
            });
        }

        function writeSettingsToLocalStorage(key, value) {
            const settingsObject = JSON.parse(localStorage.getItem('settingsObject')) || settings;
            settingsObject[key] = value;
            localStorage.setItem('settingsObject', JSON.stringify(settingsObject));
        }

        function applySettingsFromLocalStorage() {
            const settingsObject = JSON.parse(localStorage.getItem('settingsObject'));
            if (settingsObject) {
                Object.keys(settingsObject).forEach(key => {
                    const element = document.getElementById(`${key}Select`) || document.getElementById(`${key}State`);
                    if (element) element.value = settingsObject[key];
                    settings[key] = settingsObject[key] === "true" || settingsObject[key] === "false"
                        ? settingsObject[key] === "true"
                        : settingsObject[key];
                });
            }
            updateConfigButtonDisplay();
        }

        function updateConfigButtonDisplay() {
            console.log(settings.history, user.signedIn);
            console.log(document.getElementById('menuConfigButton'));
            const menuConfigButton = document.getElementById('menuConfigButton');

            if (settings.history && user.signedIn) {
                // Display and enable the button fully when signed in and history is enabled
                menuConfigButton.style.display = 'block';
                menuConfigButton.style.opacity = '100%';
                menuConfigButton.style.pointerEvents = 'auto';
            } else if (settings.history) {
                // Show the button but disable it if history is enabled but user is not signed in
                menuConfigButton.style.display = 'block';
                menuConfigButton.style.opacity = '10%';
                menuConfigButton.style.pointerEvents = 'none';
            } else {
                // Hide the button completely if history is disabled
                menuConfigButton.style.display = 'none';
            }
        }


        function applySettingsToLocalStorage() {
            Object.keys(settings).forEach(key => writeSettingsToLocalStorage(key, settings[key]));
        }

        function initSignInState() {
            const userObject = JSON.parse(localStorage.getItem('userObject'));
            if (userObject) {
                user.signedIn = userObject.signedIn;
                user.username = userObject.username;
            }
            updateSignInDisplay();
        }

        function updateSignInDisplay() {
            document.getElementById('menuSignInButton').innerHTML = user.signedIn
                ? '<i class="ri-logout-box-line"></i><span style="font-size:20px;vertical-align: text-top;">SIGN OUT</span>'
                : '<i class="ri-login-box-line"></i><span style="font-size:20px;vertical-align: text-top;">SIGN IN</span>';

            updateConfigButtonDisplay();
            updateTooltips();
        }

        function signIn() {
            if (user.signedIn) {
                user.signedIn = false;
                user.username = '';
                localStorage.setItem('userObject', JSON.stringify(user));
                document.getElementById('username').value = '';
                document.getElementById('password').value = '';
                <?php session_destroy(); ?>
            } else {
                document.getElementById('signInModalContainer').style.opacity = '100%';
                document.getElementById('signInModalContainer').style.pointerEvents = 'auto';
                document.getElementById('signInModalContainer').style.transform = 'scale(1.1)';
            }
            updateSignInDisplay();
        }

        function modalSignIn(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username && password) {

                // Submit the form to User_Authentication.php for server-side authentication
                document.getElementById('signInForm').submit();
            } else {
                alert('Please enter both username and password.');
            }
        }

        function modalCreateAccount(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username && password) {
                // Submit the form to User_Authentication.php for server-side authentication
                document.getElementById('signInForm').submit();
            } else {
                alert('Please enter both username and password.');
            }
        }


        function closeSignInModal() {
            const modal = document.getElementById('signInModalContainer');
            modal.style.opacity = '0%';
            modal.style.pointerEvents = 'none';
            modal.style.transform = 'scale(1)';
        }

        function startGame() {
            applySettingsToLocalStorage();
            setTimeout(() => window.location.href = 'game.html', 1);
        }

        function updateTooltips() {
            destroyTooltip('#menuSignInButton');
            const signInTooltipContent = user.signedIn
                ? 'Sign out to switch accounts.'
                : 'Sign in to save your progress!';

            createTooltip('#menuSignInButton', signInTooltipContent);
            createTooltip('#menuConfigButton', 'View past game data.');
        }

        function createTooltip(selector, content) {
            tippy(selector, {
                content,
                placement: 'bottom',
                animation: 'shift-away',
                theme: 'translucent',
            });
        }

        function destroyTooltip(selector) {
            const element = document.querySelector(selector);
            if (element && element._tippy) element._tippy.destroy();
        }
                
        <?php if(isset($_SESSION['username']) && $_SESSION['username']) { ?>
            user.signedIn = true;
            user.username = '<?= $_SESSION['username'] ?>';
            localStorage.setItem('userObject', JSON.stringify(user));
            updateSignInDisplay();
        <?php } ?>

        window.onload = function () {
            applySettingsFromLocalStorage();
            initSettingsListener();
            initSignInState();
            document.body.style.opacity = '100%';

            <?php if(isset($_SESSION['login_failed']) && $_SESSION['login_failed']) { ?>
                alert('Invalid username or password. Please try again.');
                document.getElementById('signInModalContainer').style.opacity = '100%';
                document.getElementById('signInModalContainer').style.pointerEvents = 'auto';
                document.getElementById('signInModalContainer').style.transform = 'scale(1.1)';
            <?php unset($_SESSION['login_failed']); // Clear the login_failed session variable 
                } ?>
        };

    </script>

</body>

</html>