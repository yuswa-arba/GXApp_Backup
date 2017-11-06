/**
 * Created by kevinpurwono on 4/11/17.
 */
(function ($) {

    'use strict';


    $('.card-linear').card({
        progress: 'bar',
        onRefresh: function () {
            setTimeout(function () {
                // Hides progress indicator
                $('.card-linear').card({
                    refresh: false
                });
            }, 2000);
        }
    });

    $('.card-filter').sieve({
        searchInput:$('#search-box'),
        itemSelector: ".filter-item"
    })


})(window.jQuery);