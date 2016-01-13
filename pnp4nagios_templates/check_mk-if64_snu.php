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

setlocale(LC_ALL, 'C');

# Performance data from check:
# in=6864.39071505;0.01;0.1;0;125000000.0
# inucast=48.496962273;0.01;0.1;;
# innucast=4.60122981717;0.01;0.1;;
# indisc=0.0;0.01;0.1;;
# inerr=0.0;0.01;0.1;;
# out=12448.259172;0.01;0.1;0;125000000.0
# outucast=54.9846963152;0.01;0.1;;
# outnucast=10.5828285795;0.01;0.1;;
# outdisc=0.0;0.01;0.1;;
# outerr=0.0;0.01;0.1;;
# outqlen=0;;;;10000000

# Graph 1: used bandwidth

# Determine if Bit or Byte.
# Change multiplier and labels
$divider = 1;
$unit = "B"; 
$unit_multiplier = 1;
#$vertical_label_name = "MByte/sec";
$vertical_label_name = "Byte/sec";
if (strcmp($MIN[11], "0.0") == 0) {
    $unit = "Bit";
    $unit_multiplier = 8;
#    $vertical_label_name = "MBit/sec";
    $vertical_label_name = "Bit/sec";
}
$bandwidth = $MAX[1]  * $unit_multiplier;
$warn      = $WARN[1] * $unit_multiplier;
$crit      = $CRIT[1] * $unit_multiplier;

# Break down bandwidth, warn and crit
$bwuom = ' ';
$base = 1000;
if($bandwidth > $base * $base * $base) {
    $divider = 1024 * 1024 * 1024;
	$warn /= $base * $base * $base;
	$crit /= $base * $base * $base;
	$bandwidth /= $base * $base * $base;
    $bwuom = 'G';
} elseif ($bandwidth > $base * $base) {
    $divider = 1024 * 1024;
	$warn /= $base * $base;
	$crit /= $base * $base;
	$bandwidth /= $base * $base;
    $bwuom = 'M';
} elseif ($bandwidth > $base) {
    $divider = 1024;
	$warn /= $base;
	$crit /= $base;
	$bandwidth /= $base;
    $bwuom = 'K';
}

$vertical_label_name = $bwuom.$vertical_label_name;
$ds_name[1] = 'Used bandwidth';
$opt[1] = "--vertical-label \"$vertical_label_name\" -b 1024 -X0 --title \"Used bandwidth $hostname / $servicedesc\" ";
$def[1] = 
  "HRULE:0#c0c0c0 ";
      $def[1] .= "HRULE:$bandwidth#808080:\"Port speed\:  " . sprintf("%.1f", $bandwidth) . " ".$bwuom."$unit/s\\n\" ".
                 "HRULE:-$bandwidth#808080: ";
   if ($warn)
      $def[1] .= "HRULE:$warn#ffff00:\"Warning\:                " . sprintf("%6.1f", $warn) . " ".$bwuom."$unit/s\\n\" ".
                 "HRULE:-$warn#ffff00: ";
   if ($crit)
      $def[1] .= "HRULE:$crit#ff0000:\"Critical\:               " . sprintf("%6.1f", $crit) . " ".$bwuom."$unit/s\\n\" ".
                 "HRULE:-$crit#ff0000: ";
    $unit = $bwuom.$unit;
  $def[1] .= "DEF:inbytes=$RRDFILE[1]:$DS[1]:MAX ".
  "DEF:outbytes=$RRDFILE[6]:$DS[6]:MAX ".
  "CDEF:intraffic=inbytes,$unit_multiplier,* ".
  "CDEF:outtraffic=outbytes,$unit_multiplier,* ".
  "CDEF:inp=intraffic,$divider,/ ".
  "CDEF:outp=outtraffic,$divider,/ ".
  "CDEF:minusoutmb=0,outp,- ".
  "AREA:inp#000000:\"in                    \" ".
  "GPRINT:inp:LAST:\"%6.1lf $unit/s last\" ".
  "GPRINT:inp:AVERAGE:\"%6.1lf $unit/s avg\" ".
  "GPRINT:inp:MAX:\"%6.1lf $unit/s max\\n\" ".
  "AREA:minusoutmb#0080e0:\"out                   \" ".
  "GPRINT:outp:LAST:\"%6.1lf $unit/s last\" ".
  "GPRINT:outp:AVERAGE:\"%6.1lf $unit/s avg\" ".
  "GPRINT:outp:MAX:\"%6.1lf $unit/s max\\n\" ";

if (isset($DS[12])) {
  $def[1] .= 
  "DEF:inbytesa=$RRDFILE[12]:$DS[12]:MAX ".
  "DEF:outbytesa=$RRDFILE[13]:$DS[13]:MAX ".
  "CDEF:intraffica=inbytesa,$unit_multiplier,* ".
  "CDEF:outtraffica=outbytesa,$unit_multiplier,* ".
  "CDEF:inpa=intraffica,$divider,/ ".
  "CDEF:outpa=outtraffica,$divider,/ ".
  "CDEF:minusoutmba=0,outpa,- ".
  "LINE:inpa#00a060:\"in (avg)              \" ".
  "GPRINT:inpa:LAST:\"%6.1lf $unit/s last\" ".
  "GPRINT:inpa:AVERAGE:\"%6.1lf $unit/s avg\" ".
  "GPRINT:inpa:MAX:\"%6.1lf $unit/s max\\n\" ".
  "LINE:minusoutmba#0060c0:\"out (avg)             \" ".
  "GPRINT:outpa:LAST:\"%6.1lf $unit/s last\" ".
  "GPRINT:outpa:AVERAGE:\"%6.1lf $unit/s avg\" ".
  "GPRINT:outpa:MAX:\"%6.1lf $unit/s max\\n\" ";
}

# Graph 2: packets
$ds_name[2] = 'Packets';
$opt[2] = "--vertical-label \"packets/sec\" --title \"Packets $hostname / $servicedesc\" ";
$def[2] =
  "HRULE:0#c0c0c0 ".
  "DEF:inu=$RRDFILE[2]:$DS[2]:MAX ".
  "DEF:innu=$RRDFILE[3]:$DS[3]:MAX ".
  "AREA:inu#00ffc0:\"in unicast              \" ".
  "GPRINT:inu:LAST:\"%7.2lf/s last  \" ".
  "GPRINT:inu:AVERAGE:\"%7.2lf/s avg  \" ".
  "GPRINT:inu:MAX:\"%7.2lf/s max\\n\" ".
  "AREA:innu#00c080:\"in broadcast/multicast  \":STACK ".
  "GPRINT:innu:LAST:\"%7.2lf/s last  \" ".
  "GPRINT:innu:AVERAGE:\"%7.2lf/s avg  \" ".
  "GPRINT:innu:MAX:\"%7.2lf/s max\\n\" ".
  "DEF:outu=$RRDFILE[7]:$DS[7]:MAX ".
  "DEF:outnu=$RRDFILE[8]:$DS[8]:MAX ".
  "CDEF:minusoutu=0,outu,- ".
  "CDEF:minusoutnu=0,outnu,- ".
  "AREA:minusoutu#00c0ff:\"out unicast             \" ".
  "GPRINT:outu:LAST:\"%7.2lf/s last  \" ".
  "GPRINT:outu:AVERAGE:\"%7.2lf/s avg  \" ".
  "GPRINT:outu:MAX:\"%7.2lf/s max\\n\" ".
  "AREA:minusoutnu#0080c0:\"out broadcast/multicast \":STACK ".
  "GPRINT:outnu:LAST:\"%7.2lf/s last  \" ".
  "GPRINT:outnu:AVERAGE:\"%7.2lf/s avg  \"  ".
  "GPRINT:outnu:MAX:\"%7.2lf/s max\\n\" ";

# Graph 3: errors and discards
$ds_name[3] = 'Errors and discards';
$opt[3] = "--vertical-label \"packets/sec\" -X0 --title \"Problems $hostname / $servicedesc\" ";
$def[3] =
  "HRULE:0#c0c0c0 ".
  "DEF:inerr=$RRDFILE[5]:$DS[5]:MAX ".
  "DEF:indisc=$RRDFILE[4]:$DS[4]:MAX ".
  "AREA:inerr#ff0000:\"in errors               \" ".
  "GPRINT:inerr:LAST:\"%7.2lf/s last  \" ".
  "GPRINT:inerr:AVERAGE:\"%7.2lf/s avg  \" ".
  "GPRINT:inerr:MAX:\"%7.2lf/s max\\n\" ".
  "AREA:indisc#ffff52:\"in discards             \":STACK ".
  "GPRINT:indisc:LAST:\"%7.2lf/s last  \" ".
  "GPRINT:indisc:AVERAGE:\"%7.2lf/s avg  \" ".
  "GPRINT:indisc:MAX:\"%7.2lf/s max\\n\" ".
  "DEF:outerr=$RRDFILE[10]:$DS[10]:MAX ".
  "DEF:outdisc=$RRDFILE[9]:$DS[9]:MAX ".
  "CDEF:minusouterr=0,outerr,- ".
  "CDEF:minusoutdisc=0,outdisc,- ".
  "AREA:minusouterr#ff0080:\"out errors              \" ".
  "GPRINT:outerr:LAST:\"%7.2lf/s last  \" ".
  "GPRINT:outerr:AVERAGE:\"%7.2lf/s avg  \" ".
  "GPRINT:outerr:MAX:\"%7.2lf/s max\\n\" ".
  "AREA:minusoutdisc#ff9999:\"out discards            \":STACK ".
  "GPRINT:outdisc:LAST:\"%7.2lf/s last  \" ".
  "GPRINT:outdisc:AVERAGE:\"%7.2lf/s avg  \" ".
  "GPRINT:outdisc:MAX:\"%7.2lf/s max\\n\" ";
?>
