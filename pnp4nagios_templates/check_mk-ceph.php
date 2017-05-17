<?php
$format = "%5.2lf TB";
$opt[1] = " --vertical-label \"TB\" -X0 -l 0 --title \"Cluster@$hostname: used space\" ";

$def[1] = "DEF:used0=$RRDFILE[1]:$DS[1]:MAX ";
$def[1] .= "CDEF:used=used0,1000,/ ";
$def[1] .= "DEF:free0=$RRDFILE[1]:$DS[2]:MAX ";
$def[1] .= "CDEF:free=free0,1000,/ ";
$def[1] .= "COMMENT:\"       \" ";
$def[1] .= "COMMENT:\"LAST           \" ";
$def[1] .= "COMMENT:\"MAX            \" ";
$def[1] .= "COMMENT:\"AVERAGE        \\n\" ";
$def[1] .= "AREA:used#ff6000:\"Used \" ";
$def[1] .= "GPRINT:used:LAST:\"$format  \" ";
$def[1] .= "GPRINT:used:MAX:\"$format  \" ";
$def[1] .= "GPRINT:used:AVERAGE:\"$format\\n\" ";
$def[1] .= "AREA:free#80ff20:\"Free \":STACK ";
$def[1] .= "GPRINT:free:LAST:\"$format  \" ";
$def[1] .= "GPRINT:free:MAX:\"$format  \" ";
$def[1] .= "GPRINT:free:AVERAGE:\"$format\l\" ";


$format = "%5.2lf %sb/s";
$opt[2] = " --vertical-label \"b/s\" -l 0 --title \"Cluster@$hostname: read/write in b/s\" ";

$def[2] = "DEF:readbs=$RRDFILE[1]:$DS[3]:MAX ";
$def[2] .= "DEF:writebs=$RRDFILE[1]:$DS[5]:MAX ";
$def[2] .= "COMMENT:\"       \" ";
$def[2] .= "COMMENT:\"LAST           \" ";
$def[2] .= "COMMENT:\"MAX            \" ";
$def[2] .= "COMMENT:\"AVERAGE        \\n\" ";
$def[2] .= "AREA:readbs#80ff20:\"Read \" ";
$def[2] .= "GPRINT:readbs:LAST:\"$format     \" ";
$def[2] .= "GPRINT:readbs:MAX:\"$format      \" ";
$def[2] .= "GPRINT:readbs:AVERAGE:\"$format\\n\" ";
$def[2] .= "AREA:writebs#ff6000:\"Write \":STACK ";
$def[2] .= "GPRINT:writebs:LAST:\"$format      \" ";
$def[2] .= "GPRINT:writebs:MAX:\"$format      \" ";
$def[2] .= "GPRINT:writebs:AVERAGE:\"$format\l\" ";


$format = "%5.2lf %sop/s";
$opt[3] = " --vertical-label \"op/s\" -l 0 --title \"Cluster@$hostname: read/write in op/s\" ";

$def[3] = "DEF:readops=$RRDFILE[2]:$DS[4]:MAX ";
$def[3] .= "DEF:writeops=$RRDFILE[2]:$DS[6]:MAX ";
$def[3] .= "COMMENT:\"       \" ";
$def[3] .= "COMMENT:\"LAST               \" ";
$def[3] .= "COMMENT:\"MAX            \" ";
$def[3] .= "COMMENT:\"AVERAGE        \\n\" ";
$def[3] .= "AREA:readops#80ff20:\"Read \" ";
$def[3] .= "GPRINT:readops:LAST:\"$format     \" ";
$def[3] .= "GPRINT:readops:MAX:\"$format     \" ";
$def[3] .= "GPRINT:readops:AVERAGE:\"$format\\n\" ";
$def[3] .= "AREA:writeops#ff6000:\"Write \":STACK ";
$def[3] .= "GPRINT:writeops:LAST:\"$format       \" ";
$def[3] .= "GPRINT:writeops:MAX:\"$format      \" ";
$def[3] .= "GPRINT:writeops:AVERAGE:\"$format\l\" ";
?>
