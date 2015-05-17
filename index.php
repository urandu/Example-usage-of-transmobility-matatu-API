
    <title>SOQO | Matatu Routes</title>
    <link rel="stylesheet"  href="css/bootstrap.css" >
    <link rel="stylesheet" href="css/bootstrap-theme.css" >
    <link rel="stylesheet" href="css/bootstrap-theme.css.map" >
    <link rel="stylesheet" href="css/bootstrap.css.map" >
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="js/jquery.geocomplete.min.js"></script>
<script type="text/javascript" src="//www.google.com/jsapi"></script>

<script type="text/javascript" src="js/jquery.googlemap.js"></script>

<div class="container">
<div class="row span 16">
    <div class="col-lg-4 ">

        <form id="origin_form" >
            <div class="form-group">
                <label >Start (origin/current location):</label><br>
                <input type="text" class="form-control" id="origin">
                <input id="origin_name" type="hidden" name="name" value="">
                <input id="origin_lat" type="hidden" name="lat" value="">
                <input id="origin_lng" type="hidden" name="lng" value="">
            </div>
        </form>
        <form id="destination_form" class="">
            <div class="form-group">
                <label for="origin">Destination (Final location):</label><br>
                <input type="text" class="form-control" id="destination">
                <input id="destination_name" type="hidden" name="name" value="">
                <input id="destination_lat" type="hidden" name="lat" value="">
                <input id="destination_lng" type="hidden" name="lng" value="">
            </div>
        </form>
        <button class="btn btn-primary " id="get_route">Get route</button>
    </div>

    <div class="col-lg-8">

            <div id="advice_div" class="col-lg-6  " >

            </div>





    </div>



</div>
    <div class="row span 12">

        <div class="col-lg-12 right">
            <div id="map" class="col col-lg-12" style="height: 400px" ></div>

        </div>

    </div>
</div>
<script>
    $(function(){
        $("#origin").geocomplete({

            details: "#origin_form",
            types: ["geocode", "establishment"]
        });
        $("#destination").geocomplete({

            details: "#destination_form",
            types: ["geocode", "establishment"]
        });


        $("#get_route").click(function(){


            $.get("http://apis.foundit.co.ke/trans_mobility_v1/stops/get_trip/"+$('#origin_lat').val()+"/"+$('#origin_lng').val()+"/"+$('#destination_lat').val()+"/"+$('#destination_lng').val()+"?callback=json_callback", function(data, status){

                $('#advice_div').text("");
                $('#advice_div').append(" <h3>Route Advice</h3><strong>"+data.advice+"</strong>");


                $("#map").googleMap({
                    zoom: 20, // Initial zoom level (optional)
                    coords: [data.destination.lat, data.destination.lon], // Map center (optional)
                    type: "ROADMAP" // Map type (optional)
                });
                // origin Marker 1
                $("#map").addMarker({
                    coords: [data.origin.lat, data.origin.lon],
                    title: $('#origin_name').val(), // Title
                    text:   'Your location'
                });

                // origin stop Marker 2
                $("#map").addMarker({
                    coords: [data.origin_stop.lat, data.origin_stop.lon],
                    title: data.origin_stop.name, // Title
                    text:   'come to this bus stage from '+$('#origin_name').val()
                });

                // origin terminal Marker 3
                $("#map").addMarker({
                    coords: [data.origin_terminal.lat, data.origin_terminal.lon],
                    title: data.origin_terminal.name, // Title
                    text:   'Alight here '
                });

                // destination terminal Marker 3
                $("#map").addMarker({
                    coords: [data.destination_terminal.lat, data.destination_terminal.lon],
                    title: data.destination_terminal.name // Title
                });
                // destination stop Marker 2
                $("#map").addMarker({
                    coords: [data.destination_stop.lat, data.destination_stop.lon],
                    title: data.destination_stop.name, // Title
                    text: 'Alight here'
                });
                // destination Marker 1
                $("#map").addMarker({
                    coords: [data.destination.lat, data.destination.lon],
                    title: $('#destination_name').val(), // Title
                    text:   'Destination location'
                });


                var line = new google.maps.Polyline({
                    path: [new google.maps.LatLng(data.origin_stop.lat, data.origin_stop.lon), new google.maps.LatLng(data.destination_stop.lat, data.destination_stop.lon)],
                    strokeColor: "#FF0000",
                    strokeOpacity: 1.0,
                    strokeWeight: 10,
                    geodesic: true,
                    map: map
                });

                line.setMap('#map');



            });
        });
    });
</script>
