<?php
    require '../conn.php';
    $sql = "SELECT * FROM popcat WHERE `popcat`.`id` = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // echo "nuea : " . $row["nuea"]. "<br>klang : " . $row["klang"]. "<br>esan : " . $row["esan"]. "<br>";

    $esanpass = $row["esan"]+1;

    $esan = "UPDATE `popcat` SET `esan` = '$esanpass' WHERE `popcat`.`id` = 1";
    if ($conn->query($esan) === TRUE) {
        echo "<br>esan record updated successfully";
    }

    $conn->close();
?>