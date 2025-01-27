<form action="{{ isset($user) ? route('admin.update', $user) : route('admin.store') }}" method="POST">
    @csrf
    @if (isset($user))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label for="name" class="form-label">{{ __('admin.name') }}</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('admin.email') }}</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">{{ __('admin.password') }}</label>
        <input type="password" id="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">{{ __('admin.confirm_password') }}</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>
    <button type="submit" class="btn btn-success">{{ isset($user) ? __('admin.update') : __('admin.create') }}</button>
</form>
