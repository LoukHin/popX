<?php

require './../conn.php';

$MAX_GRAND_OPENING = 100000;

// set php runtime to unlimited
set_time_limit(0);

$sql = "SELECT * FROM popcat WHERE popcat.id = 1";

// main loop
while (true) {

    // if ajax request has send a timestamp, then $last_ajax_call = timestamp, else $last_ajax_call = null
    $last_ajax_call = isset($_GET['t']) ? (int)$_GET['t'] : null;
    $time = new DateTime();

    clearstatcache();

    // if no timestamp delivered via ajax or last ajax call is longer than 3 seconds ago
    if ($last_ajax_call == null || $last_ajax_call + 3 < $time->getTimestamp()) {
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        unset($row["popcat"]);
        $row["isFinished"] = ($row["nuea"] + $row["klang"] + $row["esan"] + $row["tai"]) >= $MAX_GRAND_OPENING;
        // encode to JSON, render the result (for AJAX)
        $json = json_encode($row);
        echo $json;

        // leave this loop step
        break;

    } else {
        // wait for 3 seconds
        sleep( 3 );
        continue;
    }
}

?>
