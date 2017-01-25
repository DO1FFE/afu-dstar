<?php
/*
Script für www.funkfreunde-essen.de

DSTAR v1.0 - (c) 07/2014 by Erik Schauer 

*/
$version = "1.0";

//DSTAR-Daten definieren
if (isset($HTTP_GET_VARS["call"])) {
	$call 		= $HTTP_GET_VARS["call"];
} else {
	$call		= "DO1FFE";
}
$image = $HTTP_GET_VARS["image"];

//echo "<html>\n<head>\n";


if (isset($HTTP_GET_VARS["call"])) {

$suche = $call;

//echo '<br> Call: '.$call.'<br>';

//$file = fopen("http://176.10.105.252/dcs_userstatus.htm", "r");
$file = fopen("http://status.ircddb.net/cgi-bin/ircddb-user?callsign=".$call, "r");

if (!$file) {
	echo "<b>ERROR</b>";
	exit;
}
$status = '<b><font color="red">***KEIN DSTAR AKTIV***</font></b>';
while (!feof ($file)) {
$line = fgetss ($file, 10240);
//$line2 = fgets ($file, 10240);
if (eregi ($suche , $line, $out)) {


//$line = $line2;
$line = explode(" ",$line);

$status = '<b><font color="green">';
$datum = str_replace("position.1", "", $line[110]);
$rufzeichen = str_replace("&nbsp;", " ", $line[111]);
$rufzeichen = str_replace("  ", " ", $rufzeichen);
$rufzeichen = explode(" ", $rufzeichen);

$mycall = $rufzeichen[1];
if ($call == "DO1MFR") {
	$mycall = "DO1xxx__";
}
$mycall = str_replace("_", "&nbsp;", $mycall);
$rptcall = $rufzeichen[2];
$rptcall = str_replace("_", "&nbsp;", $rptcall);
$gwcall = $rufzeichen[3];
$gwcall = str_replace("_", "&nbsp;", $gwcall);
$zeit = $rufzeichen[0];


$status = "<font color=\"green\"><b>".$mycall." via ".$rptcall."</b><br><font size='-2'>".$datum." - ".$zeit." Uhr UTC</font></font>";

}

}
fclose($file);

if ($image == "1") {

$mycall = $rufzeichen[1];
if ($call == "DO1MFR") {
	$mycall = "DO1xxx__";
}
$mycall = str_replace("_", " ", $mycall);
$rptcall = $rufzeichen[2];
$rptcall = str_replace("_", " ", $rptcall);

$status1 = $mycall." via ".$rptcall;
$status2 = $datum." - ".$zeit." Uhr UTC";
Header("Content-Type: image/png");
# Hier wird der Header gesendet, der später die Bilder "rendert" ausser png kann auch jpeg dastehen

##################################################
$width = 300; # Später die Breite des Rechtecks
$height = 99; # Später die Höhe des Rechtecks
$img = ImageCreate($width, $height); # Hier wird das Bild einer Variable zu gewiesen
##################################################

##################################################
$black = ImageColorAllocate($img, 0, 0, 0); # Hier wird die Farbe schwarz einer Variable zugewiesen
$red = ImageColorAllocate($img, 255, 0, 0); # Hier wird die Farbe rot einer Variable zugewiesen
$yellow = ImageColorAllocate($img, 255, 255, 0); # Hier wird die Farbe gelb einer Variable zugewiesen
$white = ImageColorAllocate($img, 255, 255, 255); # Hier wird der Variable $white die Farbe weiß zugewiesen 
##################################################


##################################################
ImageFill($img, 0, 0, $red); # Erst wird das Bild mit gelb gefüllt.
ImageFilledRectangle($img, 0, 0, 300, 33, $black); # Mit ImageFillRectangle wird ein weiter Bereich des Bildes mit schwarz gefüllt
# Die 1. 0 ist die Entfernung in px von Links.
# Die 2. 0 ist die Entfernung in px von Oben.
# Die 300 ist die Breite der Farbe.
# Die 100 ist die Höhe der Farbe.
ImageFilledRectangle($img, 0, 101, 300, 66, $yellow);
# Hier die gleichen Sachen wie bei der Schwarzfüllung, nur mit anderen Koordinaten und anderer Farbe.
ImageString($img, 5, 100, 10, "DSTAR-Status", $white);
ImageString($img, 5, 60, 41, $status1, $white);
ImageString($img, 5, 20, 71, $status2, $black);
ImageString($img, 2, 220, 85, "(c) by DO1FFE", $black); 
##################################################
ImagePNG($img);
ImageDestroy($img);
} else {
	echo $status;
}


// Anderenfalls Syntax ausgeben.
} else {

   	$filea = 'dstar.php';
	$fs = date("d.m.Y",filemtime($filea));

	echo "<b>DSTAR V".$version." - &copy; ".$fs." by Erik Schauer, DO1FFE - www.funkfreunde-essen.de</b><br><br>";
	echo "<b>Sinn dieses Scripts: Anzeigen wann ein User &uuml;ber welchen Repeater in DSTAR online war<br></b>";
	echo "<br><br>";
	echo "
	<table>
	<tr>
		<td><b><font size=\"+2\"><u>Syntax:</b></u></font></td>
	</tr>
	<tr>
		<td><b>Aufrufbeispiel:</b></td>
		<td>dstar.php?call=<b>CALL</b></td><td>Zeigt an, wann <b>CALL</b> zuletzt geh&ouml;rt wurde</td>
	</tr>
	<tr>
	<td></td><td>dstar.php?call=<b>CALL</b>&image=1</td><td>Daten wie oben - kann als IMAGE auf einer Homepage eingebunden werden</td>
	</tr>
	</table><br><br>";
}
?>
