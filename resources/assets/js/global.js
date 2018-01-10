/**
 * Created by kevinpurwono on 10/11/17.
 */
$(document).ready(function () {

    /* AJAX SETUP FOR ALL AJAX REQUEST */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        error: function (xhr) {
            // alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
            let xhrResponse = JSON.parse(xhr.responseText);
            let errorMsg = 'Request Status: ' + xhr.status + ' Error: ' + xhrResponse.message + ' Exception: ' + xhrResponse.exception;

            $('.page-container').pgNotification({
                style: 'bar',
                message: errorMsg,
                position: 'top',
                timeout: 0,
                type: 'error'
            }).show();
        }
    });

    // Initializes search overlay plugin.
    // Replace onSearchSubmit() and onKeyEnter() with
    // your logic to perform a search and display results
    // $('[data-pages="search"]').search({
    //     searchField: '#overlay-search',
    //     closeButton: '.overlay-close',
    //     suggestions: '#overlay-suggestions',
    //     brand: '.brand',
    //     onSearchSubmit: function (searchString) {
    //         console.log("Search for: " + searchString);
    //     },
    //     onKeyEnter: function (searchString) {
    //         console.log("Live search for: " + searchString);
    //         var searchField = $('#overlay-search');
    //         var searchResults = $('.search-results');
    //         clearTimeout($.data(this, 'timer'));
    //         searchResults.fadeOut("fast");
    //         var wait = setTimeout(function () {
    //             searchResults.find('.result-name').each(function () {
    //                 if (searchField.val().length != 0) {
    //                     $(this).html(searchField.val());
    //                     searchResults.fadeIn("fast");
    //                 }
    //             });
    //         }, 500);
    //         $(this).data('timer', wait);
    //     }
    // });

    // Feather Icons
    feather.replace({
        'width': 16,
        'height': 16
    });

    // Sieve Search
    $('.filter-container').sieve({
        searchInput: $('#search-box'),
        itemSelector: ".filter-item"
    });

    // Cards
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

    //Date picker
    // on init
    $('.datepicker').datepicker({format: 'dd/mm/yyyy', todayHighlight: true});

    $(function ($) {
        $(".datepicker").mask("99/99/9999");
    });

    $(function ($) {
        $(".time-mask").mask("99:99");
    });

    //Tooltip
    $('[data-toggle="tooltip"]').tooltip();


});