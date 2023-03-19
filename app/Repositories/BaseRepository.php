<?php

namespace App\Repositories;

use Carbon\Carbon;
/**
 *
 * Class BaseRepository
 * @package App\Repositories
 */

abstract class BaseRepository
{
    protected $model;
    const LIMIT = 10;

    public function __construct()
    {
        $this->setModel();
    }

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    abstract public function getModel();

    public function getLists()
    {
        return $this->model->get();
    }

    public function update($id, $params)
    {
        return $this->model->where('id', $id)
            ->update($params);
    }

    public function getListPaginates($limit = self::LIMIT)
    {
        return $this->model->select()->orderBy('id','DESC')
            ->paginate($limit);
    }

    public function create($params)
    {
        return $this->model->create($params);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getById($id)
    {
        return $this->model->where('id', $id)
            ->first();
    }

    public function inserts($params)
    {
        return $this->model->insert($params);
    }

    public function getListByTake($take)
    {
        $data = $this->model
            ->orderBy('id', 'DESC')
            ->take($take)
            ->get();

        return $data;
    }

    public function getListDESC($limit = self::LIMIT)
    {
        return $this->model->orderBy('id', 'DESC')->limit($limit)->get();
    }

    public function getListByArrIds($params)
    {
        return $this->model->whereIn('id',$params)->get();
    }

    public function countNewToday()
    {
        return $this->model->whereDate('created_at', Carbon::now('Asia/Ho_Chi_Minh')->toDateString())->count();
    }
}
