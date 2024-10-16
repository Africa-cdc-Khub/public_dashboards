<!DOCTYPE html>
<html lang="en" xmlns="https://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="Africa CDC" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Africa CDC Public Dashboards | <?= @$event ?></title>
    <link href="<?php echo base_url() ?>assets/img/favicon.png" rel="icon">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>resources/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/quiz.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/sharing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css"
        rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" rel="stylesheet"
        type="text/css" />

<style>
    .goog-te-banner-frame.skiptranslate,
    .goog-logo-link,
    .VIpgJd-ZVi9od-ORHb-OEVmcd,
    .goog-te-gadget-icon,
    div.feedback-form-container,
    div.feedback-prompt {
        display: none !important;
    }

    body {
        top: 0px !important;
    }

    .trans-section {
        margin: 100px;
    }
    .nav-menu>li>a {
        padding: 10px 18px;
        display: inline-block;
        font-weight: 400;
        font-size: 15px;
        color: #172228;
        border: 1px #f5f2f2 solid;
    }
    .nav-item {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-link {
        display: block;
        padding: 0px 15px;
        text-decoration: none;
        color: #333;
        transition: background-color 0.3s, color 0.3s;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .nav-link:hover {
        background-color: #f5f5f5;
        color: #C3A366;
    }

    .nav-link.active {
        background-color: #f6f8f7;
        color: #31b372;
        font-weight: bold;
    }

    .nav-link i {
        margin-right: 8px;
    }

    .VIpgJd-ZVi9od-vH1Gmf-ibnC6b div,
    .VIpgJd-ZVi9od-vH1Gmf-ibnC6b:link div,
    .VIpgJd-ZVi9od-vH1Gmf-ibnC6b:visited div,
    .VIpgJd-ZVi9od-vH1Gmf-ibnC6b:active div {
        color: #000 !important;
    }

    .VIpgJd-ZVi9od-vH1Gmf-ibnC6b:hover div {
        color: #FFF;
        background: --;
    }

    .sw-btn {
        padding: 0.775rem .95rem !important;
    }

    .main-search {
        height: 54px !important;
        padding: 10px 15px;
    }

    .favbtn a:hover {
        color: white !important;
    }

    .app-comment {
        padding: 10px;
        background-color: rgba(222, 224, 222, 0.5);
        border-radius: 8px;
        margin-top: 10px;
    }

    label {
        font-weight: bold !important;
    }

    .mobileonly {
        display: none;
    }

    @media only screen and (max-width: 800px) {
        .mobileonly {
            display: block !important;
        }
    }

    @media only screen and (min-width: 801px) {
        .mobileonly {
            display: none !important;
        }
    }

    .flag-icon {
        font-size: 22px;
        border-radius: 20px;
    }

    .goog-te-gadget-simple {
        border-radius: 4px;
    }

    .custom-bg {
        background-color: var(--theme-color-primary) !important;
        background-image: url('{{ settings()->spotlight_banner }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }

    @media only screen and (min-device-width: 100px) and (max-device-width: 850px) {
        .custom-row {
            display: flex;
            justify-content: center;
        }

        .custom-row-item {
            max-width: 45.5%;
        }
    }

    .select2-selection__rendered {
        padding-left: 17px !important;
    }

    .nav-dropdown {
        z-index: 1000 !important;
    }

    .header-top {
        background: var(--theme-color-primary) !important;
        color: #FFFF;
    }

    .circular {
        min-width: 100px !important;
        min-height: 100px !important;
        max-width: 100px !important;
        max-height: 100px !important;
        border-radius: 50%;
    }

    .theme-primary {
        background: var(--theme-color-primary) !important;
        color: #fff;
        border-radius: 3px;
    }

    .theme-secondary {
        background: var(--theme-color-secondary) !important;
        color: #FFF;
        border-radius: 3px;
    }

    .text-primary {
        color: var(--theme-color-primary) !important;
    }

    .text-secondary {
        color: var(--theme-color-secondary) !important;
    }

    @media (max-width: 767px) {
        .mobile-language-menu-container {
            display: block !important;
            padding: 5px !important;
        }
    }

    @media (min-width: 768px) {
        .mobile-language-menu-container {
            display: none !important;
        }
    }

    .language-menu {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .language-menu li {
        display: inline-block;
        margin-right: 10px;
    }
    .header{
        height:48.5px;

    }
</style>




</head>

<body>

    <span class="base_url" style="display:none;"><?php echo base_url(); ?></span>