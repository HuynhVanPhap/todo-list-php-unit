@extends('master')

@section('content')
@include('todo.form')

<div class="row my-3">
    @if (!blank($todos))
        @foreach ($todos as $todo)
            <div class="todo-infor-{{ $todo->id }} row my-3">
                <div class="col-sm-10 todo-task" id="task-{{ $todo->id }}">
                    {{ $todo->task }}
                </div>

                <div class="col-sm-1 todo-edit">
                    <a href="#" class="text-success text-decoration-none edit-submit" data-id="{{ $todo->id }}">
                        <i class='fas fa-edit'></i>
                    </a>
                </div>

                <div class="col-sm-1 todo-delete">
                    <a href="#" class="text-danger text-decoration-none delete-submit" data-id="{{ $todo->id }}">
                        <i class='fas fa-trash-alt'></i>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $("#update-submit").hide();
        });

        $("#add-submit").on('click', (function(e) {
            e.preventDefault();

            const task = $("input[name=task]").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: "{{ route('todos.store') }}",
                data: {
                    task: task
                },
                success: function (res) {
                    $("input[name=task]").val('');
                    $("#success-message").text(res.success);
                    // Clone thành phần cuối
                    const todo = $(".todo-infor").last().clone();
                    // Chỉnh sửa thông tin clone
                    $(todo).find(".todo-task").text(res.todo.task);
                    $(todo).find(".todo-edit").children("a").attr("data-id", res.todo.id);
                    $(todo).find(".todo-delete").children("a").attr('data-id', res.todo.id);
                    $(todo).insertAfter($(".todo-infor").last());
                },
                error: function (error) {
                    $("#success-message").text('');
                    $("#error-message").text(error.responseJSON.message);
                }
            });
        }));

        $(".edit-submit").click(function(e) {
            e.preventDefault();

            const id = $(this).data('id');

            $.ajax({
                type: 'GET',
                dataType: 'json',
                cache: false,
                url: "api/todos/"+id,
                data: {
                    id: id
                },
                success: function (res) {
                    $("input[name=task]").val(res.todo.task);
                    $("input[name=task]").attr("data-id", res.todo.id);
                    $("#add-submit").hide();
                    $("#update-submit").show();
                },
                error: function (error) {
                    $("#success-message").text('');
                    $("#error-message").text(error.responseJSON.message);
                }
            });
        });

        $("#update-submit").on('click', (function(e) {
            e.preventDefault();

            const task = $("input[name=task]").val();
            const id = $("input[name=task]").data('id');

            $.ajax({
                type: 'PUT',
                dataType: 'json',
                cache: false,
                url: "api/todos/"+id,
                data: {
                    id: parseInt(id),
                    task: task
                },
                success: function (res) {
                    $("#success-message").text(res.success);
                    $("input[name=task]").attr("data-id", "");
                    $("input[name=task]").val('');
                    $("#add-submit").show();
                    $("#update-submit").hide();
                    $("#task-"+id).text(task);
                },
                error: function (error) {
                    $("#success-message").text('');
                    $("#error-message").text(error.responseJSON.message);
                }
            });
        }));

        $(".delete-submit").click(function(e) {
            e.preventDefault();

            const id = $(this).data('id');

            $.ajax({
                type: 'DELETE',
                dataType: 'json',
                cache: false,
                url: "api/todos/"+id,
                data: {
                    id: parseInt(id)
                },
                success: function (res) {
                    $("#success-message").text(res.success);
                    $(".todo-infor-"+id).remove();
                },
                error: function (error) {
                    $("#success-message").text('');
                    $("#error-message").text(error.responseJSON.message);
                }
            });
        });
    </script>
@endsection
