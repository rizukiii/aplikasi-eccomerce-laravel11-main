@extends('layouts.front')

@section('title', 'Beranda')

@section('content')
    <main>
        @if (session('error'))
            <script>
                alert('{{ session('error') }}');
            </script>
        @endif
        @include('front.sections.new_arrivals')

        {{-- @include('front.sections.brands') --}}

        @include('front.sections.popular')

        @include('front.sections.category')

        {{-- @include('front.sections.banner') --}}

        @include('front.sections.all_product')
    </main>
@endsection
