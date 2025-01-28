@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Create Budget</h1>

    @include('budgets.form', [
        'action' => route('budgets.store'),
        'method' => null,
        'budgets' => null,
        'categories' => $categories,
        'buttonText' => 'Create Budget',
    ])
</div>
@endsection
