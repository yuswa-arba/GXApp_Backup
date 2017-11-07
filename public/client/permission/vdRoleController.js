/**
 * Created by kevinpurwono on 7/11/17.
 */

let paramRoleId = '';
let paramRoleName = '';

(function ($) {

    'use strict';


    $('.btn-vd-role').on('click', function () {

        let roleName = $(this).val();
        let container = $('#mb-role-detail');
        let content = "";


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

                content = `                    
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="text-left dark-title p-b-5">#` + obj.id + ` ` + obj.name + `</h5>
                        </div>
                        <div class="col-lg-12">
                            <h4 class="text-left p-b-5"><span class="label label-success">Has permission to:</span></h4>
                        </div>
                        <div class="col-lg-12"></div>
                        ` + permissionContent + `
                        <div class="col-lg-12 m-b-15"></div>
                        <div class="col-lg-3 offset-lg-9">
                            <button class="p-t-5 p-b-5 btn text-primary bold all-caps btn-block" onclick="saveAssignByRole()">Save</button>
                        </div>
                    </div>`;

                container.html(content); // insert content

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