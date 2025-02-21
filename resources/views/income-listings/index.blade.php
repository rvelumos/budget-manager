@extends('layouts.app')

@section('content')
    <x-listing-table
        :items="$listings->flatMap->incomes"
        :listings="$listings"
        type="income-listings"
        title="{{ __('messages.income_listings') }}"
    />
@endsection
