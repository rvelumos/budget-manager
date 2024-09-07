@extends('layouts.app')

@section('content')
    <x-listing-table :items="$incomeListings" type="incomes" title="{{ __('messages.income_listings') }}" />
@endsection
