@extends('layouts.app')

@section('content')
    <x-listing-form :route="route('income-listings.store')" type="income" :buttonText="__('messages.create_income_listing')" />
@endsection
