<!-- Web Meta Content -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="">
<meta name="copyright" content="">
<meta name="email" content="">
<meta http-equiv="Content-Language" content="en">
<meta name="Charset" content="UTF-8">
<meta name="Rating" content="General">
<meta name="Distribution" content="Global">
<meta name="Robots" content="INDEX,FOLLOW">
<meta name="Revisit-after" content="7 Days">
<meta name="expires" content="2020">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="home" content="{{ config('app.url') }}">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="csrf-token-encoded" content="{{ json_encode(['csrfToken' => csrf_token()]) }}">

<!-- Branding Image -->
<title>{{ config('app.name') }}</title>

<!-- Branding favicon -->
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

<!-- Javascript routing -->
@routes

<!-- Manifest -->
<link rel="manifest" href="{{ asset('mix-manifest.json') }}">

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- Any additional styles -->
@yield('stylesheet')