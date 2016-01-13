#created by snus
<?php
$opt[1] = "--vertical-label 'IP utilization %' -l0  -u 100 --title \"IP Utilization for $servicedesc\" ";
$def[1] = "DEF:usage=$RRDFILE[1]:$DS[1]:AVERAGE "
        . "AREA:usage#ff6000:\"Usage\" "
        . "GPRINT:usage:LAST:\"%5.0lf%%\" "
		. "GPRINT:usage:MAX:\"(Max\: %5.0lf%%,\" "
		. "GPRINT:usage:AVERAGE:\"Avg\: %5.0lf%%)\\n\" "
		. "TEXTALIGN:left "
		. "HRULE:$WARN[1]#FFFF00:\"Warning\: $WARN[1]%\" "
        . "HRULE:$CRIT[1]#FF0000:\"Critical\: $CRIT[1]%\" "
        . "";


$opt[2] = "--vertical-label 'IP stats' -l0  -u 100 --title \"IP stats for $servicedesc\" ";
$def[2] = "DEF:total=$RRDFILE[1]:$DS[2]:AVERAGE "
        . "AREA:total#60f020:\"Total    \" "
        . "GPRINT:total:LAST:\"%5.0lf\\n\" "
        . "DEF:busy=$RRDFILE[1]:$DS[3]:AVERAGE "
        . "AREA:busy#ff6000:\"Busy     \" "
        . "GPRINT:busy:LAST:\"%5.0lf\" "
		. "GPRINT:busy:MAX:\"(Max\: %5.0lf,\" "
		. "GPRINT:busy:AVERAGE:\"Avg\: %5.0lf)\\n\" "
        . "DEF:allocated=$RRDFILE[1]:$DS[4]:AVERAGE "
        . "AREA:allocated#FFFF00:\"Allocated\" "
        . "GPRINT:allocated:LAST:\"%5.0lf\" "
		. "GPRINT:allocated:MAX:\"(Max\: %5.0lf,\" "
		. "GPRINT:allocated:AVERAGE:\"Avg\: %5.0lf)\\n\" "
        . "DEF:reserved=$RRDFILE[1]:$DS[5]:AVERAGE "
        . "AREA:reserved#666666:\"Reserved \" "
        . "GPRINT:reserved:LAST:\"%5.0lf\" "
		. "GPRINT:reserved:MAX:\"(Max\: %5.0lf,\" "
		. "GPRINT:reserved:AVERAGE:\"Avg\: %5.0lf)\\n\" "
		. "TEXTALIGN:left "
        . "";

?>
