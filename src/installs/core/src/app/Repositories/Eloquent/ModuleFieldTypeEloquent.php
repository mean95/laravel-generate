<?php


namespace Core\Repositories\Eloquent;


use Illuminate\Support\Facades\DB;
use Core\Models\ModuleFieldType;
use Core\Repositories\Contracts\ModuleFieldTypeInterface;

class ModuleFieldTypeEloquent extends BaseEloquent implements ModuleFieldTypeInterface
{

    public function model()
    {
        return ModuleFieldType::class;
    }

    /**
     * Get all module field types
     * @return array
     * @author Means
     */
    public function getModuleFieldTypes(): array
    {
        $moduleFieldTypes = $this->all(['id', 'name']);
        $moduleFieldTypes = $moduleFieldTypes->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        })->toArray();
        return $moduleFieldTypes ?? [];
    }

    /**
     * Get all module field types with page edit
     * @param $table
     * @param $fieldId
     * @return array
     */
    public function getModuleFieldTypeEdit($table, $fieldId): array
    {
        $moduleFieldTypes = $this->getModuleFieldTypes();
        $moduleFieldTypes = array_diff($moduleFieldTypes, ["DateTime"]);
        $dataModule = DB::table($table)->select('id')->first();
        $arrayFields = ['Address', 'Textarea', 'Email', 'Editor', 'Mobile', 'MultiSelect', 'Password', 'String', 'TagInput', 'URL'];
        if (!empty($moduleFieldTypes[$fieldId])) {
            $arrayFields[] = $moduleFieldTypes[$fieldId];
        }
        return !$dataModule
            ? $moduleFieldTypes
            : collect($moduleFieldTypes)->filter(function ($item) use ($arrayFields) {
                return in_array($item, $arrayFields);
            })->toArray();
    }
}
