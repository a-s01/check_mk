<?php
$format = "%5.2lf";

$opt[1] = " --vertical-label \"%\" -l 0 --title \"$hostname iostat: util\" ";
$def[1] = "DEF:util=$RRDFILE[1]:$DS[3]:MAX ";
$def[1] .= "COMMENT:\"       \" ";
$def[1] .= "COMMENT:\"LAST           \" ";
$def[1] .= "COMMENT:\"MAX            \" ";
$def[1] .= "COMMENT:\"AVERAGE        \\n\" ";
$def[1] .= "LINE2:util#012f7a:\"Util \":STACK ";
$def[1] .= "GPRINT:util:LAST:\"$format%%      \" ";
$def[1] .= "GPRINT:util:MAX:\"$format%%      \" ";
$def[1] .= "GPRINT:util:AVERAGE:\"$format%%\l\" ";


$opt[2] = " --vertical-label \"operation per sec\" -l 0 --title \"$hostname iostat: read/write\" ";

$def[2] = "DEF:read=$RRDFILE[1]:$DS[1]:MAX ";
$def[2] .= "DEF:write=$RRDFILE[1]:$DS[2]:MAX ";
$def[2] .= "COMMENT:\"       \" ";
$def[2] .= "COMMENT:\"LAST           \" ";
$def[2] .= "COMMENT:\"MAX            \" ";
$def[2] .= "COMMENT:\"AVERAGE        \\n\" ";
$def[2] .= "AREA:read#80ff20:\"Read \" ";
$def[2] .= "GPRINT:read:LAST:\"$format     \" ";
$def[2] .= "GPRINT:read:MAX:\"$format      \" ";
$def[2] .= "GPRINT:read:AVERAGE:\"$format\\n\" ";
$def[2] .= "AREA:write#ff6000:\"Write \":STACK ";
$def[2] .= "GPRINT:write:LAST:\"$format      \" ";
$def[2] .= "GPRINT:write:MAX:\"$format      \" ";
$def[2] .= "GPRINT:write:AVERAGE:\"$format\l\" ";


?>
