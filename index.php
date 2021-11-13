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
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
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
    <div class="container mx-auto px-5 mb-12 space-y-1 flex justify-center items-center flex-col">
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
    </div>
    <p id="score" class="text-8xl my-4">0</p>
    <div class="mb-12" id="cat">
      <img class="cursor-pointer" src="assets/icon/cat0.svg" alt="cat" id="imgClickAndChange">
    </div>
    <div class="block md:absolute w-3/4 md:w-36 h-52 p-6 mb-12 mx-auto sm:right-0 lg:right-28 sm:top-48 lg:top-10 space-y-5 bg-gray-100 rounded-lg shadow-lg" id="scoreboard">
      <h2>เหนือ : <a id="demo_1">0</a></h2>
      <h2>กลาง : <a id="demo_2">0</a></h2>
      <h2>อีสาน : <a id="demo_3">0</a></h2>
      <h2>ใต้ : <a id="demo_4">0</a></h2>
    </div>
    <div class="pb-12">
      <label class="block text-left appearance-none outline-none text-gray-800" style="max-width: 400px">
        <span class="text-gray-700">มาจากภาคไหนเอ่ย ( แบ่งแบบสี่ภูมิภาค ref : <a target="_" class="text-blue-500" href="https://th.wikipedia.org/wiki/%E0%B8%A0%E0%B8%B9%E0%B8%A1%E0%B8%B4%E0%B8%A0%E0%B8%B2%E0%B8%84%E0%B8%82%E0%B8%AD%E0%B8%87%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B9%80%E0%B8%97%E0%B8%A8%E0%B9%84%E0%B8%97%E0%B8%A2">Click</a> )</span>
        <select class="form-select block w-full mt-1" id="select-region">
          <option value="nuea">เหนือ</option>
          <option value="klang">กลาง</option>
          <option value="esan">อีสาน</option>
          <option value="tai">ใต้</option>
        </select>
      </label>
    </div>
    <span class="text-red-600" style="display: none" id="is-hacker">Hacker!</span>

    <script src="./js/script.js"></script>
    <script>
    const elts = {
      text1: document.getElementById("text1"),
      text2: document.getElementById("text2")
    };

    // The strings to morph between. You can change these to anything you want!
    const texts = [
      "Inspired IT65",
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
    </script>
  </body>

</html>
