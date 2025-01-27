@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('admin.user_details') }}</h1>
        <p><strong>{{ __('admin.name') }}:</strong> {{ $user->name }}</p>
        <p><strong>{{ __('admin.email') }}:</strong> {{ $user->email }}</p>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">{{ __('admin.back_to_users') }}</a>
    </div>
@endsection
