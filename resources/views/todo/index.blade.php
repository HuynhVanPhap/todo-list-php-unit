@extends('master')

@section('content')
@include('todo.form')

<div class="row my-3">
    @if (!blank($todos))
        @foreach ($todos as $todo)
        <div class="col-sm-10">
            {{ $todo->task }}
        </div>

        <div class="col-sm-1">
            <a href="{{ route('todo.index', ['id' => $todo->id, 'update' => true]) }}" class="text-success text-decoration-none">
                <i class='fas fa-edit'></i>
            </a>
        </div>

        <div class="col-sm-1">
            <form action="{{route('todo.destroy', $todo->id)}}"
                method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-danger text-decoration-none">
                    <i class='fas fa-trash-alt'></i>
                </button>
            </form>
        </div>
        @endforeach
    @endif
</div>
@endsection
