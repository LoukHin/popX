<?php
    require '../conn.php';
    $sql = "SELECT * FROM popcat WHERE `popcat`.`id` = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // echo "nuea : " . $row["nuea"]. "<br>klang : " . $row["klang"]. "<br>esan : " . $row["esan"]. "<br>";

    $klangpass = $row["klang"]+1;

    $klang = "UPDATE `popcat` SET `klang` = '$klangpass' WHERE `popcat`.`id` = 1";
    if ($conn->query($klang) === TRUE) {
        echo "<br>klang record updated successfully";
    }

    $conn->close();
?>