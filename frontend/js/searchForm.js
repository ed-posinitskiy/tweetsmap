var formInitializer = (function () {
    var $form = $("#search_form"),
        $input = $form.find('#search_query');

    var _searchCallback = function (e) {
        e.preventDefault();
        map.events.target.one(map.events.locationFound, mapListener.onFound);
        map.search($input.val());
    };

    var _queryTracker = function () {
        if ($input.val()) {
            $form.trigger('submit');
        }
    };

    return {
        init: function () {
            $form.on('submit', _searchCallback);
            _queryTracker();
        }
    };
})();

var mapListener = (function () {
    var endpoints = {
        track: '/tweets/track',
        tweets: '/tweets/search'
    };

    var _moveToRequestedPlace = function (location) {
        map.getMap().panTo(location)
    };

    var _requestTweets = function (location) {
        $.post(endpoints.tweets, {lat: location.lat(), lon: location.lng()}, function (response) {
            console.log(response);
        })
    };

    var _trackRequest = function (place) {
        $.post(endpoints.track, {q: place.name}, function (data) {
            return;
        });
    };

    return {
        onFound: function (e, place) {
            _moveToRequestedPlace(place.geometry.location);
            _requestTweets(place.geometry.location);
            _trackRequest(place);
        }
    };
})();