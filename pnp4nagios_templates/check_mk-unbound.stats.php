<?php
# +------------------------------------------------------------------+
# |             ____ _               _        __  __ _  __           |
# |            / ___| |__   ___  ___| | __   |  \/  | |/ /           |
# |           | |   | '_ \ / _ \/ __| |/ /   | |\/| | ' /            |
# |           | |___| | | |  __/ (__|   <    | |  | | . \            |
# |            \____|_| |_|\___|\___|_|\_\___|_|  |_|_|\_\           |
# |                                                                  |
# | Copyright Mathias Kettner 2013             mk@mathias-kettner.de |
# +------------------------------------------------------------------+
#
# This file is part of Check_MK.
# The official homepage is at http://mathias-kettner.de/check_mk.
#
# check_mk is free software;  you can redistribute it and/or modify it
# under the  terms of the  GNU General Public License  as published by
# the Free Software Foundation in version 2.  check_mk is  distributed
# in the hope that it will be useful, but WITHOUT ANY WARRANTY;  with-
# out even the implied warranty of  MERCHANTABILITY  or  FITNESS FOR A
# PARTICULAR PURPOSE. See the  GNU General Public License for more de-
# ails.  You should have  received  a copy of the  GNU  General Public
# License along with GNU Make; see the file  COPYING.  If  not,  write
# to the Free Software Foundation, Inc., 51 Franklin St,  Fifth Floor,
# Boston, MA 02110-1301 USA.

$colors = array("#a00000",
				"#ff4000", 
				"#00f040",
				"#00b0b0",
				"#c060ff",
				"#f000f0",
				"#FFDD00",
				"#fb9914",
                "#cccccc",
                "#006400",
                "#0000FF",
                "#FF1493",
                "#8B4513",
                "#111111",
                "#000080",
                '#800080',
                "#00FFFF",
                "#FFFFFF",
);

$maxlength = 0;
$opt[1] = "--vertical-label 'queries / second' -u 10 -X0 --title \" Unbound stats: $servicedesc\" ";
$def[1] = "";

$i=1;
while (isset($DS[$i])) {
    $len = strlen($NAME[$i]);
    if ($len > $maxlength) {
        $maxlength = $len;
    }
    $i++;
}

$i=1;
while (isset($DS[$i])) {
    $name = $NAME[$i];

        $space = $maxlength - strlen($name);
        if ($space > 0) {
            $space = str_repeat(" ", $space);
        } else {
            $space = '';
        }

    	$def[1] .= "DEF:$name=$RRDFILE[$i]:$DS[$i]:MAX ";
	    $def[1] .= "AREA:$name$colors[$i]:\"$name\":STACK ";
        $def[1] .= "GPRINT:$name:LAST:\"$space Last\:%9.2lf,\" ";
        $def[1] .= "GPRINT:$name:MAX:\" Max\:%9.2lf,\" ";
        $def[1] .= "GPRINT:$name:AVERAGE:\"Avg\:%9.2lf\\n\" ";
	$i++;
}
