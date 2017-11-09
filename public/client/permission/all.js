/**
 * Created by kevinpurwono on 7/11/17.
 */
const backend_route = '/v1/setting/';
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


/**
 * Created by kevinpurwono on 7/11/17.
 */



let paramPermissionId = '';
let paramPermissionName = '';

(function ($) {

    'use strict';
    ;

    $('.btn-vd-permission').on('click', function () {

        let permissionName = $(this).val();

        let headerContainer = $('#mh-permission');
        let headerContent = "";

        let container = $('#mb-permission-detail');
        let content = "";

        let footerContainer = $('#mf-permission');
        let footerContent = "";

        $.ajax({
            url: backend_route + 'permission/assigned/' + permissionName,
            type: 'GET',
            success: function (data) {
                let obj = data.data;
                let assignedRolesArr = obj.assignedRoles.data;
                let allRolesArr = obj.allRoles.data;

                /* Assign permission id & name for ajax request*/
                paramPermissionId = obj.id;
                paramPermissionName = obj.name;

                let rolesContent = '';
                _.forEach(allRolesArr, function (value, key) {
                    rolesContent +=
                        `<div class="col-lg-3 col-md-3 col-sm-3 sm-m-t-10">
                                <div class="checkbox check-danger checkbox-circle">
                                    <input type="checkbox" class="cbAssignRole" name="assignRoleId[]" value="` + value.id + `" id="cbrole` + value.id + `">
                                    <label for="cbrole` + value.id + `">` + value.name + `</label>
                                </div>
                         </div>`;
                });

                headerContent = `<h5 class="text-left dark-title p-b-5">#` + obj.id + ` ` + _.upperCase(obj.name) + `</h5>`;
                content = `
                   <div class="row">
                        <div class="col-lg-12">
                            <h4 class="text-left p-b-5"><span class="label label-success">Given to
                                    users:</span></h4>
                        </div>
                        <div class="col-lg-12"></div>
                          <div class="col-lg-3 sm-m-t-10">
                              <div class="checkbox check-primary checkbox-circle">
                                  <input type="checkbox" checked="checked" value="1" id="checkbox9">
                                  <label for="checkbox9">Mark</label>
                              </div>
                          </div>
                        <div class="col-lg-12">
                            <h4 class="text-left p-b-5"><span class="label label-important">Given to
                                    roles:</span></h4>
                        </div>
                        <div class="col-lg-12"> </div>
                         ` + rolesContent + `
                        <div class="col-lg-12 m-b-15"></div>
                        
                   </div>`;

                footerContent = `<button class="p-t-5 p-b-5 btn text-primary bold all-caps btn-block" onclick="saveAssignByPermission()">Save</button>`;

                headerContainer.html(headerContent); // insert header content;
                container.html(content); // insert content
                footerContainer.html(footerContent); // insert footer content;

                _.forEach(assignedRolesArr, function (value, key) { // check assigned roles
                    $('#cbrole' + value.id).prop('checked', true);
                });


                $('#modal-permission-detail').modal("show"); // show modal
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 500) {
                    console.log('Internal error: ' + jqXHR.responseText);
                } else {
                    console.log('Unexpected error.');
                }
            }
        });


    });


})(window.jQuery);

function saveAssignByPermission() {

    let assignRoleArr = [];
    let assignUserArr = [];

    /*assign role*/
    _.forEach($('.cbAssignRole:checkbox:checked'), function (value, key) {
        assignRoleArr.push(value['value']);
    });

    /* TODO : create array for assign users*/

    /* Data param */
    let data = {permissionName: paramPermissionName, assignRoleArr: assignRoleArr, assignUserArr: assignUserArr};

    $.ajax({
        url: backend_route + 'permission/assign/by_permission',
        type: 'POST',
        data: data,
        success: function (data) {

            $('#modal-permission-detail').modal("toggle"); // close modal

            $('.page-container').pgNotification({
                style: 'flip',
                message: data.message,
                position: 'top-right',
                timeout: 3500,
                type: 'info'
            }).show();

            /* TODO : update view*/
        }
    });


}
/**
 * Created by kevinpurwono on 7/11/17.
 */

let paramRoleId = '';
let paramRoleName = '';

(function ($) {

    'use strict';


    $('.btn-vd-role').on('click', function () {

        let roleName = $(this).val();

        let headerContainer = $('#mh-role');
        let headerContent = "";

        let container = $('#mb-role-detail');
        let content = "";

        let footerContainer = $('#mf-role');
        let footerContent = "";



        $.ajax({
            url: backend_route + 'role/assigned/' + roleName,
            type: 'GET',
            success: function (data) {
                let obj = data.data;
                let assignedPermissionArr = obj.assignedPermission.data;
                let allPermissionArr = obj.allPermission.data;

                /* Assign role id & name for ajax request*/
                paramRoleId = obj.id;
                paramRoleName = obj.name;

                let permissionContent = '';
                _.forEach(allPermissionArr, function (value, key) {
                    permissionContent +=
                        `<div class="col-lg-3 col-md-3 col-sm-3 sm-m-t-10">
                                <div class="checkbox check-danger checkbox-circle">
                                    <input type="checkbox" class="cbAssignPermission" name="assignPermissionId[]" value="` + value.id + `" id="cbpermission` + value.id + `">
                                    <label for="cbpermission` + value.id + `">` + value.name + `</label>
                                </div>
                         </div>`;
                });

                headerContent = `
                        <h5 class="text-left dark-title p-b-5">#` + obj.id + ` ` + _.upperCase(obj.name) + `</h5>
                        <h4 class="text-left p-b-5"><span class="label label-success">Has permission to:</span></h4>
                        `;

                content = `                    
                    <div class="row">
                        <div class="col-lg-12"></div>
                        ` + permissionContent + `
                        <div class="col-lg-12 m-b-15"></div>
                    </div>`;

                footerContent = `<button class="p-t-5 p-b-5 btn text-primary bold all-caps btn-block" onclick="saveAssignByRole()">Save</button>`;

                headerContainer.html(headerContent); // insert header content
                container.html(content); // insert content
                footerContainer.html(footerContent); // insert footer content

                _.forEach(assignedPermissionArr, function (value, key) { // check assigned permission
                    $('#cbpermission' + value.id).prop('checked', true);
                });
                $('#modal-role-detail').modal("show");
            }

        });


    });


})(window.jQuery);

function saveAssignByRole() {

    let assignPermissionArr = [];

    let cbPermissions = $('.cbAssignPermission:checkbox:checked');

    _.forEach(cbPermissions, function (value, key) {
        assignPermissionArr.push(value['value']);
    });

    /* Data param */
    let data = {roleName: paramRoleName, assignPermissionArr: assignPermissionArr};

    $.ajax({
        url: backend_route + 'role/assign/by_role',
        type: 'POST',
        data: data,
        success: function (data) {

            $('#modal-role-detail').modal("toggle"); // close modal

            $('.page-container').pgNotification({
                style: 'flip',
                message: data.message,
                position: 'top-right',
                timeout: 3500,
                type: 'info'
            }).show();
        }
    });


}