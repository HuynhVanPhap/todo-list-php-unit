<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\RequestStore;
use App\Http\Requests\Todo\RequestUpdate;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function index(Request $request) {
        $update = $request->update ?? false;

        $todo = $this->todo->whereId($request->id)->first();
        $todos = $this->todo->get();

        return view('todo.index')->with([
            'update' => $update,
            'todo' => $todo,
            'todos' => $todos
        ]);
    }

    public function store(RequestStore $request) {
        $todo = $this->todo->create(
            [
                'task' => $request->task
            ]
        );

        return !blank($todo) ? redirect()->route('todo.index')->with('success', 'Thêm mới thành công !') : back()->withInput();
    }

    public function update(int $id, RequestUpdate $request) {
        $todo = $this->todo->where('id', $id)->update(['task' => $request->task]);

        return ($todo) ? redirect()->route('todo.index')->with('success', 'Cập nhật thành công !') : back()->withInput();
    }

    public function destroy(int $id) {
        $todo = $this->todo->destroy($id);

        return ($todo) ? redirect()->route('todo.index')->with('success', 'Xóa thành công !') : back()->withInput();
    }
}
