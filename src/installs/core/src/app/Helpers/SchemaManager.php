<?php

namespace Core\Helpers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SchemaManager
{

    public function __construct()
    {
        DB::connection()->getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * @return array
     * @author Means
     */
    public function listTables(): array
    {
        $tables = $this->connect()->listTables();
        $arrTable = [];
        foreach ($tables as $table) {
            $arrTable[$table->getName()] = $table->getName();
        }
        return $arrTable;
    }

    /**
     * @param $table
     * @return array
     * @author Means
     */
    public function listColumns($table): array
    {
        $columns = $this->connect()->listTableColumns($table);
        $arrColumns = [];
        foreach ($columns as $column) {
            $arrColumns[$column->getName()] = $column->getName();
        }
        return $arrColumns;
    }

    /**
     * @param $table
     * @return array
     * @author Means
     */
    public function listForeignKeys($table): array
    {
        $columns = $this->connect()->listTableForeignKeys($table);
        $arrColumns = [];
        foreach ($columns as $column) {
            array_push($arrColumns, $column->getName());
        }
        return $arrColumns;
    }

    /**
     * @param $table
     * @param $column
     * @return mixed|string
     * @author Means
     */
    public function columnIndex($table, $column)
    {
        $table = $this->listIndexes($table);
        return !empty($table[$column]) ? $table[$column] : '';
    }

    /**
     * @param $table
     * @return array
     */
    public function listIndexes($table): array
    {
        $columns = $this->connect()->listTableIndexes($table);
        $arrColumns = [];
        foreach ($columns as $key => $column) {
            $arrColumns[$key] = $key;
        }
        return $arrColumns;
    }

    /**
     * @return mixed
     */
    public function connect()
    {
       return Schema::getConnection()->getDoctrineSchemaManager();
    }
}
