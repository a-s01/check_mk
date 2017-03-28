<?php
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
}
?>
