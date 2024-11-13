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
    <link rel="stylesheet" type="text/css" href="styles.css">
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
            font-size: 30px;
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
            font-size: 15px;
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

    <div class="titleBar">
        <div class="titleHPBar">
            <i class="ri-heart-fill"></i>
            <i class="ri-heart-fill"></i>
            <i class="ri-heart-fill"></i>
        </div>
        <div class="flex-end">
            <div class="titleWidget">
                <p>
                    <i class="ri-play-fill"></i>
                    <span id="selectedMode">Mode Select</span>
                </p>
            </div>
            <div class="titleWidget">
                <p>
                    <i class="ri-album-fill"></i>
                    <span id="selectedSong">Song Select</span>
                </p>
            </div>

            <div class="titleWidget" id = "signInStatus" style = "background-color:green">
                <p>
                    <i class="ri-checkbox-circle-fill"></i>
                    <span>Signed in</span>
                </p>

        </div>
    </div>

    <script>
        var settings = {}

        function displaySettingsObject() {
            if (localStorage.getItem("settingsObject") == null) {
            } else {
                settings = JSON.parse(localStorage.getItem("settingsObject"));

                if (settings.mode == undefined) {
                    settings.mode = "Mode Select";
                } else if (settings.mode == "easy") {
                    settings.mode = "Easy";
                } else if (settings.mode == "med") {
                    settings.mode = "Medium";
                } else if (settings.mode == "hard") {
                    settings.mode = "Hard";
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
    </script>
</body>

</html>