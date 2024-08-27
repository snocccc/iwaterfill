@extends('components.layoutDash')

@section('dash')

<section>
    <div class="text-xl">
        <h1>Hello {{ auth()->user()->username }}</h1>
    </div>

</section>


@endsection
