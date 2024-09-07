<div class="container">
    <form action="{{ $route }}" method="POST">
        @csrf
        @if($listing)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('messages.listing_name') }}</label>
            <input type="text" class="form-control" name="name" value="{{ $listing->name ?? old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">{{ __('messages.description') }}</label>
            <textarea class="form-control" name="description">{{ $listing->description ?? old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    </form>
</div>
