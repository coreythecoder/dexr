<?php

$CI = get_instance();
require_once(APPPATH . 'third_party/mapbox/geocoder/Mapbox.php');

function forwardGeocode($address) {

    $mapbox = new Mapbox("pk.eyJ1IjoiY2RzaG93ZXJzMjMiLCJhIjoiZF9zUFY2cyJ9.75SOCtl7m15KMrxB8bvJoQ");
    
    //$address = "149 9th St, San Francisco, CA 94103";
    $res = $mapbox->geocode($address);

    if ($res->success()) {
        $add = $res->getData();
        return $add[0];
    } else {
        return false;
    }
}
