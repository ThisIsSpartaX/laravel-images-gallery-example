<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="author" content="">

    {{-- Fonts --}}
    @yield('template_linked_fonts')

    {{-- Styles --}}
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{-- Scripts --}}
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>

    @yield('head')

</head>
<body>
<div id="app">

    <main class="py-4">

        <div class="container">
            @include('partials.header')
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('partials.form-status')
                </div>
            </div>
        </div>

        @yield('content')

    </main>

</div>

@yield('footer_scripts')

</body>
</html>