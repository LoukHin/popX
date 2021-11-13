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
    if (in_array($region, $regions) && $add >= 0 && $add < 100) {
        $sql = "UPDATE `popcat` SET `$region` = `$region` + $add WHERE `popcat`.id = 1";
        $conn->query($sql);
        $conn->close();
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>
