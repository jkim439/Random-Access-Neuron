<?php
$mysqli = new mysqli("localhost", "root", "password", "hackathon");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>