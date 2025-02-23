@extends('layouts.app')

@section('content')
    <x-listing-table
        :items="$listings->flatMap->expenses"
        :listings="$listings"
        type="expense-listings"
        title="{{ __('messages.expense_listings') }}"
    />
@endsection
