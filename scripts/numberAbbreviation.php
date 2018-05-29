<?php
/**
 * Shorten large numbers into abbreviations (i.e. 1,500 = 1.5k)
 *
 * @param int $number Number to shorten
 * @return String   A number with a symbol
 */
function numberAbbreviation($number)
{
    $abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");

    foreach ($abbrevs as $exponent => $abbrev) {
        if ($number >= pow(10, $exponent)) {
            $display_num = $number / pow(10, $exponent);
//        	$decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;
            $decimals = 3;
            return number_format($display_num, $decimals, '.', "'") . $abbrev;
        }
    }
}

?>