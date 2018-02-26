@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->

@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->

@endpush

@push('child-page-controller')
<script>
    $(document).ready(function () {

        // capture the Create new backup button
        $("#create-new-backup-button").click(function (e) {
            if (confirm("{{ trans('Are you sure want to create a new backup?') }}") == true) {
                let create_backup_url = $(this).attr('href'); // get url from button action
                $.ajax({
                    url: create_backup_url,
                    beforeSend: function () {
                        console.log('beforeSend')
                        reloading(60);
                    },
                    type: 'get',
                    success: function (result) {
                        if (result.indexOf('failed') >= 0) {
                            notifyAlert('Something Wrong!', 'warning');
                        }
                        else {
                            notifyAlert('Successfully Create!', 'success');
                            // refresh the page to show the new file
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function (result) {
                        notifyAlert('Process Error!', 'error');
                    }
                });
            }
        });

        // capture the delete button
        $("[data-button-type=delete]").click(function (e) {
            e.preventDefault();
            let delete_button = $(this);
            let delete_url = $(this).attr('href');

            if (confirm("{{ trans('are you sure, want to delete?') }}") == true) {
                $.ajax({
                    url: delete_url,
                    type: 'get',
                    beforeSend: function () {
                        console.log('beforeSend')
                        reloading(1000);
                    },
                    success: function (result) {
                        notifyAlert('Delete Process is Complete!', 'success'); // Show an alert with the result

                        delete_button.parentsUntil('tr').parent().remove(); // delete the row from the table
                    },
                    error: function (result) {
                        notifyAlert('Delete Process is Error!', 'error');
                    }
                });
            } else {
                notifyAlert('Delete Process is Canceled!', 'warning');
            }
        });

        // notify delete
        function notifyAlert(mes, type) {
            $('body').pgNotification({
                style: 'flip',
                message: mes,
                position: 'top-right',
                timeout: 3000,
                type: type
            }).show();
        }

        // style reloading
        function reloading(time) {
            $('.cardListBackup').card({
                progress: 'circle',
                refresh: true,
                progressColor: 'success',
                onRefresh: function () {

                    setTimeout(function () {
                        // Hides progress indicator
                        $('.cardListBackup').card({
                            refresh: false
                        });
                    }, time);
                }
            });
        }

    });
</script>
@endpush

@section('content')

    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Developer</a></li>
                        <li class="breadcrumb-item active">Backup</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->

        <div class="container full-width container-fluid container-fixed-lg">
            <div class="row">
                <div class="col-md-12 m-b-10">
                    <button id="create-new-backup-button"
                            href="{{ url('/v1/h/developer/backup/create') }}"
                            class="btn btn-primary" data-style="zoom-in">
                        <span class=""><i class="fa fa-plus"></i> Create New Backup</span>
                    </button>
                </div>

                <div class="col-md-12 bg-white">
                    <div class="card card-transparent cardListBackup">
                        <div class="card-block">
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th style="width:10px;">#</th>
                                    <th style="width:250px;">Filename</th>
                                    <th>{{ trans('location') }}</th>
                                    <th>{{ trans('date') }}</th>
                                    <th class="text-right">{{ trans('file size') }}</th>
                                    <th class="text-right">{{ trans('actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($backups as $k=> $b)
                                    <tr>
                                        <td scope="row"><b>{{ count($backups)-$k }}</b></td>
                                        <td>{{ substr($b['file_name'],17) }}</td>
                                        <td>{{ $b['disk'] }}</td>
                                        <td>{{ \Carbon\Carbon::createFromTimeStamp($b['last_modified'])->formatLocalized('%d %B %Y, %H:%M') }}</td>
                                        <td class="text-right">{{ round((int)$b['file_size']/1048576, 2).' MB' }}</td>
                                        <td class="text-right">
                                            @if ($b['download'])
                                                <a class="btn btn-xs btn-default"
                                                   href="{{ url('/v1/h/developer/backup/download/') }}?disk={{ $b['disk'] }}&path={{ urlencode($b['file_path']) }}&file_name={{ urlencode($b['file_name']) }}"><i
                                                            class="fa fa-cloud-download"></i> {{ trans('Download') }}
                                                </a>
                                            @endif
                                            <a class="btn btn-xs btn-danger" data-button-type="delete"
                                               href="{{ url('/v1/h/developer/backup/delete/'.$b['file_name']) }}?disk={{ $b['disk'] }}"><i
                                                        class="fa fa-trash-o"></i> {{ trans('Delete') }}</a>
                                        </td>
                                    </tr>
                                @endforeach()
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT -->

@endsection