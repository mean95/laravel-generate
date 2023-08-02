<?php


namespace Core\Repositories\Contracts;


interface ModuleFieldTypeInterface
{
    /**
     * Get all module field types
     * @return array
     * @author Means
     */
    public function getModuleFieldTypes(): array;

    /**
     * Get all module field types with page edit
     * @param $table
     * @param $fieldId
     * @return array
     */
    public function getModuleFieldTypeEdit($table, $fieldId): array;
}
