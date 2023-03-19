<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\RequestStore;
use App\Http\Requests\Todo\RequestUpdate;
use App\Models\Todo;
use App\Repositories\TodoRepository;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoRepo;

    public function __construct(TodoRepository $todoRepo)
    {
        $this->todoRepo = $todoRepo;
    }

    public function index(Request $request) {
        $update = $request->update ?? false;

        $todo = $this->todoRepo->getById($request->id);
        $todos = $this->todoRepo->getLists();

        return view('todo.index')->with([
            'update' => $update,
            'todo' => $todo,
            'todos' => $todos
        ]);
    }

    public function store(RequestStore $request) {
        $todo = $this->todoRepo->create(
            [
                'task' => $request->task
            ]
        );

        return !blank($todo) ?
            redirect()->route('todo.index')->with('success', 'Thêm mới thành công !') :
            back()->withInput()->with('fail', 'Thêm mới thất bại');
    }

    public function update(int $id, RequestUpdate $request) {
        $todo = $this->todoRepo->update($id, ['task' => $request->task]);

        return ($todo) ?
            redirect()->route('todo.index')->with('success', 'Cập nhật thành công !') :
            back()->withInput()->with('fail', 'Cập nhật thất bại');
    }

    public function destroy(int $id) {
        $todo = $this->todoRepo->delete($id);

        return ($todo) ?
            redirect()->route('todo.index')->with('success', 'Xóa thành công !') :
            back()->withInput()->with('fail', 'Xóa thất bại');
    }
}
