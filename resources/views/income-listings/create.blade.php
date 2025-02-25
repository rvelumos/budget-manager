@extends('layouts.app')

@section('content')
    <x-listing-form
        :route="route('income-listings.store')"
        type="income"
        :title="__('messages.add_income_listing')"
        :buttonText="__('messages.save')"
    />
@endsection
