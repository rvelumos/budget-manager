@extends('layouts.app')

@section('content')
    <x-listing-form
        :route="route('incomelistings.update', $incomeListing->id)"
        type="income"
        :listing="$incomeListing"
        :buttonText="__('messages.update_income_listing')"
    />
@endsection
