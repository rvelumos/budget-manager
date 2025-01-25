@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Budget</h1>

    @include('budgets.form', [
        'action' => route('budgets.update', $budget),
        'method' => 'PUT',
        'budget' => $budget,
        'categories' => $categories,
        'buttonText' => 'Update Budget',
    ])
</div>
@endsection
