<div style="height:50px;"></div>
<footer>
    <div class="bs-component">
        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="container-fluid">
                <div class="navbar-header">                    
                    <div style='margin:8px; font-size:9px;'>Copyright <?php echo date('Y'); ?> <a href="/">dexr.</a> All rights reserved. No claim is made to data accuracy. Dexr.io is not a consumer reporting agency. <br>By using this site you are stating that you have read & agree to our <a href='/privacy' rel='nofollow'>Privacy Policy</a> as well as <a href='/tac' rel='nofollow'>Terms & Conditions</a> | <a href="/help" rel="nofollow">Help Center</a> <?php
                        if (isset($optOutLink)) {
                            echo $optOutLink;
                        }
                        ?></div>
                </div>
            </div>
        </nav>
    </div>
</footer>

<div class="modal fade" id="thinker" tabindex="-1" role="dialog" aria-labelledby="thinker" data-backdrop="static">
    <div class="modal-dialog" style=" "  role="document">
        <div class="modal-content" style="background-color:transparent; border: 0px solid grey; box-shadow: unset; webkit-box-shadow: unset; position:relative; top:100px;">
            <div class="modal-body">
                <div class='col-sm-12 text-center'>
                    <img src="/assets/images/loading.gif">
                </div>                                
            </div>
        </div>
    </div>
</div>

<?php
$locs = "";
$markers = "";
$markerNames = "";

$i = 1;
if (isset($mapAddresses) && count($mapAddresses) > 1 && !empty($mapAddresses[0])) {
    foreach ($mapAddresses as $address) {
        $coor = geocode($address, $_SERVER['HTTP_USER_AGENT']);

        $locs .= "loc" . $i . " = new L.LatLng(" . $coor['lat'] . ", " . $coor['long'] . ")," . PHP_EOL;
        if ($i > 1) {
            $markerNames .= ", loc" . $i;
        }

        $markers .= "var greenIcon" . $i . " = L.icon({
            iconUrl: '/assets/images/custom-marker-green-outer-solid-small.png',
            iconSize: [32, 47],
            iconAnchor: [32, 44],
            className: 'my-markers marker-" . $i . "'
        });" . PHP_EOL;

        $markers .= "L.marker([" . $coor['lat'] . ", " . $coor['long'] . "], {icon: circleIcon}).addTo(map);" . PHP_EOL;
        $markers .= "L.marker([" . $coor['lat'] . ", " . $coor['long'] . "], {icon: greenIcon" . $i . "}).addTo(map);" . PHP_EOL;

        $i++;
    }
    ?>

    <script>
        var map = L.map('map_canvas');

        var circleIcon = L.icon({
            iconUrl: '/assets/images/circle-marker.png',
            iconSize: [13, 15], // size of the icon
            iconAnchor: [23, 5], // point of the icon which will correspond to marker's location
            className: 'circle-markers'
        });

        // add an OpenStreetMap tile layer
        L.tileLayer('https://{s}.tiles.mapbox.com/v3/cdshowers23.i628d3l8/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);

    <?php echo "var " . $locs; ?>
        bounds = new L.LatLngBounds(loc1<?php echo $markerNames; ?>);

    <?php echo $markers; ?>

        map.fitBounds(bounds, {padding: [50, 50]});
    </script>
    <?php
} elseif (isset($mapAddresses) && !empty($mapAddresses)) {
    $coor = geocode($mapAddresses[0], $_SERVER['HTTP_USER_AGENT']);
    ?>
    <script>
        var map = L.map('map_canvas').setView([<?php echo $coor['lat']; ?>, <?php echo $coor['long']; ?>], 13);

        L.tileLayer('https://{s}.tiles.mapbox.com/v3/cdshowers23.i628d3l8/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);

        var greenIcon = L.icon({
            iconUrl: '/assets/images/custom-marker-green-outer-solid-small.png',
            iconSize: [32, 47],
            iconAnchor: [32, 44],
            className: 'main-marker'
        });

        L.marker([<?php echo $coor['lat']; ?>, <?php echo $coor['long']; ?>], {icon: greenIcon}).addTo(map);

    </script>
<?php } ?>
</body>
</html>
