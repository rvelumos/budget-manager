<div class="container">
    <form action="{{ $route }}" method="POST">
        @csrf
        @if($listing)
            @method('PUT')
        @endif

        @if ($errors->has('limit'))
            <div class="alert alert-danger">
                {{ $errors->first('limit') }}
            </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('messages.listing_name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $listing->name ?? old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    </form>
</div>
