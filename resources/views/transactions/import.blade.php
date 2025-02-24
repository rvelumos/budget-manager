@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <h2>{{ __('messages.import_transactions') }}</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ __('messages.success_message') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transactions.import.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">{{ __('messages.upload_csv') }}</label>
                    <input type="file" class="form-control" id="file" name="file" required>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.import') }}</button>
            </form>
        </div>
    </div>
@endsection
