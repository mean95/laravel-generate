<?php


namespace Core\app\Repositories\Contracts;


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
     * @return array
     * @author Means
     */
    public function getModuleFieldTypeEdit($table): array;
}
