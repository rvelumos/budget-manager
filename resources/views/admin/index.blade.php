@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('admin.users') }}</h1>
    <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">{{ __('admin.add_user') }}</a>
    <table class="table">
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.name') }}</th>
            <th>{{ __('admin.email') }}</th>
            <th>{{ __('admin.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('admin.show', $user) }}" class="btn btn-info btn-sm">{{ __('admin.view') }}</a>
                <a href="{{ route('admin.edit', $user) }}" class="btn btn-warning btn-sm">{{ __('admin.edit') }}</a>
                <form action="{{ route('admin.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">{{ __('admin.delete') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
