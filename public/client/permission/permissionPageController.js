/**
 * Created by kevinpurwono on 4/11/17.
 */
(function ($) {

    'use strict';


    $('.card').card({
        progress: 'bar',
        onRefresh: function () {
            setTimeout(function () {
                // Hides progress indicator
                $('.card').card({
                    refresh: false
                });
            }, 2000);
        }
    });

    $('.card-filter').sieve({
        searchInput:$('#search-box'),
        itemSelector: ".filter-item"
    });


    //
    // $('#btnNewRole').on('click',function () {
    //     $('#modalSlideUp').modal("show");
    // });




})(window.jQuery);