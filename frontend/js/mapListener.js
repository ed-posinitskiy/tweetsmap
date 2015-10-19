var mapListener = (function () {
    var markers = [];

    var defaults = {
        noAvatarImg: '/img/noavatar.png'
    };

    var endpoints = {
        track: '/tweets/track',
        tweets: '/tweets/search'
    };

    var createMarkerWithTimeout = function (tweet, timeout) {
        var tweetLocation = {},
            image, label;

        tweetLocation.lat = tweet.lat;
        tweetLocation.lng = tweet.lon;

        image = (typeof tweet.avatar === 'undefined' || tweet.avatar.length === 0) ? defaults.noAvatarImg : tweet.avatar;

        label = tweet.text + '<br>' + tweet.date;

        setTimeout(function () {
            markers.push(map.createMarker(tweetLocation, image, label));
        }, timeout);
    };

    var clearMarkers = function() {
        var idx;

        if (markers.length === 0) {
            return;
        }

        for (idx in markers) {
            var marker = markers[idx];
            marker.setMap(null);
        }

        markers = [];
    };

    var _moveToRequestedPlace = function (location) {
        map.getMap().panTo(location);
        clearMarkers();
    };

    var _requestTweets = function (location) {
        $.post(endpoints.tweets, {lat: location.lat(), lon: location.lng()}, function (response) {
            var idx,
                latency = 200;

            if (response.tweets.length === 0) {
                return;
            }

            for (idx in response.tweets) {
                var tweet = response.tweets[idx];
                createMarkerWithTimeout(tweet, latency * idx);
            }
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