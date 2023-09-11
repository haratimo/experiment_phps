<?php

header("Access-Control-Allow-Origin: https://cortex.jatos.org");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$filename = 'participantIDs.txt';
$id_to_remove = $_POST['id'];

if (!file_exists($filename)) {
    echo "Error: File does not exist!";
    exit;
}

$handle = fopen($filename, 'r+');
if (!$handle) {
    echo "Error: Unable to open the file!";
    exit;
}

if (flock($handle, LOCK_EX)) { // Exclusive lock
    $ids = explode("\n", trim(file_get_contents($filename)));
    $ids = array_diff($ids, [$id_to_remove]);
    file_put_contents($filename, implode("\n", $ids));
    flock($handle, LOCK_UN); // Release the lock
} else {
    echo "Error: Could not lock the file!";
}
fclose($handle);
?>
