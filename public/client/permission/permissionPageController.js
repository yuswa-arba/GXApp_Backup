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
        searchInput: $('#search-box'),
        itemSelector: ".filter-item"
    });


    $('#btn-new-role').on('click', function () {
        $('#modal-new-role').modal("show");
    });

    $('#btn-new-permission').on('click', function () {
        $('#modal-new-permission').modal("show");
    });



    $('.btn-vd-user').on('click', function () {
        $('#modal-permission-detail').modal("show");
    });


})(window.jQuery);