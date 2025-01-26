@extends('layouts.app')

@section('content')
    <x-listing-table :items="$ExpenseListings" type="expenses" title="{{ __('messages.expense_listings') }}" />
@endsection
