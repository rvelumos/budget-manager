@extends('layouts.app')

@section('content')
    <x-listing-form
        :route="route('expense-listings.update', $expenseListing->id)"
        type="expense"
        :listing="$expenseListing"
        :title="__('messages.edit_expense_listing')"
        :buttonText="__('messages.update_expense_listing')"
    />
@endsection
