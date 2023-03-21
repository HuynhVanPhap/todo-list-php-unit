<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Models\Todo;

class TodoRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function getModel()
    {
        return Todo::class;
    }
}
