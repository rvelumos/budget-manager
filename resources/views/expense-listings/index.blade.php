@extends('layouts.app')

@section('content')
    <x-listing-table :items="$expenseListings" type="expenses" title="{{ __('messages.expense_listings') }}" />
@endsection
