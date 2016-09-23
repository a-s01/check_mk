<?php
$opt[1] = "--vertical-label 'Storage usage GB' -l0  -u 100 --title \"Storage usage for $servicedesc\" ";

$def[1] =   "DEF:used=$RRDFILE[1]:$DS[1]:AVERAGE " 
        .   "DEF:free=$RRDFILE[1]:$DS[2]:AVERAGE " 
        .   "AREA:used#60f020:\"Used\":STACK "
        .   "GPRINT:used:AVERAGE:\"%4.1lfGB  \" "
        .   "AREA:free#ff6000:\"free\":STACK "
        .   "GPRINT:free:AVERAGE:\"%4.1lfGB  \" "
        .   "";


$opt[2] = "--vertical-label 'Storage IO in b/s' -l0  -u 100 --title \"Storage read IO in b/s for $servicedesc\" ";
$def[2] =   "DEF:read=$RRDFILE[1]:$DS[3]:MAX " 
        .   "LINE:read#60f020:\"Read\":STACK "
        .   "GPRINT:read:LAST:\"%9.1lfb/s  \" "
        .   "GPRINT:read:MIN:\"min %9.1lfb/s  \" "
        .   "GPRINT:read:MAX:\"max %9.1lfb/s\\n\" "
        .   "";

$opt[3] = "--vertical-label 'Storage IO in b/s' -l0  -u 100 --title \"Storage write IO in b/s for $servicedesc\" ";
$def[3] =   "DEF:write=$RRDFILE[1]:$DS[5]:MAX " 
        .   "LINE:write#ff6000:\"Write\" "
        .   "GPRINT:write:LAST:\"%9.1lfb/s  \" "
        .   "GPRINT:write:MIN:\"min %9.1lfb/s  \" "
        .   "GPRINT:write:MAX:\"max %9.1lfb/s\\n\" "
        .   "";
 
$opt[4] = "--vertical-label 'Storage IO in op/s' -l0  -u 100 --title \"Storage IO in op/s for $servicedesc\" ";
$def[4] =   "DEF:read=$RRDFILE[1]:$DS[4]:MAX " 
        .   "DEF:write=$RRDFILE[1]:$DS[6]:MAX " 
        .   "LINE:read#60f020:\"Read \":STACK "
        .   "GPRINT:read:LAST:\"%5.1lfop/s  \" "
        .   "GPRINT:read:MIN:\"min %5.1lfop/s  \" "
        .   "GPRINT:read:MAX:\"max %5.1lfop/s\\n\" "
        .   "LINE:write#ff6000:\"Write\" "
        .   "GPRINT:write:LAST:\"%5.1lfop/s  \" "
        .   "GPRINT:write:MIN:\"min %5.1lfop/s  \" "
        .   "GPRINT:write:MAX:\"max %5.1lfop/s\\n\" "
        .   "";


?>
