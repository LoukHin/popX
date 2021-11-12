<?php
    require '../conn.php';
    $sql = "SELECT * FROM popcat WHERE `popcat`.`id` = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // echo "nuea : " . $row["nuea"]. "<br>klang : " . $row["klang"]. "<br>esan : " . $row["esan"]. "<br>";

    $taipass = $row["tai"]+1;

    $tai = "UPDATE `popcat` SET `tai` = '$taipass' WHERE `popcat`.`id` = 1";
    if ($conn->query($tai) === TRUE) {
        echo "<br>Tai record updated successfully";
    }

    $conn->close();
