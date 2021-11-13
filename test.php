<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>popX | InspiredIT</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/tailwindcss-jit-cdn"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sriracha&display=swap');
        @import url('https://fonts.googleapis.com/css?family=Raleway:900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sriracha', cursive !important;
            color: #007aff;
            font-weight: 800;
        }

        #container {
            /* Center the text in the viewport. */
            /* position: absolute; */
            /* margin: auto; */
            width: 100vw;
            height: 80pt;
            /* top: 0;
            bottom: 0; */

            /* This filter is a lot of the magic, try commenting it out to see how the morphing works! */
            filter: url(#threshold) blur(0.6px);
        }

        /* Your average text styling */
        #text1,
        #text2 {
            position: absolute;
            width: 100%;
            display: inline-block;

            font-family: 'Raleway', sans-serif;
            font-size: 80pt;

            text-align: center;

            user-select: none;
        }
    </style>
</head>

<body class="h-screen relative flex items-center flex-col">
    <div class="container mx-auto px-5 mb-24 space-y-1 flex justify-center items-center flex-col">
        <!-- <div class="text-7xl p-10">popX</div> -->
        <div id="container">
            <span id="text1"></span>
            <span id="text2"></span>
        </div>

        <!-- The SVG filter used to create the merging effect -->
        <svg id="filters">
            <defs>
                <filter id="threshold">
                    <!-- Basically just a threshold effect - pixels with a high enough opacity are set to full opacity, and all other pixels are set to completely transparent. -->
                    <feColorMatrix in="SourceGraphic" type="matrix" values="1 0 0 0 0
									0 1 0 0 0
									0 0 1 0 0
									0 0 0 255 -140" />
                </filter>
            </defs>
        </svg>
        <?php
        if (!isset($_COOKIE["count"])) {
            $cookie_name = "count";
            $cookie_value = "0";
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            // header("Location:profile.php");
            echo "<script>var score = 0;</script>";
        } else {
            $cookie_value = $_COOKIE["count"];
            echo "<script>var score = '" . $cookie_value . "';</script>";
        }

        ?>
        <p id="score">
            <?= $cookie_value ?>
        </p>
    </div>
    <div class="absolute w-36 h-52 p-6 mx-auto right-28 top-10 space-y-5 bg-gray-100 rounded-lg shadow-lg" id="scoreboard">
        <h2>เหนือ : <a id="demo_1">0</a></h2>
        <h2>กลาง : <a id="demo_1">0</a></h2>
        <h2>อีสาน : <a id="demo_1">0</a></h2>
        <h2>ใต้ : <a id="demo_1">0</a></h2>
    </div>
    <div class="mb-24" id="cat">
        <img class="cursor-pointer" src="assets/icon/cat0.svg" alt="cat" id="imgClickAndChange" onclick="changeImage()">
    </div>
    <label class="block text-left appearance-none outline-none text-gray-800" style="max-width: 400px">
        <span class="text-gray-700">มาจากภาคไหนเอ่ย ( แบ่งแบบสี่ภูมิภาค ref : <a target="_" class="text-blue-500" href="https://th.wikipedia.org/wiki/%E0%B8%A0%E0%B8%B9%E0%B8%A1%E0%B8%B4%E0%B8%A0%E0%B8%B2%E0%B8%84%E0%B8%82%E0%B8%AD%E0%B8%87%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B9%80%E0%B8%97%E0%B8%A8%E0%B9%84%E0%B8%97%E0%B8%A2">Click</a> )</span>
        <select class="form-select block w-full mt-1">
            <option value="0">เหนือ</option>
            <option value="1">กลาง</option>
            <option value="2">อีสาน</option>
            <option value="3">ใต้</option>
        </select>
    </label>
    <script>
        const SOUND_PATH = "assets";
        const audio = new Audio(`${SOUND_PATH}/pop.mp3`);

        function changeImage() {
            const catPath = `assets/icon/cat${Math.floor(Math.random() * (9 - 1) + 1)}.svg`;
            document.getElementById("imgClickAndChange").src = catPath;
            audio.play();
        }

        const elts = {
            text1: document.getElementById("text1"),
            text2: document.getElementById("text2")
        };

        // The strings to morph between. You can change these to anything you want!
        const texts = [
            "Inspired IT65",
            "By",
            "ITx",
            "KMITL",
            "Opening",
            "Click",
            "more!"
        ];

        // Controls the speed of morphing.
        const morphTime = 1;
        const cooldownTime = 1;

        let textIndex = texts.length - 1;
        let time = new Date();
        let morph = 0;
        let cooldown = cooldownTime;

        elts.text1.textContent = texts[textIndex % texts.length];
        elts.text2.textContent = texts[(textIndex + 1) % texts.length];

        function doMorph() {
            morph -= cooldown;
            cooldown = 0;

            let fraction = morph / morphTime;

            if (fraction > 1) {
                cooldown = cooldownTime;
                fraction = 1;
            }

            setMorph(fraction);
        }

        // A lot of the magic happens here, this is what applies the blur filter to the text.
        function setMorph(fraction) {
            // fraction = Math.cos(fraction * Math.PI) / -2 + .5;

            elts.text2.style.filter = `blur(${Math.min(8 / fraction - 8, 100)}px)`;
            elts.text2.style.opacity = `${Math.pow(fraction, 0.4) * 100}%`;

            fraction = 1 - fraction;
            elts.text1.style.filter = `blur(${Math.min(8 / fraction - 8, 100)}px)`;
            elts.text1.style.opacity = `${Math.pow(fraction, 0.4) * 100}%`;

            elts.text1.textContent = texts[textIndex % texts.length];
            elts.text2.textContent = texts[(textIndex + 1) % texts.length];
        }

        function doCooldown() {
            morph = 0;

            elts.text2.style.filter = "";
            elts.text2.style.opacity = "100%";

            elts.text1.style.filter = "";
            elts.text1.style.opacity = "0%";
        }

        // Animation loop, which is called every frame.
        function animate() {
            requestAnimationFrame(animate);

            let newTime = new Date();
            let shouldIncrementIndex = cooldown > 0;
            let dt = (newTime - time) / 1000;
            time = newTime;

            cooldown -= dt;

            if (cooldown <= 0) {
                if (shouldIncrementIndex) {
                    textIndex++;
                }

                doMorph();
            } else {
                doCooldown();
            }
        }

        // Start the animation.
        animate();



        // ====



        var img = document.getElementById("popcat1");
        var count = document.getElementById("score");
        var MyScore = 0;
        var score;

        const ASSET_PATH = "./assets/image";
        // mouseclick event
        document.body.addEventListener("mousedown", function() {
            increaseScore();
            changeImage();
            // if (score > 100) {
            //     img.src = `${ASSET_PATH}/popcat2.png`;
            //     audio.play();
            // } else if (score > 80) {
            //     img.src = `${ASSET_PATH}/2vaccine2.png`;
            //     audio.play();
            // } else if (score > 50) {
            //     img.src = `${ASSET_PATH}/catvaccine2.png`;
            //     audio.play();
            // } else if (score > 30) {
            //     img.src = `${ASSET_PATH}/catmask2.png`;
            //     audio.play();
            // } else {
            //     img.src = `${ASSET_PATH}/maincat2.png`;
            //     audio.play();
            // }
        });

        document.body.addEventListener("mouseup", function() {
            if (score > 100) {
                img.src = `${ASSET_PATH}/popcat1.png`;
                audio.play();
            } else if (score > 80) {
                img.src = `${ASSET_PATH}/2vaccine1.png`;
                audio.play();
            } else if (score > 50) {
                img.src = `${ASSET_PATH}/catvaccine1.png`;
                audio.play();
            } else if (score > 30) {
                img.src = `${ASSET_PATH}/catmask1.png`;
                audio.play();
            } else {
                img.src = `${ASSET_PATH}/maincat1.png`;
                audio.play();
            }
        });

        // touch event
        document.body.addEventListener("touchstart", function() {
            increaseScore();
            img.src = `${ASSET_PATH}/popcat2.png`;
            audio.play();
        });

        document.body.addEventListener("touchmove", function() {
            img.src = `${ASSET_PATH}/popcat1.png`;
            audio.play();
        });

        function increaseScore() {
            score++;
            count.innerHTML = score;
            document.cookie = `count=${score}`;
            const sb = document.querySelector("#majar");
            const Index = sb.selectedIndex;

            fetch(`/api/updateValue/UPDATE_ID_${Index}.php`)
                .then((res) => {
                    return res.json();
                })
                .then((data) => {
                    console.log(data);
                });
        }

        const fetchingNewValue = () => {
            const time = new Date().getTime();
            fetch(`/api/getValue/getCurrentValue.php?t=${Math.floor(time / 1000)}`)
                .then((res) => {
                    return res.json();
                })
                .then((data) => {
                    updateCurrentValue(data);
                    fetchingNewValue();
                });
        };

        const updateCurrentValue = ({
            nuea,
            klang,
            esan,
            tai
        }) => {
            document.getElementById("demo_1").innerHTML = nuea;
            document.getElementById("demo_2").innerHTML = klang;
            document.getElementById("demo_3").innerHTML = esan;
            document.getElementById("demo_4").innerHTML = tai;
            // todo: update the total value ui
            document.getElementById("total").innerHTML = nuea + klang + esan + tai;
        };

        fetchingNewValue();
    </script>
</body>

</html>