@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Create Budget</h1>

    @include('budgets.partials._form', [
        'action' => route('budgets.store'),
        'method' => null,
        'budget' => null,
        'categories' => $categories,
        'buttonText' => 'Create Budget',
    ])
</div>
@endsection
