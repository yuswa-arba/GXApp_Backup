let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Theme plugins
 |--------------------------------------------------------------------------
 |
 | CSS & JS Theme plugins for Pages Admin Template - Simply White
 | Includes bootstrap, jquery, jquery-ui, etc.
 |
 */

mix.copy([
    'resources/assets/plugins/pace/pace-theme-flash.css',
    'resources/assets/plugins/bootstrap/css/bootstrap.min.css',
    'resources/assets/plugins/jquery-scrollbar/jquery.scrollbar.css',
    'resources/assets/plugins/select2-4.0.5/css/select2.min.css',
    'resources/assets/plugins/switchery/css/switchery.min.css',
    'resources/assets/plugins/bootstrap-datepicker/css/datepicker3.css',
    'resources/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css',

    ], 'public/plugins/css/')
    .copy([
        'resources/assets/plugins/pace/pace.min.js',
        'resources/assets/plugins/jquery/jquery-1.11.1.min.js',
        'resources/assets/plugins/bootstrap/js/bootstrap.min.js',
        'resources/assets/plugins/modernizr.custom.js',
        'resources/assets/plugins/jquery-ui/jquery-ui.min.js',
        'resources/assets/plugins/tether/js/tether.min.js',
        'resources/assets/plugins/jquery/jquery-easy.js',
        'resources/assets/plugins/jquery-unveil/jquery.unveil.min.js',
        'resources/assets/plugins/jquery-bez/jquery.bez.min.js',
        'resources/assets/plugins/jquery-ios-list/jquery.ioslist.min.js',
        'resources/assets/plugins/imagesloaded/imagesloaded.pkgd.min.js',
        'resources/assets/plugins/jquery-actual/jquery.actual.min.js',
        'resources/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js',
        'resources/assets/plugins/select2-4.0.5/js/select2.full.min.js',
        'resources/assets/plugins/classie/classie.js',
        'resources/assets/plugins/switchery/js/switchery.min.js',
        'resources/assets/plugins/jquery-autonumeric/autoNumeric.js',
        'resources/assets/plugins/dropzone/dropzone.min.js',
        'resources/assets/plugins/jquery-inputmask/jquery.inputmask.min.js',
        'resources/assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js',
        'resources/assets/plugins/jquery-validation/js/jquery.validate.min.js',
        'resources/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'resources/assets/plugins/summernote/js/summernote.min.js',
        'resources/assets/plugins/moment/moment.min.js',
        'resources/assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
        'resources/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js',
        'resources/assets/plugins/jquery.sieve.min.js',
        'resources/assets/plugins/google-palette/palette.js',
        'resources/assets/plugins/accounting.min.js',
    ], 'public/plugins/js/');


/*
 |--------------------------------------------------------------------------
 | Socket Io
 |--------------------------------------------------------------------------
 */
// mix.copyDirectory('node_modules/socket.io-client', 'public/plugins/socketioclient');
mix.copyDirectory('resources/assets/plugins/socketioclient', 'public/plugins/socketioclient');

/*
 |--------------------------------------------------------------------------
 | Font awesome
 |--------------------------------------------------------------------------
 | Font awesome
 */

mix.copyDirectory('resources/assets/plugins/font-awesome', 'public/plugins/font-awesome');

/*
 |--------------------------------------------------------------------------
 | Feather Icons
 |--------------------------------------------------------------------------
 | Feather Icons
 */

mix.copyDirectory('resources/assets/plugins/feather-icons', 'public/plugins/feather-icons');

/*
 |--------------------------------------------------------------------------
 | Dropzone
 |--------------------------------------------------------------------------
 | Drag n drop loader plugins
 */

mix.copyDirectory('resources/assets/plugins/dropzone', 'public/plugins/dropzone');

/*
 |--------------------------------------------------------------------------
 | Full Calendar
 |--------------------------------------------------------------------------
 | fullcalendar.io plugins
 */

mix.copyDirectory('resources/assets/plugins/fullcalendar', 'public/plugins/fullcalendar');



/*
 |--------------------------------------------------------------------------
 | Jquery Datatable & Datatable Responsive
 |--------------------------------------------------------------------------
 | Jquery Datatable & Datatable Responsive plugins
 */

mix.copyDirectory('resources/assets/plugins/jquery-datatable', 'public/plugins/jquery-datatable')
    .copyDirectory('resources/assets/plugins/datatables-responsive', 'public/plugins/datatables-responsive');

/*
 |--------------------------------------------------------------------------
 | Core theme
 |--------------------------------------------------------------------------
 |
 | CSS & JS Core scripts and style for Pages Admin Template
 |
 */

mix.js('resources/assets/core/js/pages.js', 'public/core/js/core-theme.js');
mix.styles('resources/assets/core/css/light.css', 'public/core/css/core-theme.css');

/*
 |--------------------------------------------------------------------------
 | Theme icons
 |--------------------------------------------------------------------------
 |
 | Theme icons
 |
 */

mix.copy('resources/assets/core/css/pages-icons.css', 'public/core/css/theme-icons.css');


/*
 |--------------------------------------------------------------------------
 | Theme images and fonts
 |--------------------------------------------------------------------------
 |
 | Theme images and fonts
 |
 */

mix.copyDirectory('resources/assets/core/img', 'public/core/img');
mix.copyDirectory('resources/assets/images/company', 'public/images/company');
mix.copyDirectory('resources/assets/core/fonts', 'public/core/fonts');



/*
 |--------------------------------------------------------------------------
 | Sounds
 |--------------------------------------------------------------------------
 |
 | Sounds
 |
 */
mix.copyDirectory('resources/assets/sounds', 'public/sounds');


/*
 |--------------------------------------------------------------------------
 | Client Compiled JS
 |--------------------------------------------------------------------------
 */

mix.js('resources/assets/js/client/employee/form','public/js/client/employee');
mix.js('resources/assets/js/client/employee/list','public/js/client/employee');
mix.js('resources/assets/js/client/employee/resignation','public/js/client/employee');
mix.js('resources/assets/js/client/employee/managers','public/js/client/employee');
mix.js('resources/assets/js/client/passport/main','public/js/client/passport');
mix.js('resources/assets/js/client/permission/main','public/js/client/permission');
mix.js('resources/assets/js/client/attendance/setting','public/js/client/attendance');
mix.js('resources/assets/js/client/attendance/slot','public/js/client/attendance');
mix.js('resources/assets/js/client/attendance/timesheet','public/js/client/attendance');
mix.js('resources/assets/js/client/attendance/schedule','public/js/client/attendance');
mix.js('resources/assets/js/client/attendance/leave','public/js/client/attendance');
mix.js('resources/assets/js/client/attendance/dashboard','public/js/client/attendance');
mix.js('resources/assets/js/client/doorAccess/main','public/js/client/doorAccess');
mix.js('resources/assets/js/client/developer/face','public/js/client/developer');
mix.js('resources/assets/js/client/developer/queueJob','public/js/client/developer');
mix.js('resources/assets/js/client/developer/test','public/js/client/developer');
mix.js('resources/assets/js/client/salary/report','public/js/client/salary');
mix.js('resources/assets/js/client/salary/employee','public/js/client/salary');
mix.js('resources/assets/js/client/salary/setting','public/js/client/salary');
mix.js('resources/assets/js/client/salary/payroll','public/js/client/salary');
mix.js('resources/assets/js/client/salary/queue','public/js/client/salary');
mix.js('resources/assets/js/client/misc/notification','public/js/client/misc');
mix.js('resources/assets/js/client/components/InternetConnection.js','public/js/client/components');
mix.js('resources/assets/js/client/profile/user','public/js/client/profile');
mix.js('resources/assets/js/client/profile/notification','public/js/client/profile');
mix.js('resources/assets/js/client/setting/notification','public/js/client/setting');
mix.js('resources/assets/js/client/notification/main','public/js/client/notification');
mix.js('resources/assets/js/client/storage/misc/items','public/js/client/storage/misc');
mix.js('resources/assets/js/client/storage/misc/itemCategories','public/js/client/storage/misc');
mix.js('resources/assets/js/client/storage/misc/itemTypes','public/js/client/storage/misc');
mix.js('resources/assets/js/client/storage/misc/shipments','public/js/client/storage/misc');
mix.js('resources/assets/js/client/storage/misc/suppliers','public/js/client/storage/misc');
mix.js('resources/assets/js/client/storage/misc/warehouses','public/js/client/storage/misc');
mix.js('resources/assets/js/client/storage/misc/units','public/js/client/storage/misc');
mix.js('resources/assets/js/client/storage/requisition/shop','public/js/client/storage/requisition');
mix.js('resources/assets/js/client/storage/requisition/cart','public/js/client/storage/requisition');
mix.js('resources/assets/js/client/storage/requisition/history','public/js/client/storage/requisition');
mix.js('resources/assets/js/client/storage/admin/approval','public/js/client/storage/admin');
mix.js('resources/assets/js/client/storage/admin/purchaseOrder','public/js/client/storage/admin');
mix.js('resources/assets/js/client/manager/editTimesheet','public/js/client/manager');



/*
 |--------------------------------------------------------------------------
 | Application JS
 |--------------------------------------------------------------------------
 */
mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.version();