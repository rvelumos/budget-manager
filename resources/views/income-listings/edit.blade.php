@extends('layouts.app')

@section('content')
    <x-listing-form
        :route="route('income-listings.update', $incomeListing->id)"
        type="income"
        :listing="$incomeListing"
        :title="__('messages.edit_income_listing')"
        :buttonText="__('messages.update')"
    />
@endsection
