@extends('layouts.app')

@section('content')
    <x-listing-form :route="route('incomelistings.store')" type="income" :buttonText="__('messages.create_income_listing')" />
@endsection
