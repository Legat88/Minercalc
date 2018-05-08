<?php
require "db.php";
$stmt=$dbh->query("SELECT name, measure FROM algos");
while ($algo=$stmt->fetch(PDO::FETCH_LAZY)) {
    echo '<div class="'.$css_grid.'">';
    echo '<h6 class="text-center">'.$algo->name.'</h6>';
    echo '<div class="input-group">';
    echo '<input type="number" class="form-control hashes" name="' . $algo->name . '" id="' . $algo->name . '" value="" min="0" oninput="validity.valid||(value=\'\');">';
    echo '<div class="input-group-append">';
    echo '<span class="input-group-text">'.$algo->measure.'</span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
$stmt = null;