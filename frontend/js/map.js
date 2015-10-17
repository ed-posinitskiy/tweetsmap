var map = (function () {
    var _map = null,
        _mapId = 'google-map',
        _center = {lat: 13.7308, lng: 100.521};

    return {
        init: function() {
            _map = new google.maps.Map(document.getElementById(_mapId), {
                center: _center,
                zoom: 10
            });
        }
    };
})();