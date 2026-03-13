<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ config('app.name') }}</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>

{{-- @include('layouts.navigation') --}}

<div class="container mx-auto p-6">
    @yield('content')
</div>

</body>
</html>