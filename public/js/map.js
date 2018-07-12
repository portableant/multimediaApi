var map;
var myCenter = new google.maps.LatLng(51.5194133, -0.1291453);
function initialize() {

}

google.maps.event.addDomListener(window, 'load', initialize);
google.maps.event.addDomListener(window, "resize", resizeMap());

$('#myModal').on('shown.bs.modal', function (e) {
    resizeMap($(e.relatedTarget).data('center'));
});


function resizeMap(center) {
    var mapProp = {
        center: myCenter,
        zoom: 20,
        draggable: true,
        scrollwheel: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl: false,
        mapTypeControl: false
    };

    map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);
    //var streetViewLayer = new google.maps.StreetViewCoverageLayer();
    //streetViewLayer.setMap(map);
    if (typeof map == "undefined") return;
    google.maps.event.trigger(map, "resize");
    map.setCenter(center);
    var marker = new google.maps.Marker({
        position: center,
        map: map,
        animation: google.maps.Animation.DROP,
        title: "Object location",
        icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 5
        }
    });
    marker.setMap(map);
}
