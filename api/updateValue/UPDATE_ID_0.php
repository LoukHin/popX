<?php
    require('../conn.php');
    $sql = "SELECT * FROM popcat WHERE `popcat`.`id` = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // echo "nuea : " . $row["nuea"]. "<br>klang : " . $row["klang"]. "<br>esan : " . $row["esan"]. "<br>";

    $nueapass = $row["nuea"]+1;

    $nuea = "UPDATE `popcat` SET `nuea` = '$nueapass' WHERE `popcat`.`id` = 1";
    if ($conn->query($nuea) === TRUE) {
        echo "<br>nuea record updated successfully";
    }

    $conn->close();
?>