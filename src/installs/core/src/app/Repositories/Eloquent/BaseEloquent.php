<?php

namespace Core\Repositories\Eloquent;

use Core\Repositories\Contracts\BaseInterface;
use Illuminate\Config\Repository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEloquent implements BaseInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            return 'Error';
        }
        return $this->model = $model;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->model->get($columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*'])
    {
        return $this->model->where($field, $value)->select($columns)->firstOrFail();
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByFirst($field, $value, $columns = ['*'])
    {
        return $this->model->where($field, $value)->select($columns)->first();
    }

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     * @return mixed
     * @author Rent
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * @param array $where
     * @param $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, $value);
            }
        }
        $model = $this->model->get($columns);
        $this->resetModel();
        return $model;
    }

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhereFirst(array $where, $columns = ['*'])
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, $value);
            }
        }
        $model = $this->model->firstOrFail($columns);
        $this->resetModel();
        return $model;
    }

    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    /**
     * Load relations
     *
     * @param array|string $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * Load relations
     *
     * @return $this
     */
    public function withTrashed()
    {
        $this->model = $this->model->withTrashed();

        return $this;
    }
    /**
     * Load relations
     *
     * @return $this
     */
    public function onlyTrashed()
    {
        $this->model = $this->model->onlyTrashed();

        return $this;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $post = $this->find($id);
        $post->delete();
        return true;
    }

    /**
     * @param array $attributes
     * @return mixed
     *
     */
    public function create(array $attributes)
    {
        $model = $this->model->newInstance($this->compareAttributes($attributes));
        $model->save();
        return $model;
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param $id
     *
     * @return mixed
     * 
     */
    public function update(array $attributes, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->fill($this->compareAttributes($attributes));
        $model->save();
        return $model;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 5, $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function select($columns = ['*'])
    {
        return $this->model->select($columns);
    }

    /**
     * Compare data before submit
     * 
     * @param mixed $attributes
     * @return array
     * @author Means
     */
    public function compareAttributes($attributes) : array
    {
        unset($attributes['_token']);
        unset($attributes['submit']);
        $data = [];
        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            if ($value === 'on') {
                $value = 1;
            }
            $data[$key] = $value;
        }
        return $data;
    }
}
