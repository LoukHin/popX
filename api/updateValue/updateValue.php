<?php

require './../conn.php';

// Takes raw data from the request
$json = file_get_contents('php://input');

/* 
 * Convert json to object
 * data should be like this
 * {
 *   "region": "nuea" | "klang" | "esan" | "tai", 
 *   "add": "0"
 * }
 **/
$data = json_decode($json);

$regions = array("nuea", "klang", "esan", "tai");

if (isset($data->region) && isset($data->add)) {
    $region = $data->region;
    $add = $data->add;
    if (in_array($region, $regions) && $add >= 0 && $add <= 100) {
        $sql = $conn->prepare("UPDATE `popcat` SET `?` = `?` + ? WHERE `popcat` = 1");
        $sql->bind_param("ssi", $region, $region, $add);
        $sql->execute();
        $conn->close();
    } else {
        echo -1;
    }
} else {
    echo 0;
}
?>