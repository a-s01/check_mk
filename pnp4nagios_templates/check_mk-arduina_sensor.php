<?php
$unit = "C";
$opt[1] = '--vertical-label "' . $unit . '" --title "' . $servicedesc . '" -h 140';
$def[1]  = rrd::def("var1", $RRDFILE[1], $DS[1], "AVERAGE");
$def[1] .= rrd::line1   ("var1", '#000000', "$NAME[1]\:");
$def[1] .= rrd::gprint  ("var1", array("LAST","MAX","AVERAGE"), "%3.2lf".$unit);
if ($WARN[1] != "") {
    $def[1] .= rrd::hrule($WARN[1], '#FF0000', "Critical (min)\: $WARN[1]$unit \\n");
}
if ($CRIT[1] != "") {
    $def[1] .= rrd::hrule($CRIT[1], '#FF0000', "Critical (max)\: $CRIT[1]$unit \\n");
}
#$def[1] .= rrd::comment("\\r");
?>
