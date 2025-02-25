@extends('layouts.app')

@section('content')

    <div class="content-wrapper">
        <h1 class="text-2xl font-bold mb-6">{{ __('messages.expense_listings') }}</h1>

        <div class="container-btn-group">
            <a href="{{ route('expense-listings.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">{{ __('messages.add_list') }}</a>
        </div>

        @if ($listings->isEmpty())
            <p>No listings found.</p>
        @else

            @foreach ($listings as $listing)
                <div style="width: 100%;">
                    <a href="{{ route('expense-listings.show', $listing->id) }}">
                        <div class="container-small">
                            <div>
                                <span>{{ $listing->name }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        @endif
    </div>
@endsection
