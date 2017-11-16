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
    'resources/assets/plugins/select2/css/select2.min.css',
    'resources/assets/plugins/switchery/css/switchery.min.css',
    'resources/assets/plugins/bootstrap-datepicker/css/datepicker3.css',
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
        'resources/assets/plugins/select2/js/select2.full.min.js',
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
    ], 'public/plugins/js/');

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
mix.copyDirectory('resources/assets/core/fonts', 'public/core/fonts');


/*
 |--------------------------------------------------------------------------
 | Client Compiled JS
 |--------------------------------------------------------------------------
 */

mix.js('resources/assets/js/client/employee/form','public/js/client/employee');
mix.js('resources/assets/js/client/employee/list','public/js/client/employee');
mix.js('resources/assets/js/client/passport/main','public/js/client/passport');
mix.js('resources/assets/js/client/permission/main','public/js/client/permission');
mix.js('resources/assets/js/client/testing/main','public/js/client/testing');

/*
 |--------------------------------------------------------------------------
 | Application JS
 |--------------------------------------------------------------------------
 */

mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');



mix.version();