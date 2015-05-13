<!--<DOCTYPE! html>
<html>
<head>-->
    <title>SOQO | Matatu Routes</title>
    <link rel="stylesheet"  href="css/bootstrap.css" >
    <link rel="stylesheet" href="css/bootstrap-theme.css" >
    <link rel="stylesheet" href="css/bootstrap-theme.css.map" >
    <link rel="stylesheet" href="css/bootstrap.css.map" >
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="js/jquery.geocomplete.js"></script>
<script type="text/javascript" src="//www.google.com/jsapi"></script>

<script type="text/javascript" src="js/jquery.googlemap.js"></script>
<!--</head>-->
<!--<body class="container">-->
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
        <!--<div class="col-lg-2 right">
            .

        </div>-->
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
           // alert($('#origin_lng').val());

            $.get("http://41.89.64.240/projects/trans_mobility/stops/get_trip/"+$('#origin_lat').val()+"/"+$('#origin_lng').val()+"/"+$('#destination_lat').val()+"/"+$('#destination_lng').val(), function(data, status){
                //alert("Data: " + data + "\nStatus: " + status);
                //var json = JSON.parse(data);
                //alert("Advice: " + data.advice );
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

                /*$("#map").addWay({
                    start: new google.maps.LatLng(data.origin.lat, data.origin.lon), // Postal address for the start marker (obligatory)
                    end:  [data.origin_stop.lat, data.origin_stop.lon], // Postal Address or GPS coordinates for the end marker (obligatory)
                    route : 'way', // Block's ID for the route display (optional)
                    langage : 'english' // language of the route detail (optional)
                    step: [ // Array of steps (optional)
                        [48.85837009999999, 2.2944813000000295] // Postal Address or GPS coordinates of the step
                        "Porte Maillot, 75017 Paris", // Postal Address or GPS coordinates of the step
                    ]
                });
*/

            });
        });
    });
</script>

<!--</body>
</html>-->