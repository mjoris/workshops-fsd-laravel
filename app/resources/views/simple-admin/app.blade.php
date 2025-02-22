<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('simple-admin/css/style.css') }}" rel="stylesheet">

</head>
<body id="app-layout">
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header"><!-- Just an image -->
            <a class="navbar-brand" href="{{ url('products') }}"><img src="{{ asset('simple-admin/img/ikdoeict.png') }}" height="20" alt="ikdoeict alt logo"></a>
            <a class="navbar-brand" href="{{ url('products') }}">@yield('title')</a>
        </div>

    </div>
</nav>

<div class="container">


        @section('content')
            <p>this is where the page content goes</p>
        @show


</div>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">&copy; {{ now()->year }} Odisee &mdash; Opleiding Elektronica-ICT &mdash; Web &amp; Mobile Full-stack</span>
    </div>
</footer>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
@section('scripts')
@show
</body>
