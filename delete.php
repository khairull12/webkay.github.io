<?php
// include database connection file
include_once("config.php");

// Get id from URL to delete that surat
$id = $_GET['id'];

// Delete surat row from table based on given id
$result = mysqli_query($mysqli, "DELETE FROM surat WHERE id=$id");

// After delete redirect to Home, so that latest surat list will be displayed.
header("Location:index.php");
?>