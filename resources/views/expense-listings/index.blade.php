@extends('layouts.app')

@section('content')
    :items="$listings->flatMap->incomes"
    :listings="$listings"
    type="expense-listings"
    title="{{ __('messages.expense_listings') }}"
@endsection
