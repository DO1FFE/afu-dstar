<?php
/*
Script für www.funkfreunde-essen.de

DSTAR v2.0 - Updated 08/2023 by Erik Schauer

Original: DSTAR v1.0 - (c) 07/2014 by Erik Schauer 

*/

$version = "2.0";

//DSTAR-Daten definieren
$call = isset($_GET["call"]) ? $_GET["call"] : "DO1FFE";
$image = isset($_GET["image"]) ? $_GET["image"] : null;

if ($call) {
    // Input validation
    if (!preg_match("/^[a-zA-Z0-9]+$/", $call)) {
        echo "Ungültiges Rufzeichen.";
        exit;
    }

    $suche = $call;

    $file = fopen("http://status.ircddb.net/cgi-bin/ircddb-user?callsign=" . $call, "r");

    if (!$file) {
        echo "<b>ERROR</b>";
        exit;
    }
    $status = '<b><font color="red">***KEIN DSTAR AKTIV***</font></b>';
    while (!feof ($file)) {
        $line = fgetss ($file, 10240);
        if (preg_match("/" . $suche . "/i", $line, $out)) {
            $line = explode(" ", $line);

            $status = '<b><font color="green">';
            $datum = str_replace("position.1", "", $line[110]);
            $rufzeichen = str_replace(["&nbsp;", "  "], [" ", " "], $line[111]);
            $rufzeichen = explode(" ", $rufzeichen);

            $mycall = str_replace("_", "&nbsp;", $rufzeichen[1]);
            $rptcall = str_replace("_", "&nbsp;", $rufzeichen[2]);
            $gwcall = str_replace("_", "&nbsp;", $rufzeichen[3]);
            $zeit = $rufzeichen[0];

            $status = "<font color=\"green\"><b>".$mycall." via ".$rptcall."</b><br><font size='-2'>".$datum." - ".$zeit." Uhr UTC</font></font>";
        }
    }
    fclose($file);

    if ($image == "1") {
        $mycall = str_replace("_", " ", $rufzeichen[1]);
        $rptcall = str_replace("_", " ", $rufzeichen[2]);

        $status1 = $mycall . " via " . $rptcall;
        $status2 = $datum . " - " . $zeit . " Uhr UTC";
        Header("Content-Type: image/png");

        $width = 300;
        $height = 99;
        $img = ImageCreate($width, $height);

        $colors = [
            "black" => ImageColorAllocate($img, 0, 0, 0),
            "red" => ImageColorAllocate($img, 255, 0, 0),
            "yellow" => ImageColorAllocate($img, 255, 255, 0),
            "white" => ImageColorAllocate($img, 255, 255, 255)
        ];

        ImageFill($img, 0, 0, $colors["red"]);
        ImageFilledRectangle($img, 0, 0, 300, 33, $colors["black"]);
        ImageFilledRectangle($img, 0, 101, 300, 66, $colors["yellow"]);
        ImageString($img, 5, 100, 10, "DSTAR-Status", $colors["white"]);
        ImageString($img, 5, 60, 41, $status1, $colors["white"]);
        ImageString($img, 5, 20, 71, $status2, $colors["black"]);
        ImageString($img, 2, 220, 85, "(c) by DO1FFE", $colors["black"]);

        ImagePNG($img);
        ImageDestroy($img);
    } else {
        echo $status;
    }
} else {
    $filea = 'dstar.php';
    $fs = date("d.m.Y", filemtime($filea));

    echo "<b>DSTAR V".$version." - &copy; ".$fs." by Erik Schauer, DO1FFE</b><br><br>";
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
