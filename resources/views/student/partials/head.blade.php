<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>{{ config('app.name') }}</title>
<link rel="icon" href="{{ $brandLogo ?? asset('images/logo/Levels-logo.png') }}" type="image/png">

<!-- Prevent the demo from appearing in search engines -->
<meta name="robots" content="noindex">

<link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap" rel="stylesheet">

<!-- Preloader -->
<link type="text/css" href="{{asset('vendor/spinkit.css')}}" rel="stylesheet">

<!-- Perfect Scrollbar -->
<link type="text/css" href="{{asset('vendor/perfect-scrollbar.css')}}" rel="stylesheet">

<!-- Material Design Icons -->
<link type="text/css" href="{{asset('css/material-icons.css')}}" rel="stylesheet">

<!-- Font Awesome Icons -->
<link type="text/css" href="{{asset('css/fontawesome.css')}}" rel="stylesheet">

<!-- Preloader -->
<link type="text/css" href="{{asset('css/preloader.css')}}" rel="stylesheet">

<!-- App CSS -->
@php
    $themeCss = isset($currentOrganization) && $currentOrganization && $currentOrganization->theme_css
        ? $currentOrganization->theme_css
        : 'css/app.css';
@endphp
<link type="text/css" href="{{ asset($themeCss) }}" rel="stylesheet">



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.css">


<style>
      @font-face {
            font-family: myFirstFont;
            src: url(/fonts/DroidKufi-Regular.ttf);
      }

      .font-droid {
            font-family: myFirstFont !important;
      }
</style>
@stack('css')