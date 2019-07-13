<?php

$CI = get_instance();
require_once(APPPATH . 'third_party/mapbox/geocoder/Mapbox.php');

function forwardGeocode($address) {

    $mapbox = new Mapbox("pk.eyJ1IjoiZGV4ciIsImEiOiJjanZzcndybDYwdWVmM3pvZWFpcnBsYmRhIn0.bl_iQq9nNrlVGVMU6TZOyA");
    
    //$address = "149 9th St, San Francisco, CA 94103";
    $res = $mapbox->geocode($address);

    if ($res->success()) {
        $add = $res->getData();
        return $add[0];
    } else {
        return false;
    }
}
