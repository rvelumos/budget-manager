@extends('layouts.app')

@section('content')
    <x-listing-form
        :route="route('expenselistings.update', $expenseListing->id)"
        type="expense"
        :listing="$expenseListing"
        :buttonText="__('messages.update_expense_listing')"
    />
@endsection
