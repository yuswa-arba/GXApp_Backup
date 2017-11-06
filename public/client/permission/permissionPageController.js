/**
 * Created by kevinpurwono on 4/11/17.
 */
(function ($) {

    'use strict';

    const backend_route = '/bv1/setting/';

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

    $('.btn-vd-permission').on('click', function () {

        let permissionName = $(this).val();
        let container = $('#mb-permission-detail');
        let content = "";

        $.ajaxSetup({
            error: function (xhr) {
                alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
            }
        });

        $.ajax({
            url: backend_route + 'permission/assigned/' + permissionName,
            type: 'GET',
            success: function (data) {
                let obj = data.data;
                let assignedRolesObj = obj.assignedRoles.data;

                let rolesContent = '';
                $.each(assignedRolesObj, function (key, value) {
                    rolesContent +=
                        `<div class="col-lg-3 sm-m-t-10">
                                <div class="checkbox check-danger checkbox-circle">
                                    <input type="checkbox" checked="checked" value="" id="cbrole` + value.id + `">
                                    <label for="cbrole` + value.id + `">` + value.name + `</label>
                                </div>
                         </div>`;
                });

                content = `
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="text-left p-b-5">#` + obj.id + ` ` + obj.name + `</h5>
                        </div>
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
                    </div>`;

                container.html(content); // insert content
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

    $('.btn-vd-role').on('click', function () {
        $('#modal-permission-detail').modal("show");
    });

    $('.btn-vd-user').on('click', function () {
        $('#modal-permission-detail').modal("show");
    });


})(window.jQuery);