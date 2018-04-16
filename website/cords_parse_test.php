<?php

require_once '__sentry.php';

header('Content-Type: text/html; charset=utf-8');

function testcoords($coords)
{
    $y = cords_parse($coords[1]);
    $format = $y['format'];
    $x = 12;
    $lat1 = round($y[0], $x);
    $lon1 = round($y[1], $x);
    $lat2 = round($coords[2], $x);
    $lon2 = round($coords[3], $x);
    $bad = "<span style='color:red;'><b>ZLE!</b></span>";
    $good = "<span style='color:green;'>OK :)</span>";

    return '<tr><td><b>'.$coords[0].':</b></td><td>'.$coords[1]."</td><td>$format</td><td>lat=$lat1 ".($lat1 == $lat2 ? $good : $bad." ($lat2)")."</td><td>lon=$lon1 ".($lon1 == $lon2 ? $good : $bad." ($lon2)").'</td></tr>';
}

// function testcoords2($info, $coords, $wynik)
// {
    // list($lat, $lon) = cords_parse($coords);
    // $coords = addslashes($coords);
    // echo "array ('$info','$coords',$lat,$lon),<br/>";
// }

require 'cords_parse.php';

$aa = array(
array('test 1', 'N 12% 27.758E022%50.999', 12.462633333333, 22.849983333333),
array('test 2', 'S 52°36.002 E013°19.2052', -52.600033333333, 13.320086666667),
array('test 3', '52 12.3123 21 11.45345 ', 52.205205, 21.190890833333),
array('test 4', 'N 52° 7\' 24.4452\", E 21° 11\' 27.21\" ', 52.123457, 21.190891666667),
array('test 5', 'n 53° 8\' 9\" W 23° 9\' 21\"', 53.135833333333, -23.155833333333),
array('test 6', '- 49°49`59.282\" E 09°52´21.216\"', -49.833133888889, 9.87256),
array('test 7', 'N52 12.3123 E21 11.45345 ', 52.205205, 21.190890833333),
array('test 8', 'N 52 12.3123 E 21 11.45345 ', 52.205205, 21.190890833333),
array('test 9', 'N 52° 10.369\' - 021° 01.542\'', 52.172816666667, -21.0257),
array('test 10', 'N 49°49.59 W 09°52.2', 49.8265, -9.87),
array('test 11', '52.205205 21.190891', 52.205205, 21.190891),
array('test 12', '52.205205/21.190891', 52.205205, 21.190891),
array('test 13', '52.205205\21.190891', 52.205205, 21.190891),
array('test 14', 'N 52.205205 W 21.190891', 52.205205, -21.190891),
array('test 15', '-52.205205 +21.190891', -52.205205, 21.190891),
array('test 16', 'N 12° 04.076 E 010°49.132', 12.067933333333, 10.818866666667),
array('test 17', 'N 12°20.74068\', E 012°20.74068\'', 12.345678, 12.345678),
array('test 18', 'N 12° 20\' 44.4408", E 12 20 44.4408', 12.345678, 12.345678),
array('test 19', 'N 53° 8\' 9" E 23° 9\' 21"', 53.135833333333, 23.155833333333),
array('test 20', 'N 43º 05.046 W 0º 02.700', 43.0841, -0.045),
array('test 21', 'N 50°44.044 E 015°39.890', 50.734066666667, 15.664833333333),
array('test 22', 'N 52° 32.093 E 13°18.329', 52.534883333333, 13.305483333333),
array('test 23', 'N 050° 08.244 O 010° 39.008', 0, 0),
array('test 24', 'N 050° 08.244 O 010° 39.008\'', 0, 0),
array('test 25', 'N 12.12°20.74068\' , E 012°,20.74068\'', 0, 0),
array('test 26', 'N 50° 04.076 E 010°49.132\"', 50.067933333333, 10.818866666667),
array('test 27', 'N 53°8\'9.553\" E E23°9\'21.69\"', 0, 0),
array('test 28', 'N 53° 8\' 9" E 23° 9\' 21"', 53.135833333333, 23.155833333333),
array('test 29', 'N48°33.670 E10°39.466', 48.561166666667, 10.657766666667),
array('test 30', 'N 52°36.002 E 013° 19.205', 52.600033333333, 13.320083333333),
array('test 31', '12.20.740 12.20.740', 0, 0),
array('test 32', 'N 53º.48.106 E 002º 52.974', 0, 0),
array('test 33', '48° 46 .891 009° 53. 991', 0, 0),
array('test 34', '49.65 732 011.29 513', 0, 0),
array('test 35', '50°15\'36\'\', 21°58\'13\'\'', 50.26, 21.970277777778),
array('test 36', 'N 12° 24 44 W 002° 02 69', 0, 0),
array('test 37', 'N 12° 24 440 W 002° 02 690', 0, 0),
array('test 38', 'N 12° 24 E 002° 05', 12.4, 2.083333333333),
array('test 39', '12 24 02 06', 12.4, 2.1),
array('test 40', '-12 24 02 06', -12.4, 2.1),
array('test 41', '12 -24 02 06', 0, 0),
array('test 42', '12 24 -02 006', 0, 0),
array('test 43', '12 24 02 -06', 0, 0),
array('test 44', '12 24. 02 06', 0, 0),
array('test 45', '12 24 0.2 06', 0, 0),
array('test 46', '12 24 02 06.', 0, 0),
array('test 47', 'N 049° 01,437\' O 011° 56,859\'', 0, 0),
array('test 48', '34 U 500151 5790659', 0, 0),
array('test 49', 'N50 47.101 W002 02 069', 0, 0),
array('test 50', '23 23 23.0 45 45 45.0', 23.389722222222, 45.7625),
array('test 51', '23 23 23 45 45 45', 0, 0),
array('test ', '', 0, 0),
array('test ', '', 0, 0),

array('test ', '', 0, 0),
array('kuniec! ', '0 0', 0, 0),
);

echo "<table width='1000'>";
foreach ($aa as $i => $value) {
    $q = testcoords($value).$q;
}
echo $q;
echo '</table>';