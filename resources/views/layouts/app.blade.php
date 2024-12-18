<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    {{-- Style --}}
    @stack('prepend-style')
    @include('include.style')
    @stack('addon-style')


</head>

<body>

    {{-- Navbar --}}
    @include('include.navbar')

    {{-- Page Content --}}
    @yield('content')


    {{-- Footer --}}
    @include('include.footer')

    {{-- Script --}}
    @stack('prepend-script')
    @include('include.script')
    @stack('addon-script')

</html>
