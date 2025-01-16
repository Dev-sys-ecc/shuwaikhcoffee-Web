<!DOCTYPE html>
<html lang="en" @if ($rtl) dir="rtl" @endif>
<head>

    <title>@yield('title')</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">

    <meta name="keywords" content="SHUWAIKH COFFEE , شــويــخ كافيه , shuwaikh , shuwaikhcoffe , coffe , الشويخ">

    <meta name="description" content="SHUWAIKH COFFEE شــويــخ كافيه">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">

    <!-- Favicons Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PWA Version -->
    <link rel="manifest" href="manifest.json">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- Global CSS -->

    <link href="{{ asset('assets/shuwaikhcoffe/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/shuwaikhcoffe/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/shuwaikhcoffe/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/plugin_css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/plugin_css/plugin.min.css') }}">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset($rtl ? 'assets/shuwaikhcoffe/css/style-ar.css' : 'assets/shuwaikhcoffe/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/qr-plugins.css') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..400&display=swap" rel="stylesheet">

    <script src="{{asset('assets/front/js/vendor/jquery.3.2.1.min.js')}}"></script>

    <style>
        body{
            font-family: "Alexandria", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
    </style>
</head>
