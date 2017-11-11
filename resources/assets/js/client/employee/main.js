/**
 * Created by kevinpurwono on 11/11/17.
 */
$(document).ready(function () {

    $('.datepicker').datepicker({format: 'dd/mm/yyyy'});

    $(function ($) {
        $("#birth-date").mask("99/99/9999");
    });

    let personalInfoForm = $('#personalInformationForm');


    $('#createEmployeeBtn').on('click', function () {
        let formData = personalInfoForm.serialize();
        /* TODO CREATE VALIDATION FROM CONTROLLER AND SEND WITH AXIOS*/

    })

    $('#go-back-to-personal-tab').on('click', function () {
        goToPersonalInfoTab()
    })

    function goToEmploymentTab() {
        clearActiveTab()
        $('#item-employment').addClass('active')
        $('#tab-employment').addClass('active')
    }

    function goToPersonalInfoTab() {
        clearActiveTab()
        $('#item-personal-info').addClass('active')
        $('#tab-personal-info').addClass('active')
    }

    function clearActiveTab() {
        $('.tab-pane').removeClass('active')
        $('.nav-item a').removeClass('active')
    }

});
