<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POPCAT</title>
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" integrity="sha512-Cv93isQdFwaKBV+Z4X8kaVBYWHST58Xb/jVOcV9aRsGSArZsgAnFIhMpDoMDcFNoUtday1hdjn0nGp3+KZyyFw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="./js/script.js" defer></script>
    <style>
        .topright {
            position: absolute;
            top: 8px;
            right: 16px;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>popX</h1>
        <br><br>
        <p id="score">0</p>
        </br></br>
        <!-- <img src="maincat1.png" alt="Invalid" id="popcat1" height="500x"> -->
        <img src="./assets/image/maincat1.png" alt="Invalid" id="popcat1" height="600px">
        <div class="badge bg-primary text-wrap topright">
            เหนือ: <a id="demo_1">0</a><br><br>
            กลาง: <a id="demo_2">0</a><br><br>
            อีสาน: <a id="demo_3">0</a><br><br>
            ใต้: <a id="demo_4">0</a><br><br>
        </div>
        <select name="majar" id="majar">
            <option value="0">[0] เหนือ</option> <!-- value 0 -->
            <option value="1">[1] กลาง</option> <!-- value 1 -->
            <option value="2">[2] อีสาน</option> <!-- value 3 -->
            <option value="3">[3] ใต้</option> <!-- value 3 -->
            <!-- <option value="political">political</option> value 4 -->
        </select>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>