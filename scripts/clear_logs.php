<?php
require "db.php";
$query = "SELECT * FROM logs";
$count = $dbh->query($query);
if ($count->rowCount() > 0) {
    $query = "DELETE FROM logs";
    $dbh->query($query);
}
