<!DOCTYPE html>
<html dir="ltr" lang="en-US">

@include('partials.head')
@stack('head')

<body class="gradient-bg">
    @include('partials.svg')

    @include('partials.style')

    @include('partials.header')

    @yield('content')

@include('partials.footer')

@include('partials.script')
@stack('script')
</body>

</html>
