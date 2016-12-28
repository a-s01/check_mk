<?php
# written by merryvanna (Alyona Solodiankina, alena.vladimirovna@gmail.com)
if (!function_exists('generate')) {
    function generate($RRDFILE, $DS, $WARN, $CRIT, $name, $unit, $varNum = '1', $color = '2080ff', $style='LINE2') {
	$result = "DEF:var$varNum=$RRDFILE:$DS:LAST ";
	$result .= "$style:var$varNum#$color:\"$name\:\" ";
	$result .= "GPRINT:var$varNum:LAST:\"%2.0lf$unit\" ";
	$result .= "GPRINT:var$varNum:MAX:\"(Max\: %2.0lf$unit,\" ";
	$result .= "GPRINT:var$varNum:AVERAGE:\"Avg\: %2.0lf$unit)\\n\" ";
	
	if (isset($WARN) and $WARN) {
	    $result .= "HRULE:$WARN#FFFF00:\"Warning\: $WARN$unit\" ";
	    $result .= "HRULE:$CRIT#FF0000:\"Critical\: $CRIT$unit\" ";
    }
    $result .= "COMMENT:\"\\n\" ";
   return $result; 
}}

$i = 1;
$vars = array();
$colors = array( "8BEA00", "00B25C", "FF4100", "D60062");
$units = array( "voltage" => "V", "current" => "mA", "tx" => "dBm", "rx" => "dBm", "temp" => "C");

while (isset($DS[$i])) {
    $value_name = '';
    $lane = '';

    $tmp = explode("-", $NAME[$i]);

    if (isset($tmp[1])) {
        $value_name = $tmp[1];
        $lane = $tmp[0];
    } else {
        $value_name = $tmp[0];
    }
    $vars[$value_name][] = $i;
    $i++;
}

$graph = 0;
foreach ($vars as $value_name => $nums) {
    $varNum = 0;
    foreach ($nums as $i) {
        $name = str_replace(array("-","_"), " ", $NAME[$i]);
        $opt[$graph] = "--vertical-label \"" . $units[$value_name] . "\" --title \"$name: \" -h 140 ";
        if (! isset($def[$graph])) {
            $def[$graph] = "";
        }
        $def[$graph] .= generate($RRDFILE[$i], $DS[$i], $WARN[$i], $CRIT[$i], $name, $units[$value_name], $varNum, $colors[$varNum]);
        $varNum++; 
    }
    $graph++;
}
?>
