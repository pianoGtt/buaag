<?php
/**
 * BaseRepository
 *
 * @package Repository
 * @author: shubiao-yao <yaoshubiao@gmail.com>
 * @DateTime: 2018/7/22 10:02
 */

namespace App\Repositories;


trait BaseRepository
{
    /**
     * Get number of records
     *
     * @return array
     */
    public function getNumber()
    {
        return $this->model->count();
    }

    /**
     * Update columns in the record by id.
     *
     * @param $id
     * @param $input
     * @return App\Model|User
     */
    public function updateColumn($id, $input)
    {
        $this->model = $this->getById($id);
        foreach ($input as $key => $value) {
            $this->model->{$key} = $value;
        }
        return $this->model->save();
    }

    /**
     * Destroy a model.
     *
     * @param  $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * Get model by id.
     *
     * @return App\Model
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get model by where.
     *
     * @param $where
     * @return mixed
     */
    public function getByWhere(array $where)
    {
        return $this->model->where($where)->first();
    }

    /**
     * first or create
     *
     * @param $first
     * @param array $second
     * @return mixed
     */
    public function firstOrCreate($first, $second = [])
    {
        if ($second) {
            return $this->model->firstOrCreate($first, $second);
        } else {
            return $this->model->firstOrCreate($first);
        }
    }

    /**
     * Get all the records
     *
     * @return array User
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Get number of the records
     *
     * @param  array $where
     * @param  int $number
     * @param  string $sort
     * @param  string $sortColumn
     * @return Paginate
     */
    public function list(array $where, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->where($where)->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Store a new record.
     *
     * @param  $input
     * @return User
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    /**
     * Update a record by id.
     *
     * @param  $id
     * @param  $input
     * @return User
     */
    public function update($id, $input)
    {
        $this->model = $this->getById($id);
        return $this->save($this->model, $input);
    }

    /**
     * Save the input's data.
     *
     * @param  $model
     * @param  $input
     * @return User
     */
    public function save($model, $input)
    {
        $model->fill($input);
        $model->save();
        return $model;
    }

    /**
     * field increment number
     *
     * @param $where
     * @param $field
     * @param $number
     * @return mixed
     */
    public function increment($where,$field, $number = 1)
    {
        return $this->model->where($where)->increment($field, $number);;
    }
}