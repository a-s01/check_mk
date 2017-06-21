<?php
# +------------------------------------------------------------------+
# # |             ____ _               _        __  __ _  __           |
# # |            / ___| |__   ___  ___| | __   |  \/  | |/ /           |
# # |           | |   | '_ \ / _ \/ __| |/ /   | |\/| | ' /            |
# # |           | |___| | | |  __/ (__|   <    | |  | | . \            |
# # |            \____|_| |_|\___|\___|_|\_\___|_|  |_|_|\_\           |
# # |                                                                  |
# # | Copyright Mathias Kettner 2013             mk@mathias-kettner.de |
# # +------------------------------------------------------------------+
# #
# # This file is part of Check_MK.
# # The official homepage is at http://mathias-kettner.de/check_mk.
# #
# # check_mk is free software;  you can redistribute it and/or modify it
# # under the  terms of the  GNU General Public License  as published by
# # the Free Software Foundation in version 2.  check_mk is  distributed
# # in the hope that it will be useful, but WITHOUT ANY WARRANTY;  with-
# # out even the implied warranty of  MERCHANTABILITY  or  FITNESS FOR A
# # PARTICULAR PURPOSE. See the  GNU General Public License for more de-
# # ails.  You should have  received  a copy of the  GNU  General Public
# # License along with GNU Make; see the file  COPYING.  If  not,  write
# # to the Free Software Foundation, Inc., 51 Franklin St,  Fifth Floor,
# # Boston, MA 02110-1301 USA.
if (!function_exists('generate')) {
    function generate($RRDFILE, $DS, $WARN, $CRIT, $name, $unit, $varNum = '1', $color = '2080ff', $style='LINE2') {
	$result = "DEF:var$varNum=$RRDFILE:$DS:MAX ";
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
#include_once 'generate-cisco_sensor.php';

$i = 1;
#$title = str_replace("_", " ", $servicedesc);
$optic = 0;
$varNum = 1;
#$colors = array( "receive_power" => "00c0ff", "transmit_power" => "00cc00");
$colors = array( "receive_power" => "00c0ff", "transmit_power" => "00cc00", "rx" => "00c0ff", "tx" => "00cc00");

while (isset($DS[$i])) {
    $units = [];
    $name = '';
    
    preg_match("/-([^-]*)$/", $NAME[$i], $units);
    $name = preg_replace("/-[^-]*$/", "", $NAME[$i]);

    if ($name == "transmit_power" or $name == "receive_power" or $name == "tx" or $name == "rx") {
        $opt[$optic] = "--vertical-label \"$units[1]\" --title \"$servicedesc: optic info\" -h 140 ";
        if (! isset($def[$optic])) {
            $def[$optic] = "";
        }
        $def[$optic] .= generate($RRDFILE[$i], $DS[$i], $WARN[$i], $CRIT[$i], $name, $units[1], $varNum, $colors[$name]);
        $varNum++; 
    } else {
        $name = str_replace("_", " ", $name);

	    $opt[$i] = "--vertical-label \"$units[1]\" --title \"$servicedesc: $name\" -h 140 ";
        $def[$i] = generate($RRDFILE[$i], $DS[$i], $WARN[$i], $CRIT[$i], $name, $units[1]);
    }
    $i++;
}

?>
