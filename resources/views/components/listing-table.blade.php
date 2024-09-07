<div class="container">
    <h1>{{ $title }}</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('messages.category') }}</th>
                <th>{{ __('messages.amount') }}</th>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->date }}</td>
                    <td>
                        <a href="{{ route("{$type}.edit", $item->id) }}" class="btn btn-warning">{{ __('messages.edit') }}</a>
                        <form action="{{ route("{$type}.destroy", $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
