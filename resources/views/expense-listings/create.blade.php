@extends('layouts.app')

@section('content')
    <x-listing-form
        :route="route('expense-listings.store')"
        type="expense"
        :buttonText="__('messages.create_expense_listing')"
        :title="__('messages.edit_income_listing')"
    />
@endsection
