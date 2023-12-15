<?php 
    $date = $_POST["date"];
    $main = $_POST["main"];
    $sub = $_POST["sub"];

    $write_data = "{$date} {$main} {$sub}\n";
    $file = fopen('data/meal.txt', 'a');
    flock($file, LOCK_EX);
    fwrite($file, $write_data);
    flock($file, LOCK_UN);
    fclose($file);

    header("Location: index.php");
    exit();
; ?>









