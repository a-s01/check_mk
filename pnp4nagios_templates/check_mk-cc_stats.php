<?php
include("template.php");

$colors = array( '1f77b4', 'ff7f0e', '2ca02c', 'd62728', '9467bd', '8c564b' );

foreach ($DS as $i => $value) {
    $opt[$i] = "--title \"$NAME[$i] \" -h 140 ";
    $def[$i] = generate($RRDFILE[$i], $DS[$i], $WARN[$i], $CRIT[$i], $NAME[$i], '', $i, $colors[$i-1], "AREA");
}
?>
