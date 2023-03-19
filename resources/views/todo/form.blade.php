<form
    method="post"
    @if ($update)
        action="{{ route('todo.update', $todo->id) }}"
    @else
        action="{{ route('todo.store') }}"
    @endif
>
    @csrf

    @if ($update)
        @method("PUT")
    @endif

    <p class="text-success">
        {{ session('success') ?? '' }}
    </p>
    <p class="text-danger">
        {{ $errors->first('task') ?? '' }}
    </p>

    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Enter Something..." name="task" value="{{ $todo->task ?? '' }}">
        <button type="submit" class="btn btn-primary" name="{{ $update ? 'update' : 'add'}}">
            {{ $update ? 'Update' : 'Add'}}
        </button>
    </div>
</form>
