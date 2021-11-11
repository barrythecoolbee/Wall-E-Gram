<?php

function getCoordAsString($coord, $coordRef) {
    $result = "";

    //$_c1 = $coord[0];
    //$_c2 = $coord[1];
    //$_c3 = $coord[2];

    $coordChars = array(0 => "", 1 => "'", 2 => "\"");

    for ($idx = 0; $idx < 3; ++$idx) {
        $cRaw = explode("/", $coord[$idx]);
        $cMain = $cRaw[0];
        $cPow = $cRaw[1];

        $result .= $cMain / $cPow . $coordChars[$idx] . " ";
    }

    $result .= $coordRef;

    return $result;
}

function getCoordInGoogleFormat($latitude, $longitude) {

    $service = "http://geodivagar.appspot.com/geoutil?str=";
    $args = $latitude . " " . $longitude;

    $url = $service . urlencode($args);

    $serviceResponse = file_get_contents($url);

    $coord = json_decode($serviceResponse, true);

    return $coord;
}

function getCoordFromGoogleFormat($latitudeRaw, $longitudeRaw) {

    if ($latitudeRaw < 0) {
        $latitude = $latitudeRaw * -1;
    } else {
        $latitude = $latitudeRaw;
    }

    if ($longitudeRaw < 0) {
        $longitude = $longitudeRaw * -1;
    } else {
        $longitude = $longitudeRaw;
    }

    $service = "http://geodivagar.appspot.com/decimal2dms?decimal=";

    $urlLatitude = $service . urlencode($latitude);
    $urlLongitude = $service . urlencode($longitude);

    $serviceResponseLatitude = file_get_contents($urlLatitude);
    $serviceResponseLongitude = file_get_contents($urlLongitude);

    $result = array();
    $latitudeAsArray = json_decode($serviceResponseLatitude, true);
    $longitudeAsArray = json_decode($serviceResponseLongitude, true);

    if ($latitudeRaw > 0) {
        $result['latitude'] = $latitudeAsArray['graus'] . " " .
                $latitudeAsArray['minutos'] . "' " .
                $latitudeAsArray['segundos'] . "\" N";
    } else {
        $result['latitude'] = $latitudeAsArray['graus'] . " " .
                $latitudeAsArray['minutos'] . "' " .
                $latitudeAsArray['segundos'] . "\" S";
    }

    if ($longitudeRaw > 0) {
        $result['longitude'] = $longitudeAsArray['graus'] . " " .
                $longitudeAsArray['minutos'] . "' " .
                $longitudeAsArray['segundos'] . "\" E";
    } else {
        $result['longitude'] = $longitudeAsArray['graus'] . " " .
                $longitudeAsArray['minutos'] . "' " .
                $longitudeAsArray['segundos'] . "\" W";
    }

    return $result;
}

?>