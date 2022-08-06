<?php

namespace Core\app\Repositories\Contracts;

interface BaseInterface
{
    /**
     * @param array $columns
     * @return mixed
     * @author Means
     */
    public function all($columns = ['*']);

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * @param array $attributes
     * @param array $values
     * @return mixed
     * @author Means
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     * @author Means
     */
    public function findByField($field, $value, $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByFirst($field, $value, $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhereFirst(array $where, $columns = ['*']);

    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc');


    /**
     * Load relations
     * @param array|string $relations
     * @return $this
     */
    public function with($relations);

    /**
     * Load relations
     * @return $this
     */
    public function withTrashed();

    /**
     * Load relations
     * @return $this
     */
    public function onlyTrashed();

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*']);


    /**
     * @param array $columns
     * @return mixed
     */
    public function select($columns = ['*']);
    /**
     * Save a new entity in repository
     * @param array $attributes
     * @return mixed
     */

    public function create(array $attributes);

    /**
     * Update a entity in repository by id
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id);
}
