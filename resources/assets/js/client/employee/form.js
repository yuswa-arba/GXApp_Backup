/**
 * Created by kevinpurwono on 11/11/17.
 */

import {api_path} from '../helpers/const'
import {get, post, multipartPost} from '../helpers/api'
import {objectToFormData} from '../helpers/utils'

$(document).ready(function () {

    // constants
    let employeeId = '';
    let personalInfoForm = $('#personalInformationForm');
    let medicalRecordsForm = $('#medicalRecordsForm');
    let employmentForm = $('#employmentForm');
    let formObject = {};

    //buttons
    let createEmployeeBtn =  $('#createEmployeeBtn');
    let saveMedicalRecordsBtn = $('#saveMedicalRecordsBtn');
    let saveEmploymentBtn = $('#saveEmploymentBtn');

    // on click events
    createEmployeeBtn.on('click', function () {

        let serializeForm = personalInfoForm.serializeArray();

        _.forEach(serializeForm, function (value, key) {

            /* Previous length of employment value fix */
            if (value.name == 'prevLengthEmployment' && value.value != '') {
                value.value = value.value + ' ' + $('input[name="lengthEmploymentTimeFormat"]:checked').val()
            }

            formObject[value.name] = value.value
        })

        //Disable button and change text
        createEmployeeBtn.html('Submitting...')
        createEmployeeBtn.prop('disabled',true)

        post(api_path + 'employee/create', objectToFormData(formObject))
            .then((res) => {

                //Enable button and change text
                createEmployeeBtn.html('Create Employee')
                createEmployeeBtn.prop('disabled',false)

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
                        goToMedicalRecordsTab()
                    } else {
                        alert('Something went wrong! Employee ID is not defined')
                    }

                } else {

                    if(res.data.message){
                        /* Show error notification */
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 0,
                            type: 'danger'
                        }).show();
                    } else {
                        /* Show error notification */
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: 'Invalid response from server',
                            position: 'top-right',
                            timeout: 0,
                            type: 'danger'
                        }).show();
                    }



                }

            })
            .catch((err) => {

                //Enable button and change text
                createEmployeeBtn.html('Create Employee')
                createEmployeeBtn.prop('disabled',false)

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


    saveMedicalRecordsBtn.on('click', function () {

        let formData = medicalRecordsForm.serialize()
        formData = formData + '&employeeId=' + employeeId // add employeeId PARAM

        //Disable button and change text
        saveMedicalRecordsBtn.html('Submitting...')
        saveMedicalRecordsBtn.prop('disabled',true)

        post(api_path + 'employee/medicalRecords', formData)
            .then((res) => {

                //Enable button and change text
                saveMedicalRecordsBtn.html('Save Employee Medical Records')
                saveMedicalRecordsBtn.prop('disabled',false)

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

                //Enable button and change text
                saveMedicalRecordsBtn.html('Save Employee Medical Records')
                saveMedicalRecordsBtn.prop('disabled',false)

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

    saveEmploymentBtn.on('click', function () {


        let formData = employmentForm.serialize();
        formData = formData + '&employeeId=' + employeeId; // add employeeId PARAM

        //Disable button and change text
        saveEmploymentBtn.html('Submitting...')
        saveEmploymentBtn.prop('disabled',true)

        post(api_path + 'employee/employment', formData)
            .then((res) => {

                //Enable button and change text
                saveEmploymentBtn.html('Save Employment & Send Verification Email')
                saveEmploymentBtn.prop('disabled',false)

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

                    window.location.href = '/employee/list' // go to list page when FINISH

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

                //Enable button and change text
                saveEmploymentBtn.html('Save Employment & Send Verification Email')
                saveEmploymentBtn.prop('disabled',false)

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
    $('#idCardPhoto').on('change', function (e) {
        //insert file image data to object
        formObject.idCardPhoto = e.target.files[0]
    });

    $('#employeePhoto').on('change', function (e) {
        //insert file image data to object
        formObject.employeePhoto = e.target.files[0]
    });


    /* Medical Record Tab */

    $('.datepickerGet').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('[name="hasLongTermMedication"]').click(function () {
        let treatmentLong = $(this).val();

        let outDis = '';

        if (treatmentLong == false) {
            outDis = 'none';
        }

        $('#treatmentQuestion').css({'display': outDis});
    });

    $('[name="isASmoker"]').click(function () {
        let smokerVal = $(this).val();
        let outDisSmoker = '';

        if (smokerVal == false) {
            outDisSmoker = 'none';
        }

        $('#smokerQuestion').css({'display': outDisSmoker});
    });

    $('[name="isADrinker"]').click(function () {
        let drinkerVal = $(this).val();

        let outDisDrinker = '';

        if (drinkerVal == false) {
            outDisDrinker = 'none';
        }

        $('#drinkerQuestion').css({'display': outDisDrinker});
    });

    $('[name="hadAnAccident"]').click(function () {
        let accidentVal = $(this).val();

        let outDisAccident = '';

        if (accidentVal == false) {
            outDisAccident = 'none';
        }

        $('#accidentQuestion').css({'display': outDisAccident});
    });

    $('[name="hadASurgery"]').click(function () {

        let operationVal = $(this).val();

        let outDisOperation = '';

        if (operationVal == false) {
            outDisOperation = 'none';
        }

        $('#operationQuestion').css({'display': outDisOperation});
    });

    $('[name="hasHospitalized"]').click(function () {
        let hospitalizedVal = $(this).val();

        let outDisHospitaled = '';

        if (hospitalizedVal == false) {
            outDisHospitaled = 'none';
        }

        $('#hospitalizedQuestion').css({'display': outDisHospitaled});
    });

    $('[name="wearGlasses"]').click(function () {

        let glassesVal = $(this).val();

        let outDisGlasses = '';

        if (glassesVal == false) {
            outDisGlasses = 'none'
        }

        $('#glassesQuestion').css({'display': outDisGlasses});
    });


    /* End of Mesical Record Tab */


    /* Marital, Father & Mother form*/

    $('[name="fatherIsDeceased"]').change(function(){
        if($(this).val()==1){
            /* Disable forms */
            $('#father-form').addClass('disabled-form')
            $("#father-form :input").attr("disabled", true);

        } else{
            /* Enable forms */
            $("#father-form :input").attr("disabled", false);
            $('#father-form').removeClass('disabled-form')
        }
    })

    $('[name="motherIsDeceased"]').change(function(){
        if($(this).val()==1){
            /* Disable forms */
            $('#mother-form').addClass('disabled-form')
            $("#mother-form :input").attr("disabled", true);

        } else{
            /* Enable forms */
            $("#mother-form :input").attr("disabled", false);
            $('#mother-form').removeClass('disabled-form')
        }
    })

    $('[name="maritalStatusId"]').change(function(){
        if($(this).val()==5){ // Unmarried
            /* Disable forms */
            $('#spouse-form').addClass('disabled-form')
            $("#spouse-form :input").attr("disabled", true);
        } else{
            /* Enable forms */
            $("#spouse-form :input").attr("disabled", false);
            $('#spouse-form').removeClass('disabled-form')
        }
    })

    /* End of father & mother form*/


    /* Siblings form */

    $('[name="numberOfSiblings"]').keyup(function () {


        if ($(this).val() > 0) {
            if ($(this).val() <= 10){
                addSiblingsForm($(this).val())
            }
        } else {
            removeSiblingsForm()
        }
    })

    /* End of siblings form */


    // functions

    function goToMedicalRecordsTab() {
        clearActiveTab()
        $('#item-medical-records').addClass('active')
        $('#tab-medical-records').addClass('active')
    }

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


    function addSiblingsForm(total) {

        removeSiblingsForm();//reset

        let i = 0
        for (i; i < total; i++) {

            let originalForm = `<div class="hide" id="siblingsForm`+i+`">
                                                <br>
                                                <div class="form-group form-group-default">
                                                    <label>Sibling's Name</label>
                                                    <input type="text" class="form-control" name="siblingName[`+i+`]" value="">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Sibling's Address</label>
                                                    <input type="text" class="form-control" name="siblingAddress[`+i+`]"
                                                           value="">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Sibling's City</label>
                                                    <input type="text" class="form-control" name="siblingCity[`+i+`]"
                                                           value="">
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Sibling's Phone Number</label>
                                                    <input type="number" min="0" class="form-control" name="siblingPhoneNo[`+i+`]"
                                                           value="">
                                                </div>
                                                <br>
                                            </div>`

            $('#siblingsFormContainer').prepend(originalForm)

            $('#siblingsForm' + i).removeClass('hide')
        }
    }

    function removeSiblingsForm() {
        $('#siblingsFormContainer').empty()

    }
});
