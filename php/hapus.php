<?php

require '../function.php';

$id = $_GET["id"];

hapusMatkul($id);
header("Location: ../admin.php");

?>