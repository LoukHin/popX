<?php
    require '../conn.php';
    $sql = "SELECT * FROM popcat WHERE `popcat`.`id` = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // echo "nuea : " . $row["nuea"]. "<br>klang : " . $row["klang"]. "<br>esan : " . $row["esan"]. "<br>";

    $nueapass = $row["nuea"]+1;
    $klangpass = $row["klang"]+1;
    $esanpass = $row["esan"]+1;
    $taipass = $row["tai"] + 1;

    $nuea = "UPDATE `popcat` SET `nuea` = '$nueapass' WHERE `popcat`.`id` = 1";
    if ($conn->query($comsci) === TRUE) {
        echo "<br>nuea record updated successfully";
    }
    $klang = "UPDATE `popcat` SET `klang` = '$klangpass' WHERE `popcat`.`id` = 1";
    if ($conn->query($klang) === TRUE) {
        echo "<br>klang record updated successfully";
    }
    $esan = "UPDATE `popcat` SET `esan` = '$esanpass' WHERE `popcat`.`id` = 1";
    if ($conn->query($esan) === TRUE) {
        echo "<br>esan record updated successfully";
    }
    $tai = "UPDATE `popcat` SET `Tai` = '$taipass' WHERE `popcat`.`id` = 1";
    if ($conn->query($tai) === TRUE) {
        echo "<br>Tai record updated successfully";
    }

    $conn->close();
?>