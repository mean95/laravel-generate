<?php


namespace Core\app\Repositories\Eloquent;


use Illuminate\Support\Facades\DB;
use Core\app\Models\ModuleFieldType;
use Core\app\Repositories\Contracts\ModuleFieldTypeInterface;

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
     * @return array
     * @author Means
     */
    public function getModuleFieldTypeEdit($table): array
    {
        $moduleFieldTypes = $this->getModuleFieldTypes();
        $moduleFieldTypes = array_diff($moduleFieldTypes, ["DateTime"]);
        $dataModule = DB::table($table)->select('id')->first();
        return !$dataModule
            ? $moduleFieldTypes
            : collect($moduleFieldTypes)->filter(function ($item) {
                return in_array($item, ['Address', 'Textarea', 'Email', 'Editor', 'Mobile', 'MultiSelect', 'Password', 'String', 'TagInput', 'URL']);
            })->toArray();
    }
}
