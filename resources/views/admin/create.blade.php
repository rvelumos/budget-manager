@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('admin.add_user') }}</h1>
        @include('admin.form')
    </div>
@endsection
