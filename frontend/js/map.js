var map = (function () {
    var _map = null,
        _mapId = 'google-map',
        _center = {lat: 13.7308, lng: 100.521},
        _placesService = null;

    var events = {
        target: $('body'),
        locationFound: 'map:locationFound',
        locationNotFound: 'map:locationNotFound',
        searchError: 'map:searchError'
    };

    return {
        events: events,
        getMap: function() {
            return _map;
        },
        init: function() {
            _map = new google.maps.Map(document.getElementById(_mapId), {
                center: _center,
                zoom: 10
            });

            _placesService = new google.maps.places.PlacesService(_map);
        },
        search: function(query) {
            var request = {
                query: query,
                types: '(cities)'
            };
            _placesService.textSearch(request, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    if (results.length > 0) {
                        var place = results[0];
                        events.target.trigger(events.locationFound, place);
                        return;
                    }

                    events.target.trigger(events.locationNotFound, request);
                    return;
                }

                events.target.trigger(events.searchError, request);
            });
        }
    };
})();