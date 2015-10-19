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
        },
    };
})();