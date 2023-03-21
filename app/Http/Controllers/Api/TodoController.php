<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\RequestStore;
use App\Http\Requests\Todo\RequestUpdate;
use App\Http\Resources\TodoResource;
use App\Repositories\TodoRepository;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoRepo;

    public function __construct(TodoRepository $todoRepo)
    {
        $this->todoRepo = $todoRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStore $request) {
        $todo = $this->todoRepo->create(
            [
                'task' => $request->task
            ]
        );

        return response()->json(
            [
                'success' => 'Thêm mới thành công !',
                'todo' => new TodoResource($todo)
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = $this->todoRepo->getById($id);

        return response()->json(
            [
                'todo' => new TodoResource($todo)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, RequestUpdate $request) {
        $todoStatus = $this->todoRepo->update($id, ['task' => $request->task]);

        return response()->json(
            [
                'success' => 'Cập nhật thành công !'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $todoStatus = $this->todoRepo->delete($id);

        return response()->json(
            [
                'success' => 'Xóa thành công !'
            ]
        );
    }
}
