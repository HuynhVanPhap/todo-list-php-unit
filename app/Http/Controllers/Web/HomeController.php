<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\TodoRepository;

class HomeController extends Controller
{
    protected $todoRepo;

    public function __construct(TodoRepository $todoRepo)
    {
        $this->todoRepo = $todoRepo;
    }

    public function index() {
        $todos = $this->todoRepo->getLists();

        return view('home')->with([
            'todos' => $todos
        ]);
    }
}
