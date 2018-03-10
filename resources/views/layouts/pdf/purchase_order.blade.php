<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purchase Order</title>
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            border-color: #ccc;
            width: 100%;
        }

        .tg td {
            font-family: Arial;
            font-size: 12px;
            padding: 10px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: #ccc;
            color: #333;
            background-color: #fff;
        }

        .tg th {
            font-family: Arial;
            font-size: 14px;
            font-weight: normal;
            padding: 10px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: #ccc;
            color: #333;
            background-color: #f0f0f0;
        }

        .tg .tg-3wr7 {
            font-weight: bold;
            font-size: 12px;
            font-family: "Arial", Helvetica, sans-serif !important;;
            text-align: center
        }

        .tg .tg-ti5e {
            font-size: 10px;
            font-family: "Arial", Helvetica, sans-serif !important;;
            text-align: center
        }

        .tg .tg-rv4w {
            font-size: 10px;
            font-family: "Arial", Helvetica, sans-serif !important;
        }

        .table-header {
            color: #FFF;
            font-size: 14px;
            line-height: 38px;
            padding-left: 12px;
            margin-bottom: 1px;
        }

        .modal-content {
            position: relative;
            background-color: #fff;
        }

        .no-padding {
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
        }

        .row {
            margin-left: -12px;
            margin-right: -12px;
        }

        .col-sm-offset-1 {
            margin-left: 7.333%;
        }

        .col-sm-10 {
            width: 82.333%;
        }

        .widget-box.transparent {
            border-top-width: 0px;
            border-right-width: 0px;
            border-bottom-width: 0px;
            border-left-width: 0px;
        }

        .widget-box.transparent > .widget-header-large {
            padding-left: 5px;
        }

        .widget-box.transparent > .widget-header {
            background-image: initial;
            background-position-x: 0px;
            background-position-y: 0px;
            background-size: initial;
            background-repeat-x: initial;
            background-repeat-y: initial;
            background-attachment: initial;
            background-origin: initial;
            background-clip: initial;
            background-color: initial;
            border-top-width: 0px;
            border-right-width: 0px;
            border-bottom-width: 1px;
            border-left-width: 0px;
            border-bottom: 1px solid #DCE8F1;
            border-bottom-width: 1px;
            border-bottom-style: solid;
            border-bottom-color: rgb(220, 232, 241);
            color: #4383B4;
        }

        .widget-header {
            box-sizing: content-box;
            position: relative;
        }

        .widget-header-large {
            min-height: 49px;
            padding-left: 18px;
        }

        .widget-header-large > .widget-title {
            line-height: 48px;
        }

        .widget-header > .widget-title {
            line-height: 36px;
            padding: 0;
            margin: 0;
            display: inline;
        }

        .grey {
            color: #777
        }

        .lighter {
            font-weight: lighter;
        }

        h3 {
            font-size: 22px;
        }

        .widget-header > .widget-title > .ace-icon {
            margin-right: 5px;
            font-weight: 400;
            display: inline-block;
        }

        .green {
            color: #69AA46
        }

        .ace-icon {
            text-align: center;
        }

        .fa {
            font-style: normal;
            font-variant-ligatures: normal;
            font-variant-caps: normal;
            font-variant-numeric: normal;
            font-weight: normal;
            font-stretch: normal;
            font-size: inherit;
            line-height: 1;
            font-family: FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .fa-leaf:before {
            content: "\f06c";
        }

        .fa-print:before {
            content: "\f02f";
        }

        .invoice-info {
            line-height: 24px;
            color: #444;
            vertical-align: bottom;
            margin-left: 9px;
            margin-right: 9px;
        }

        .widget-toolbar {
            display: inline-block;
            padding: 0 10px;
            line-height: 37px;
            float: right;
            position: relative;
        }

        .no-border {
            border-width: 0;
        }

        .invoice-info-label {
            display: inline-block;
            max-width: 100px;
            text-align: right;
            font-size: 14px;
        }

        .red {
            color: #DD5A43
        }

        .blue {
            color: #478FCA;
        }

        .widget-header-large > .widget-toolbar {
            line-height: 21px;
        }

        .widget-toolbar {
            display: inline-block;
            padding: 0 10px;
            float: right;
            position: relative;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        /*body {*/
        /*background-color: #E4E6E9;*/
        /*padding-bottom: 0;*/
        /*font-family: 'Open Sans';*/
        /*font-size: 13px;*/
        /*color: #393939;*/
        /*line-height: 1.5;*/
        /*}*/

        .widget-body .table {
            border-top: 1px solid #E5E5E5;
        }

        .table-bordered {
            border-radius: 0;
            border-right-color: rgb(221, 221, 221);
            border-right-style: solid;
            border-right-width: 1px;
            border-bottom-color: rgb(221, 221, 221);
            border-bottom-style: solid;
            border-bottom-width: 1px;
            border-left-color: rgb(221, 221, 221);
            border-left-style: solid;
            border-left-width: 1px;
            border-image-source: initial;
            border-image-slice: initial;
            border-image-width: initial;
            border-image-outset: initial;
            border-image-repeat: initial;
        }

        .widget-box.transparent > .widget-body {
            border-width: 0;
            background-color: transparent;
        }

        .widget-main.padding-24 {
            padding-top: 24px;
            padding-right: 24px;
            padding-bottom: 24px;
            padding-left: 24px;
        }

        .space {
            max-height: 1px;
            min-height: 1px;
            overflow: hidden;
            margin: 12px 0;
        }

        .center {
            text-align: center
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            position: relative;
            min-height: 1px;
            padding-left: 12px;
            padding-right: 12px;
        }

        .col-sm-12 {
            width: 100%;
        }

        .col-sm-6 {
            width: 50%;
        }

        .pull-left {
            float: left;
        }

        .hr8 {
            margin: 8px 0;
        }

        .hr-dotted, .hr.dotted {
            border-style: dotted;
        }

        .hr-double {
            height: 3px;
            border-top: 1px solid #E3E3E3;
            border-bottom: 1px solid #E3E3E3;
            border-top-color: rgba(0, 0, 0, .11);
            border-bottom-color: rgba(0, 0, 0, .11);
        }

        .hr {
            display: block;
            height: 0;
            overflow: hidden;
            font-size: 0;
            border-width: 1px 0 0;
            border-top: 1px solid #E3E3E3;
            margin: 12px 0;
            border-top-color: rgba(0, 0, 0, .11);
        }

        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        }

        .label.label-info {
            background-color: #3A87AD;
        }

        .label.label-success {
            background-color: #82AF6F;
        }

        .label-lg {
            padding: .3em .6em .4em;
            font-size: 13px;
            line-height: 1.1;
            height: 24px;
        }

        .label {
            color: #FFF;
            display: inline-block;
            line-height: 1.15;
            height: 20px;
        }

        .col-xs-12 {
            width: 100%;
        }

        .col-xs-6 {
            width: 50%;
        }

        .widget-box {
            padding: 0;
            box-shadow: none;
            margin: 3px 0;
            border: 1px solid #CCC;
        }

        .widget-header {
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box;
            position: relative;
            min-height: 38px;
            background: repeat-x #f7f7f7;
            background-image: -webkit-linear-gradient(top, #FFF 0, #EEE 100%);
            background-image: -o-linear-gradient(top, #FFF 0, #EEE 100%);
            background-image: linear-gradient(to bottom, #FFF 0, #EEE 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffeeeeee', GradientType=0);
            color: #669FC7;
            border-bottom: 1px solid #DDD;
            padding-left: 12px;
        }

        .fa-comment:before {
            content: "\f075";
        }

        .widget-header > .widget-title {
            line-height: 36px;
            padding: 0;
            margin: 0;
            display: inline;
        }

        h4.smaller {
            ont-size: 17px;
        }

        .lighter {
            font-weight: lighter;
        }

        .dialogs {
            padding: 9px;
        }

        .dialogs, .itemdiv {
            position: relative;
        }

        .widget-body {
            background-color: #FFF;
        }

        .widget-main {
            padding: 12px;
            no-margin
        }

        .no-padding {
            padding: 0;
        }

        .no-margin {
            margin: 0;
        }

        .widget-main.no-padding > form > .form-actions, .widget-main.padding-0 > form > .form-actions {
            margin: 0;
            padding: 10px 12px 12px;
        }

        .form-actions {
            display: block;
            background-color: #F5F5F5;
            border-top: 1px solid #E5E5E5;
            margin-bottom: 20px;
            margin-top: 20px;
            padding: 19px 20px 20px;
        }

        .pull-left {
            float: left;
        }

        .pull-right {
            float: right;
        }

        }
        .text-black {
            color: #373e43 !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-complete {
            color: #00e8ba !important;
        }

        .text-success {
            color: #007be8 !important;
        }

        .text-info {
            color: #47525e !important;
        }

        .text-warning {
            color: #fed76e !important;
        }

        .text-warning-dark {
            color: #ceae59 !important;
        }

        .text-danger {
            color: #ea2c54 !important;
        }

        .text-primary {
            color: #007be8 !important;
        }

        .text-true-black {
            color: #000 !important;
        }

        /* Font Weights
            ------------------------------------
             */
        .normal {
            font-weight: normal;
        }

        .semi-bold {
            font-weight: 400 !important;
        }

        .bold {
            font-weight: bold !important;
        }

        .light {
            font-weight: 300 !important;
        }

        /* Font Sizes
        ------------------------------------
        */
        .fs-7 {
            font-size: 7px !important;
        }

        .fs-8 {
            font-size: 8px !important;
        }

        .fs-9 {
            font-size: 9px !important;
        }

        .fs-10 {
            font-size: 10px !important;
        }

        .fs-11 {
            font-size: 10.5px !important;
        }

        .fs-12 {
            font-size: 12px !important;
        }

        .fs-13 {
            font-size: 13px !important;
        }

        .fs-14 {
            font-size: 14px !important;
        }

        .fs-15 {
            font-size: 15px !important;
        }

        .fs-16 {
            font-size: 16px !important;
        }

        .fs-18 {
            font-size: 18px !important;
        }

        /* Generic Padding Helpers
------------------------------------
*/
        .p-t-0 {
            padding-top: 0px !important;
        }

        .p-r-0 {
            padding-right: 0px !important;
        }

        .p-l-0 {
            padding-left: 0px !important;
        }

        .p-b-0 {
            padding-bottom: 0px !important;
        }

        .padding-0 {
            padding: 0px !important;
        }

        .p-t-5 {
            padding-top: 5px !important;
        }

        .p-r-5 {
            padding-right: 5px !important;
        }

        .p-l-5 {
            padding-left: 5px !important;
        }

        .p-b-5 {
            padding-bottom: 5px !important;
        }

        .padding-5 {
            padding: 5px !important;
        }

        .p-t-10 {
            padding-top: 10px !important;
        }

        .p-r-10 {
            padding-right: 10px !important;
        }

        .p-l-10 {
            padding-left: 10px !important;
        }

        .p-b-10 {
            padding-bottom: 10px !important;
        }

        .padding-10 {
            padding: 10px !important;
        }

        .p-t-15 {
            padding-top: 15px !important;
        }

        .p-r-15 {
            padding-right: 15px !important;
        }

        .p-l-15 {
            padding-left: 15px !important;
        }

        .p-b-15 {
            padding-bottom: 15px !important;
        }

        .padding-15 {
            padding: 15px !important;
        }

        .p-t-20 {
            padding-top: 20px !important;
        }

        .p-r-20 {
            padding-right: 20px !important;
        }

        .p-l-20 {
            padding-left: 20px !important;
        }

        .p-b-20 {
            padding-bottom: 20px !important;
        }

        .padding-20 {
            padding: 20px !important;
        }

        .p-t-25 {
            padding-top: 25px !important;
        }

        .p-r-25 {
            padding-right: 25px !important;
        }

        .p-l-25 {
            padding-left: 25px !important;
        }

        .p-b-25 {
            padding-bottom: 25px !important;
        }

        .padding-25 {
            padding: 25px !important;
        }

        .p-t-30 {
            padding-top: 30px !important;
        }

        .p-r-30 {
            padding-right: 30px !important;
        }

        .p-l-30 {
            padding-left: 30px !important;
        }

        .p-b-30 {
            padding-bottom: 30px !important;
        }

        .padding-30 {
            padding: 30px !important;
        }

        .p-t-35 {
            padding-top: 35px !important;
        }

        .p-r-35 {
            padding-right: 35px !important;
        }

        .p-l-35 {
            padding-left: 35px !important;
        }

        .p-b-35 {
            padding-bottom: 35px !important;
        }

        .padding-35 {
            padding: 35px !important;
        }

        .p-t-40 {
            padding-top: 40px !important;
        }

        .p-r-40 {
            padding-right: 40px !important;
        }

        .p-l-40 {
            padding-left: 40px !important;
        }

        .p-b-40 {
            padding-bottom: 40px !important;
        }

        .padding-40 {
            padding: 40px !important;
        }

        .p-t-45 {
            padding-top: 45px !important;
        }

        .p-r-45 {
            padding-right: 45px !important;
        }

        .p-l-45 {
            padding-left: 45px !important;
        }

        .p-b-45 {
            padding-bottom: 45px !important;
        }

        .padding-45 {
            padding: 45px !important;
        }

        .p-t-50 {
            padding-top: 50px !important;
        }

        .p-r-50 {
            padding-right: 50px !important;
        }

        .p-l-50 {
            padding-left: 50px !important;
        }

        .p-b-50 {
            padding-bottom: 50px !important;
        }

        .padding-50 {
            padding: 50px !important;
        }

        /* Generic Margin Helpers
        ------------------------------------
         */
        .m-t-0 {
            margin-top: 0px;
        }

        .m-r-0 {
            margin-right: 0px;
        }

        .m-l-0 {
            margin-left: 0px;
        }

        .m-b-0 {
            margin-bottom: 0px;
        }

        .m-t-5 {
            margin-top: 5px;
        }

        .m-r-5 {
            margin-right: 5px;
        }

        .m-l-5 {
            margin-left: 5px;
        }

        .m-b-5 {
            margin-bottom: 5px;
        }

        .m-t-10 {
            margin-top: 10px;
        }

        .m-r-10 {
            margin-right: 10px;
        }

        .m-l-10 {
            margin-left: 10px;
        }

        .m-b-5 {
            margin-bottom: 5px !important;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .m-t-15 {
            margin-top: 15px;
        }

        .m-r-15 {
            margin-right: 15px;
        }

        .m-l-15 {
            margin-left: 15px;
        }

        .m-b-15 {
            margin-bottom: 15px;
        }

        .m-t-20 {
            margin-top: 20px;
        }

        .m-r-20 {
            margin-right: 20px;
        }

        .m-l-20 {
            margin-left: 20px;
        }

        .m-b-20 {
            margin-bottom: 20px;
        }

        .m-t-25 {
            margin-top: 25px;
        }

        .m-r-25 {
            margin-right: 25px;
        }

        .m-l-25 {
            margin-left: 25px;
        }

        .m-b-25 {
            margin-bottom: 25px;
        }

        .m-t-30 {
            margin-top: 30px;
        }

        .m-r-30 {
            margin-right: 30px;
        }

        .m-l-30 {
            margin-left: 30px;
        }

        .m-b-30 {
            margin-bottom: 30px;
        }

        .m-t-35 {
            margin-top: 35px;
        }

        .m-r-35 {
            margin-right: 35px;
        }

        .m-l-35 {
            margin-left: 35px;
        }

        .m-b-35 {
            margin-bottom: 35px;
        }

        .m-t-40 {
            margin-top: 40px;
        }

        .m-r-40 {
            margin-right: 40px;
        }

        .m-l-40 {
            margin-left: 40px;
        }

        .m-b-40 {
            margin-bottom: 40px;
        }

        .m-t-45 {
            margin-top: 45px;
        }

        .m-r-45 {
            margin-right: 45px;
        }

        .m-l-45 {
            margin-left: 45px;
        }

        .m-b-45 {
            margin-bottom: 45px;
        }

        .m-t-50 {
            margin-top: 50px;
        }

        .m-r-50 {
            margin-right: 50px;
        }

        .m-l-50 {
            margin-left: 50px;
        }

        .m-b-50 {
            margin-bottom: 50px;
        }

        .full-height {
            height: 100% !important;
        }

        .full-width {
            width: 100%;
        }

        .hide {
            display: none !important;
        }

        .inline {
            display: inline-block !important;
        }

        .block {
            display: block !important;
        }

        .b-blank {
            border-color: #000;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .bg-black {
            background: #000;
        }

        .text-right {
            text-align: right !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-center {
            text-align: center !important;
        }
    </style>

<body>

<div class="header">
    <div class="pull-left">
        <div style="width: 500px">
            <p class="pull-left">Logo Here</p>
            <div class="m-l-0 pull-right" style="font-size: 20px">
                <p class="no-padding no-margin">Jl. Raya Kerobokan 388X</p>
                <p class="no-padding no-margin">Kuta Utara, Bali 80361</p>
                <p class="no-padding no-margin">Indonesia</p>
                <p class="no-padding no-margin">Phone: (0361) 736811</p>
                <p class="no-padding no-margin text-primary">www.globalxtreme.net</p>
            </div>
        </div>

    </div>
    <div class="pull-right">
        <h2 class="text-uppercase bold no-margin" style="font-size: 26px">PURCHASE ORDER</h2>
        <div class=" m-t-5" style="padding: 2px; ">
            <p class="text-true-black no-margin no-padding" style="padding-right: 20px; font-size:22px">
                DATE: Friday, 03/03/2018
            </p>
        </div>
        <div class="m-t-5" style="padding: 2px; ">
            <p class="text-true-black no-margin no-padding" style="padding-right: 20px; font-size:22px">
                PO #: PO12312001
            </p>
        </div>


    </div>
</div>

<div class="content" style="padding-top: 200px">
    <div class="pull-left">
        <table width="500px">
            <thead>
            <tr class="bg-black">
                <th class="text-white p-l-25 p-b-5" style="font-size: 20px">SUPPLIER</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-uppercase bold" style="font-size: 20px">PT RESTIA ABADI</td>
            </tr>
            <tr>
                <td style="font-size: 20px">(CP) Yessa Santoso / 081234124</td>
            </tr>
            <tr>
                <td style="font-size: 20px">Pinangsia Timur No 2C</td>
            </tr>
            <tr>
                <td style="font-size: 20px">Jakarta, DKI Jakarta, 11180</td>
            </tr>
            <tr>
                <td style="font-size: 20px">Indonesia</td>
            </tr>
            <tr>
                <td style="font-size: 20px">021 60123412</td>
            </tr>
            <tr>
                <td style="font-size: 20px">yessa@totolink.com</td>
            </tr>
            </tbody>

        </table>

    </div>

    <div class="pull-right">
        <table width="500px">
            <thead>
            <tr class="bg-black">
                <th class="text-white p-l-25 p-b-5" style="font-size: 20px">SHIP TO</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-uppercase bold" style="font-size: 20px">GLOBALXTREME BALI</td>
            </tr>
            <tr>
                <td style="font-size: 20px">Purwoko Sudarto</td>
            </tr>
            <tr>
                <td style="font-size: 20px">Jl Raya Kerobokan 388X</td>
            </tr>
            <tr>
                <td style="font-size: 20px">Kuta Utara, Bali 80361</td>
            </tr>
            <tr>
                <td style="font-size: 20px">Indonesia</td>
            </tr>
            </tbody>

        </table>

    </div>

</div>

<div class="content" style="padding-top: 480px">
    <table width="100%">
        <thead>
        <tr class="bg-black">
            <th width="80px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">
                Requisitioner
            </th>
            <th width="100px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">Ship Via
            </th>
            <th width="100px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">Term Of
                Payment
            </th>
            <th width="80px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">Term Of
                Delivery
            </th>
            <th width="50px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">Shipping
                Mark
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="border: 1px solid;font-size: 18px" class="p-l-10">abc</td>
            <td style="border: 1px solid;font-size: 18px" class="p-l-10">abc</td>
            <td style="border: 1px solid;font-size: 18px" class="p-l-10">abc</td>
            <td style="border: 1px solid;font-size: 18px" class="p-l-10">abc</td>
            <td style="border: 1px solid;font-size: 18px" class="p-l-10">abc</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="content" style="padding-top: 30px">
    <table width="100%">
        <thead>
        <tr class="bg-black">
            <th width="30px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">
                No.
            </th>
            <th width="200px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">
                Description
            </th>
            <th width="30px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">
                QTY
            </th>
            <th width="80px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">
                Unit Price
            </th>
            <th width="80px" class="text-white fs-18 text-center text-uppercase" style="font-weight: normal">
                Total
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="border: 1px solid;font-size: 19px;width: 30px" class="p-l-10">abc</td>
            <td style="border: 1px solid;font-size: 19px;width: 200px" class="p-l-10">abc</td>
            <td style="border: 1px solid;font-size: 19px;width: 30px" class="p-l-10">abc</td>
            <td style="border: 1px solid;font-size: 19px;width: 80px" class="p-r-10 text-right">500000</td>
            <td style="border: 1px solid;font-size: 19px;width: 80px;background: #ebebeb" class="p-r-10 text-right">
                500000
            </td>
        </tr>

        </tbody>
    </table>
</div>
<div class="content" style="padding-top: 5px">
    <table width="100%">
        <tbody>
        <tr>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 200px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width:80px;" class="p-r-10">Subtotal</td>
            <td style="font-size: 19px;width: 80px;background: #ebebeb" class="p-r-10 text-right">500000</td>
        </tr>
        <tr>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 200px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width:80px;" class="p-r-10">Tax</td>
            <td style="font-size: 19px;width: 80px;border: 1px solid #ebebeb" class="p-r-10 text-right">-</td>
        </tr>
        <tr>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 200px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width:80px;" class="p-r-10">Shipping</td>
            <td style="font-size: 19px;width: 80px;border: 1px solid #ebebeb" class="p-r-10 text-right">-</td>
        </tr>
        <tr>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 200px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width:80px;" class="p-r-10">Other</td>
            <td style="font-size: 19px;width: 80px;border: 1px solid #ebebeb" class="p-r-10 text-right">-</td>
        </tr>
        <tr>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 200px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width: 30px" class="p-l-10 text-white">.</td>
            <td style="font-size: 19px;width:80px;border-top: 1px solid black" class="p-r-10 bold">Total</td>
            <td style="font-size: 19px;width: 80px;border-top: 1px solid black;background: #ebebeb"
                class="p-r-10 text-right bold">-
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="content" style="padding-top: 20px">

    <div class="pull-left" style="margin-top: -150px">
        <table width="500px">
            <thead>
            <tr style="background:lightgrey">
                <th class="p-l-25 p-b-5" style="font-size: 18px">Comments or Special Instructions</th>
            </tr>
            <tr>
                <th class="p-l-25 p-b-5" style="font-size: 18px">Prices include 10% VAT</th>
            </tr>
            </thead>
        </table>
        <div class="p-t-20">
            <img src="{{public_path('images/company/npwp/PT-IMAM-NPWP.jpeg')}}" height="300px" alt="">
        </div>
    </div>


</div>
<div class="clearfix"></div>
<div class="content" style="padding-top: 50px;padding-right: 50px">
    <div class="pull-right">
        <table>
            <tbody>
            <tr>
                <td class="text-center fs-18">Authorized Signature,</td>
            </tr>
            <tr>
                <td class="text-center">
                    <img src="{{public_path('images/company/npwp/PT-IMAM-NPWP.jpeg')}}"
                         style="text-align: center"
                         height="100px" alt="">
                </td>
            </tr>
            <tr>
                <td class="text-center fs-18">Cinide Marceclla</td>
            </tr>
            <tr>
                <td class="text-center fs-18 text-uppercase">CHIEF FINANCE OFFICER</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>