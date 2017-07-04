<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }} - {{ config('app.domain', 'Test.com') }}</title>

<!-- Fav Icon -->
<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('fonts/web-icons/web-icons.min.css') }}">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<!--[if lt IE 9]>
<script src="{{ asset('vendor/html5shiv/html5shiv.min.js') }}"></script>
<![endif]-->

<!--[if lt IE 10]>
<script src="{{ asset('vendor/media-match/media.match.min.js') }}"></script>
<script src="{{ asset('vendor/respond/respond.min.js') }}"></script>
<![endif]-->