@extends('layouts.app')

@section('content')
    <x-listing-form :route="route('expenselistings.store')" type="expense" :buttonText="__('messages.create_expense_listing')" />
@endsection
