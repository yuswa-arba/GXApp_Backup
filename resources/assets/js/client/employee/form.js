/**
 * Created by kevinpurwono on 11/11/17.
 */

import {api_path} from '../helpers/const'
import {get, post, multipartPost} from '../helpers/api'


$(document).ready(function () {

    // on init

    $('.datepicker').datepicker({format: 'dd/mm/yyyy', todayHighlight: true});

    $(function ($) {
        $(".datepicker").mask("99/99/9999");
    });


    // constants
    let employeeId = '';
    let personalInfoForm = $('#personalInformationForm');
    let employmentForm = $('#employmentForm');

    // on click events
    $('#createEmployeeBtn').on('click', function () {


        let formData = personalInfoForm.serialize();

        post(api_path() + 'employee/create', formData)
            .then((res) => {

                if (!res.data.isFailed && res.data.employeeId) {

                    employeeId = res.data.employeeId // insert employee ID

                    $('#errors-container').removeClass('show').addClass('hide')

                    /* Show success notification*/
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    if (employeeId) {// make sure employee ID is not empty
                        goToEmploymentTab()
                    } else {
                        alert('Something went wrong! Employee ID is not defined')
                    }

                } else {

                    /* Show error notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 0,
                        type: 'danger'
                    }).show();

                }

            })
            .catch((err) => {
                let errorsResponse = err.message + '</br>';

                _.forEach(err.response.data.errors, function (value, key) {
                    errorsResponse += value[0] + ' ';
                })

                $('#errors-container').removeClass('hide').addClass('show')
                $('#errors-value').html(errorsResponse)
                errorsResponse = '' // reset value
                /* Scroll to top*/
                $('html, body').animate({
                    scrollTop: $(".jumbotron").offset().top
                }, 500);

            })

    })


    $('#saveEmploymentBtn').on('click', function () {


        let formData = employmentForm.serialize();
        formData = formData + '&employeeId=' + employeeId; // add employeeId PARAM

        post(api_path() + 'employee/employment', formData)
            .then((res) => {
                if (!res.data.isFailed) {
                    $('#errors-container').removeClass('show').addClass('hide')

                    /* Show success notification*/
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'info'
                    }).show();

                    _.delay(function () {
                        window.location.href = '/employee/list'
                    }, 2500)

                } else {
                    /* Show error notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 0,
                        type: 'danger'
                    }).show();
                }

            })
            .catch((err) => {

                let errorsResponse = err.message + '</br>';

                _.forEach(err.response.data.errors, function (value, key) {
                    errorsResponse += value[0] + ' ';
                })

                $('#errors-container').removeClass('hide').addClass('show')
                $('#errors-value').html(errorsResponse)
                errorsResponse = '' // reset value
                /* Scroll to top*/
                $('html, body').animate({
                    scrollTop: $(".jumbotron").offset().top
                }, 500);

            })

    });

    $('#go-back-to-personal-tab').on('click', function () {
        // goToPersonalInfoTab()
    })

    // on change events
    $('#idCardPhoto').on('change', function () {
        console.log($(this).val())
    });

    // functions

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