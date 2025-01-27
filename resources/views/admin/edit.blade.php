@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('admin.edit_user') }}</h1>
        @include('admin.form')
    </div>
@endsection
