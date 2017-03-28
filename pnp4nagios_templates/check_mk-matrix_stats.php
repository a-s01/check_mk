<?php
include("template.php");

$colors = array( "000099", "8BEA00", "cc0000");

foreach ($DS as $i => $value) {
    $opt[$i] = "--title \"$NAME[$i] \" -h 140 ";
    $def[$i] = generate($RRDFILE[$i], $DS[$i], $WARN[$i], $CRIT[$i], $NAME[$i], '', $i, $colors[$i-1], "AREA");
}
?>
