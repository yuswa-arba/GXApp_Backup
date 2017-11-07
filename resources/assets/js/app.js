/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

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
    $('[data-pages="search"]').search({
        searchField: '#overlay-search',
        closeButton: '.overlay-close',
        suggestions: '#overlay-suggestions',
        brand: '.brand',
        onSearchSubmit: function (searchString) {
            console.log("Search for: " + searchString);
        },
        onKeyEnter: function (searchString) {
            console.log("Live search for: " + searchString);
            var searchField = $('#overlay-search');
            var searchResults = $('.search-results');
            clearTimeout($.data(this, 'timer'));
            searchResults.fadeOut("fast");
            var wait = setTimeout(function () {
                searchResults.find('.result-name').each(function () {
                    if (searchField.val().length != 0) {
                        $(this).html(searchField.val());
                        searchResults.fadeIn("fast");
                    }
                });
            }, 500);
            $(this).data('timer', wait);
        }
    });

    //https://github.com/colebemis/feather
    //Feather ICONS
    //Used in sidebar icons

    feather.replace({
        'width': 16,
        'height': 16
    });
})