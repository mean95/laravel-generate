<?php


namespace Core\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Core\Models\ModuleField;
use Illuminate\Container\Container as Application;
use Core\Repositories\Contracts\ModuleFieldInterface;
use Core\Traits\ModuleFieldTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Core\Repositories\Contracts\ModuleInterface;

class ModuleFieldEloquent extends BaseEloquent implements ModuleFieldInterface
{

    use ModuleFieldTrait;

    /**
     * @var ModuleInterface
     */
    private $moduleRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ModuleField::class;
    }

    public function __construct(
        Application $app,
        ModuleInterface $moduleRepository
    )
    {
        parent::__construct($app);
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Create module fields of module
     * @param mixed $attributes
     * @return mixed
     * @author Means
     */
    public function store($attributes)
    {
        $field = $this->model->where('module_id', $attributes['module_id'])
            ->where('column_name', $attributes['column_name'])->first();
        if ($field) {
            return false;
        }
        try {
            $field = $this->create($this->getDataFields($attributes));
            $module = $this->moduleRepository->find($attributes['module_id']);
            if (!Schema::hasTable($module->name_db)) {
                Schema::create($module->name_db, function($table) {
                    $table->id();
                    $table->timestamps();
                    $table->softDeletes();
                });
            }
            Schema::table($module->name_db, function($table) use ($field, $module) {
                $this->createFieldSchema($table, $field, $module);
            });
            return $field;
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return false;
        }
    }

    /**
     * Update module field of module
     *
     * @param mixed $attributes
     * @param mixed $id
     * @return mixed
     * @author Means
     */
    public function updateField($attributes, $id)
    {
        DB::beginTransaction();
        try {
            $field = $this->find($id);
            $module = $this->moduleRepository->find($attributes['module_id']);

            if ($field->column_name !== $attributes['column_name']) {
                Schema::table($module->name_db, function ($table) use ($field, $attributes) {
                    $table->renameColumn($field->column_name, $attributes['column_name']);
                });
            }

            $field = $this->update($this->getDataFields($attributes), $id);

            Schema::table($module->name_db, function ($table) use ($field, $module) {
                $this->updateFieldSchema($table, $field, $module);
            });
            DB::commit();
            return $field;
        } catch (\Throwable $th) {
            DB::rollback();
            logger($th->getMessage());
            return false;
        }

    }

    /**
     * Handle data module fields
     *
     * @param mixed $attributes
     * @return array
     * @author Means
     */
    public function getDataFields($attributes)
    {
        $dataFields = [];
        $dataFields['column_name'] = Str::slug(strtolower($attributes['column_name']), '_');
        $dataFields['label'] = $attributes['label'];
        $dataFields['module_id'] = $attributes['module_id'];
        $dataFields['module_field_type_id'] = $attributes['module_field_type_id'];
        $dataFields['unique'] = !empty($attributes['unique']) ? 1 : 0;
        $dataFields['required'] = !empty($attributes['required']) ? 1 : 0;
        $dataFields['default_value'] = !empty($attributes['default_value']) ? $attributes['default_value'] : '';
        $dataFields['minlength'] = !empty($attributes['minlength']) ? $attributes['minlength'] : 0;
        if ($attributes['module_field_type_id'] == 5) {
            $dataFields['default_value'] = date('Y-m-d');
        }
        if ($attributes['module_field_type_id'] == 6) {
            $dataFields['default_value'] = date('Y-m-d H:i:s');
        }
        if (in_array($attributes['module_field_type_id'], config('core.default_value_int'))) {
            $dataFields['default_value'] = $attributes['default_value'] ?? 1;
        }
        if ($attributes['module_field_type_id'] == 3) {
            $dataFields['default_value'] = $attributes['default_value'] ?? 0;
        }
        if (empty($attributes['maxlength'])) {
            $maxlength = 255;
            if (in_array($attributes['module_field_type_id'], config('core.maxlength_field'))) {
                $maxlength = 11;
            }
            if (in_array($attributes['module_field_type_id'], config('core.not_max_field'))) {
                $maxlength = 0;
            }
            $dataFields['maxlength'] = $maxlength;
        } else {
            $dataFields['maxlength'] = $attributes['maxlength'];
        }
        if (in_array($attributes['module_field_type_id'], config('core.popup_field'))
            || $attributes['module_field_type_id'] == config('core.tag_input')) {
            if(!empty($attributes['popup_value_type']) && $attributes['popup_value_type'] === "table") {
                $dataFields['popup_val'] = "@".$attributes['popup_val_table'];
            } else {
                $dataFields['popup_val'] = json_encode($attributes['popup_val_list']);
            }
        } else {
            $dataFields['popup_val'] = "";
        }
        return $dataFields;
    }
}
