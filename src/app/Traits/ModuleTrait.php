<?php

namespace Core\app\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Core\app\Repositories\Contracts\AdminMenuInterface;

Trait ModuleTrait
{
    /**
     * Get path stub
     *
     * @return string
     */
    public function pathStub(): string
	{
		return core_path('app/Supports/stubs');
	}

    /**
     * Generate FormRequest
     *
     * @param $config
     */
    public function createFormRequest($config)
	{
        info("Creating FormRequest...");
        $module = $this;
        $stub = file_get_contents($this->pathStub() . "/request.stub");
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        $stub = str_replace("__data_request__", $this->getFieldRuleValidate($module), $stub);
        file_put_contents(core_path('app/Http/Requests/Admin/' . $config['model_name'] . "Request.php"), $stub);
	}

    /**
     * Generate controller
     *
     * @param $config
     */
    public function createController($config)
	{
        info("Creating controller...");
        $stub = file_get_contents($this->pathStub() . "/controller.stub");
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        $stub = str_replace("__variable__", $config['variable'], $stub);
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__module_name__", $config['module_name'], $stub);
        file_put_contents(core_path('app/Http/Controllers/Admin/' . $config['model_name'] . "Controller.php"), $stub);
	}

    /**
     * Generate DataTable service
     *
     * @param $config
     */
    public function createDataTable($config)
    {
        $module = $this;
        info("Creating data table...");
        $stub = file_get_contents($this->pathStub() . "/table/datatable.stub");
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        $stub = str_replace("__variable__", $config['variable'], $stub);
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__column_field__", $this->getAllFieldTables($module), $stub);
        file_put_contents(core_path('app/DataTables/' . $config['model_name'] . "DataTable.php"), $stub);
    }

    /**
     * Generate Model
     *
     * @param $config
     */
    public function createModel($config)
    {
        $module = $this;
        info("Creating model...");
        $stub = file_get_contents($this->pathStub() . "/model.stub");
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__fillable__", $this->getModuleFields($module), $stub);
        file_put_contents(core_path('app/Models/' . $config['model_name'] . ".php"), $stub);
    }

    /**
     * Generate View
     *
     * @param $config
     */
    public function createViews($config)
    {
        $module = $this;
        info("Creating views...");
        // Create Folder
        @mkdir(core_path("resources/views/admin/" . $config['db_table_name']), 0777, true);

        // ============================ Listing / Index ============================
        $stub = file_get_contents($this->pathStub() . "/views/index.blade.stub");
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__module_label__", $config['module_label'], $stub);
        file_put_contents(core_path('resources/views/admin/' . $config['db_table_name'] . '/index.blade.php'), $stub);

        $inputFields = "";
        foreach ($module->moduleFields as $field) {
            $inputFields .= "\t\t\t\t\t\t@mean_input($" . "module, '" . $field['column_name'] . "')\n";
        }
        $inputFields = trim($inputFields);
        // ============================ Listing / create ============================
        $stub = file_get_contents($this->pathStub() . "/views/create.blade.stub");
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__module_label__", $config['module_label'], $stub);
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__variable__", $config['variable'], $stub);
        $stub = str_replace("__fields_input__", $inputFields, $stub);
        file_put_contents(core_path('resources/views/admin/' . $config['db_table_name'] . '/create.blade.php'), $stub);

        // ============================ Listing / edit ============================
        $stub = file_get_contents($this->pathStub() . "/views/edit.blade.stub");
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__module_label__", $config['module_label'], $stub);
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__variable__", $config['variable'], $stub);
        $stub = str_replace("__fields_input__", $inputFields, $stub);
        file_put_contents(core_path('resources/views/admin/' . $config['db_table_name'] . '/edit.blade.php'), $stub);
    }

    /**
     * Append route crud
     *
     * @param $config
     */
    public function appendRoutes($config)
    {
        info("Appending routes...");
        $stub = file_get_contents($this->pathStub() . "/routes.stub");
        $stub = str_replace("__module_name__", $config['module_name'], $stub);
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);

        $routesFile = core_path('routes/web.php');
        $routeArray = file($routesFile);
        $lastKey = array_key_last($routeArray);
        $content = $routeArray[$lastKey - 1] . $routeArray[$lastKey];
        $contents = file_get_contents($routesFile);
        $contents = str_replace($content, $stub, $contents);
        file_put_contents($routesFile, $contents);
    }

    /**
     * Generate interface module
     *
     * @param $config
     */
    public function createContract($config)
    {
        info("Creating interface...");
        $stub = file_get_contents($this->pathStub() . "/repositories/contract.stub");
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        file_put_contents(core_path('app/Repositories/Contracts/' . $config['model_name'] . "Interface.php"), $stub);
    }

    /**
     * Generate Eloquent module
     *
     * @param $config
     */
    public function createEloquent($config)
    {
        info("Creating eloquent...");
        $stub = file_get_contents($this->pathStub() . "/repositories/eloquent.stub");
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        file_put_contents(core_path('app/Repositories/Eloquent/' . $config['model_name'] . "Eloquent.php"), $stub);
    }

    /**
     * Append bind Interface Eloquent
     *
     * @param $config
     */
    public function appendProvider($config)
    {
        info("Creating appendProvider...");
        $stub = file_get_contents($this->pathStub() . "/repositories/appendProvider.stub");
        $stub = str_replace("__model_class_name__", $config['model_name'], $stub);
        $providers = core_path('app/Providers/RepositoryServiceProvider.php');
        $providerArray = file($providers);
        $lastKey = array_key_last($providerArray);
        $content = $providerArray[$lastKey - 1] . $providerArray[$lastKey];
        $contents = file_get_contents($providers);
        $contents = str_replace($content, $stub, $contents);
        file_put_contents($providers, $contents);
	}

    /**
     * Get all field column
     *
     * @param $module
     * @return string
     */
    public function getModuleFields($module)
    {
        $fields = '';
        foreach ($module->moduleFields as $key => $field) {
            if (count($module->moduleFields) === $key + 1) {
                $fields .= "'" . $field->column_name . "',";
            } else {
                $fields .= "'" . $field->column_name . "',\n\t\t";
            }
        }
        return $fields;
	}

    /**
     * Get all field table
     *
     * @param $module
     * @return string
     */
    public function getAllFieldTables($module)
    {
        $fields = '';
        foreach ($module->moduleFields as $key => $field) {
            $fields .= "'$field->column_name' => [
                'name' => '$field->column_name',
                'title' => '$field->label',
                'class' => '',
            ],
            ";
        }
        return $fields;
    }

    /**
     * Generate migrations module
     *
     * @param $config
     */
    public function generateMigration($config)
    {
        $module = $this;
        $migrateName = $this->deleteMigrateBeforeUpdate();
        $migrationName = 'create_'. $config['db_table_name'] .'_table';
        $migrationFileName = date("Y_m_d_His_") . $migrationName . ".php";
        if (!empty($migrateName)) {
            $migrationFileName = $migrateName;
        }
        $migrationClassName = ucfirst(Str::camel($migrationName));

        $stub = file_get_contents($this->pathStub() . "/migration.stub");

        $stub = str_replace("__migration_class_name__", $migrationClassName, $stub);
        $stub = str_replace("__db_table_name__", $config['db_table_name'], $stub);
        $stub = str_replace("__field_migrate__", $this->getColumnFieldMigration($module), $stub);
        file_put_contents(core_path('database/migrations/' . $migrationFileName), $stub);
        $migration = str_replace('.php', '', $migrationFileName);
        $migrate = DB::table('migrations')->where('migration', $migration)->first();
        if (!$migrate) {
            DB::table('migrations')->insert([
                'migration' => $migration,
                'batch' => 1,
            ]);
        }
    }

    /**
     * Get all field rule validate
     *
     * @param $module
     * @return string
     */
    public function getFieldRuleValidate($module): string
    {
        $fields = '';
        $fieldTypes = getModuleFieldTypes();
        $param = Str::singular($module->name_db);
        foreach ($module->moduleFields as $key => $field) {
            $fieldType = $fieldTypes[$field->module_field_type_id];
            $var = "'" . $field->column_name . "' => ";
            $min = $field->minlength ? 'min:' . $field->minlength . '|' : '';
            $max = $field->maxlength ? 'max:' . $field->maxlength : '';
            $required = $field->required ? 'required|' : 'nullable|';
            switch ($fieldType) {
                case 'Address':
                case 'Editor':
                    $var .= "'" . $required . $min . $max;
                    break;
                case 'Radio':
                case 'Dropdown':
                    $var .= "'" . $required;
                    if (is_string($field->popup_val) && startsWith($field->popup_val, "@")) {
                        $var .= 'exists:' . str_replace('@', '', $field->popup_val) . ',id';
                    }
                    $popup_val = json_decode($field->popup_val);
                    if (is_array($popup_val)) {
                        $var .= 'in:' . implode(',', $popup_val);
                    }
                    break;
                case 'Boolean':
                    $var .= "'" . $required . 'in:on';
                    break;
                case 'Currency':
                case 'Decimal':
                case 'Float':
                    $var .= "'" . $required . 'numeric|' . $min . $max;
                    break;
                case 'Date':
                    $var .= "'" . $required . $min . $max . '|date';
                    if ($field->unique === 1) {
                        $var .= '|unique:' . $module->name_db . ',' . $field->column_name . ",' . " . '$this->' . $param;
                    }
                    break;
                case 'DateTime':
                    $var .= "'" . $required . $min . $max;
                    if ($field->unique === 1) {
                        $var .= '|unique:' . $module->name_db . ',' . $field->column_name . ",' . " . '$this->' . $param;
                    }
                    $var .= '|date_format:Y-m-d H:i:s';
                    break;
                case 'Email':
                    $var .= "'" . $required . 'email:rfc,dns|' . $min . $max;
                    if ($field->unique === 1) {
                        $var .= '|unique:' . $module->name_db . ',' . $field->column_name . ",' . " . '$this->' . $param;
                    }
                    break;
                case 'File':
                    $var .= "'" . $required . 'max:255';
                    break;
                case 'Integer':
                    $var .= "'" . $required . $min . $max . '|digits:20';
                    if ($field->unique === 1) {
                        $var .= '|unique:' . $module->name_db . ',' . $field->column_name . ",' . " . '$this->' . $param;
                    }
                    break;
                case 'Mobile':
                case 'String':
                    $var .= "'" . $required . $min . $max;
                    if ($field->unique === 1) {
                        $var .= '|unique:' . $module->name_db . ',' . $field->column_name . ",' . " . '$this->' . $param;
                    }
                    break;
                case 'MultiSelect':
                case 'Checkbox':
                    $var .= "'" . $required . 'array|';
                    if (is_string($field->popup_val) && startsWith($field->popup_val, "@")) {
                        $var .= 'exists:' . str_replace('@', '', $field->popup_val) . ',id';
                    }
                    $popup_val = json_decode($field->popup_val);
                    if (is_array($popup_val)) {
                        $var .= 'in:' . implode(',', $popup_val);
                    }
                    break;
                case 'Password':
                    $var .= "'" . $required . $min . $max . "|confirmed";
                    break;
                case 'URL':
                    $var .= "'" . $required . $min . $max . '|url';
                    break;
                case 'TagInput':
                    $var .= "'" . $required;
                    $popup_val = json_decode($field->popup_val);
                    if (is_array($popup_val)) {
                        $var .= 'in:' . implode(',', $popup_val);
                    }
                    break;
            }
            if ($field->unique === 1 && count($module->moduleFields) === $key + 1) {
                $fields .= $var . ",";
            } else if ($field->unique === 1) {
                $fields .= $var . ",\n\t\t\t";
            } else if (count($module->moduleFields) === $key + 1) {
                $fields .= $var . "',";
            } else {
                $fields .= $var . "',\n\t\t\t";
            }
        }
        return $fields;
    }

    /**
     * Get all column migration by module
     *
     * @param $module
     * @return string
     */
    public function getColumnFieldMigration($module)
    {
        $fields = '';
        $fieldTypes = getModuleFieldTypes();
        foreach ($module->moduleFields as $key => $field) {
            $fieldType = $fieldTypes[$field->module_field_type_id];
            $var = '';
            switch ($fieldType) {
                case 'Textarea':
                case 'Address':
                    if ($field->maxlength === 0) {
                        $var = '$table->text("' . $field->column_name . '")';
                    } else {
                        $var = '$table->string("' . $field->column_name .'", ' . $field->maxlength .')';
                    }
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value .'")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    break;
                case 'Radio':
                case 'Checkbox':
                    if ($field->popup_val === '') {
                        if (is_int($field->default_value)) {
                            $var = '$table->unsignedBigInteger("' . $field->column_name . '")->default("' . $field->default_value . '")';
                            break;
                        } elseif (is_string($field->default_value)) {
                            $var = '$table->string("' . $field->column_name . '")->default("' . $field->default_value . '")';
                            break;
                        }
                    }
                    if (is_string($field->popup_val) && startsWith($field->popup_val, "@")) {
                        $var = '$table->unsignedBigInteger("' . $field->column_name . '")';
                        break;
                    }
                    $popup_val = json_decode($field->popup_val);
                    if (is_array($popup_val)) {
                        $var = '$table->string("' . $field->column_name . '")';
                        if ($field->default_value !== '') {
                            $var .= '->default("' . $field->default_value . '")';
                        }
                        if ($field->required === 0) {
                            $var .= '->nullable()';
                        }
                    }
                    if (is_object($popup_val)) {
                        $var = '$table->unsignedBigInteger("' . $field->column_name . '")';
                    }
                    break;
                case 'Boolean':
                    $var = '$table->boolean("' . $field->column_name . '")';
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value .'")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    break;
                case 'Currency':
                    $var = '$table->double("' . $field->column_name . '", 15, 2)';
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    break;
                case 'Date':
                    $var = '$table->date("' . $field->column_name . '")';
                    if ($field->default_value !== '' && !startsWith($field->default_value, "date")) {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->unique === 1) {
                        $var .= '->unique()';
                    }
                    break;
                case 'DateTime':
                    $var = '$table->timestamp("' . $field->column_name . '")';
                    if ($field->default_value !== '' && !startsWith($field->default_value, "date")) {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->unique === 1) {
                        $var .= '->unique()';
                    }
                    break;
                case 'Decimal':
                    $var = '$table->decimal("' . $field->column_name . '", 15, 3)';
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    break;
                case 'Dropdown':
                    if ($field->popup_val === '') {
                        if (is_int($field->default_value)) {
                            $var = '$table->unsignedBigInteger("' . $field->column_name . '")->default("' . $field->default_value . '")';
                            break;
                        } elseif (is_string($field->default_value)) {
                            $var = '$table->string("' . $field->column_name . '")->default("' . $field->default_value . '")';
                            break;
                        }
                    }
                    $popup_val = json_decode($field->popup_val);
                    if (startsWith($field->popup_val, "@")) {
                        $foreignTableName = str_replace("@", "", $field->popup_val);
                        $var = '$table->bigInteger("' . $field->column_name . '")->unsigned()';
                        if ($field->default_value !== '') {
                            $var .= '->default("' . $field->default_value . '")';
                        }
                        $var .= ";\n\t\t\t" . '$table->foreign("' . $field->column_name . '")->references("id")->on("' . $foreignTableName . '")';
                    } elseif (is_array($popup_val)) {
                        $var .= '$table->string("' . $field->column_name . '")';
                        if ($field->default_value !== '') {
                            $var .= '->default("' . $field->default_value . '")';
                        }
                        if ($field->required === 0) {
                            $var .= '->nullable()';
                        }
                    } elseif (is_object($popup_val)) {
                        $var = '$table->unsignedBigInteger("' . $field->column_name . '")';
                    }
                    break;
                case 'Email':
                    if ($field->maxlength == 0) {
                        $var = '$table->string("' . $field->column_name . '", 100)';
                    } else {
                        $var = '$table->string("' . $field->column_name . '", ' . $field->maxlength . ')';
                    }
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    if ($field->unique === 1) {
                        $var .= '->unique()';
                    }
                    break;
                case 'File':
                    $var = '$table->string("' . $field->column_name . '", 255)';
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    break;
                case 'Float':
                    $var = '$table->float("' . $field->column_name . '")';
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    if ($field->unique === 1) {
                        $var .= '->unique()';
                    }
                    break;
                case 'Editor':
                    $var = '$table->longText("' . $field->column_name . '")';
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    break;
                case 'Integer':
                    $var = '$table->unsignedBigInteger("' . $field->column_name . '")';
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    if ($field->unique === 1) {
                        $var .= '->unique()';
                    }
                    break;
                case 'Mobile':
                    if ($field->maxlength == 0) {
                        $var = '$table->string("' . $field->column_name . '")';
                    } else {
                       $var = '$table->string("' . $field->column_name . '", ' . $field->maxlength . ')';
                    }
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    if ($field->unique === 1) {
                        $var .= '->unique()';
                    }
                    break;
                case 'MultiSelect':
                    $var = '$table->string("' . $field->column_name . '", 256)';
                    if ($field->default_value !== '') {
                        $var .= "->default('" . $field->default_value . "')";
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    break;
                case 'Password':
                case 'URL':
                    if ($field->maxlength == 0) {
                        $var = '$table->string("' . $field->column_name . '")';
                    } else {
                        $var = '$table->string("' . $field->column_name . '", ' . $field->maxlength . ')';
                    }
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    break;
                case 'String':
                    if ($field->maxlength === 0) {
                        $var = '$table->string("' . $field->column_name . '")';
                    } else {
                        $var = '$table->string("' . $field->column_name . '", ' . $field->maxlength . ')';
                    }
                    if ($field->default_value !== '') {
                        $var .= '->default("' . $field->default_value . '")';
                    }
                    if ($field->required === 0) {
                        $var .= '->nullable()';
                    }
                    if ($field->unique === 1) {
                        $var .= '->unique()';
                    }
                    break;
                case 'TagInput':
                    $var = '$table->string("' . $field->column_name . '", 1000)';
                    if ($field->default_value !== '') {
                        $var .= "->default('" . $field->default_value . "')";
                    }
                    if ($field->required === 0) {
                        $var .= "->nullable()";
                    }
                    break;
            }
            $fields .= $var . ";
            ";
        }
        return $fields;
    }

    /**
     * Delete migration before update migrate
     *
     */
    public function deleteMigrateBeforeUpdate()
    {
        $module = $this;
        DB::table('migrations')
            ->where('migration', 'like', '%_create_' . $module->name_db . '_table%')
            ->delete();
        $folders = scanFolder(core_path('database/migrations'));
        foreach ($folders as $folder) {
            if (endsWith($folder, '_create_' . $module->name_db . '_table.php')) {
                File::delete(core_path('database/migrations/' . $folder));
                return $folder;
            }
            continue;
        }
        return '';
    }

    /**
     * @return array
     */
    public function generateConfig()
    {
        $module = $this;
        $config = [];
        $icon = $module->icon;
        $name = $module->name;
        $config['model_name'] = $module->model;
        $config['db_table_name'] = $module->name_db;
        $config['variable'] = Str::camel(Str::singular($name));
        $config['icon'] = $icon;
        $config['module_name'] = $module->name;
        $config['module_label'] = $module->label;
        $config['controller_name'] = $module->controller;
        $config['module'] = $module;
        return $config;
    }

    /**
     * Delete Module
     *
     * @return void [type]
     * @author Means
     */
    public function deleteModule()
    {
        $module = $this;
        //Delete Menu
        app(AdminMenuInterface::class)->deleteMenuByModule($module->name);
		// Delete Resource Views directory
		File::deleteDirectory(core_path('resources/views/admin/' . $module->name_db));
        // Delete Form Request
		File::delete(core_path('app/Http/Requests/Admin/' . $module->model . 'Request.php'));
		// Delete Controller
		File::delete(core_path('app/Http/Controllers/Admin/' . $module->controller . '.php'));
		// Delete Model
		File::delete(core_path('app/Models/' . $module->model . '.php'));
        // Delete DataTable service
        File::delete(core_path('app/DataTables/' . $module->model . 'DataTable.php'));
        // Delete Interface
        File::delete(core_path('app/Repositories/Contracts/' . $module->model . 'Interface.php'));
        // Delete Eloquent
        File::delete(core_path('app/Repositories/Eloquent/' . $module->model . 'Eloquent.php'));
		// delete migration file
        $this->deleteMigrateBeforeUpdate();
		// Delete Admin Routes
        $routePath = core_path('routes/web.php');
        $lineNumberRoute = $this->getLineNumberContent($routePath, $module->model . "Controller");
        if ($lineNumberRoute !== -1) {
            $this->replaceContentRouter($routePath, $lineNumberRoute);
        }
        // Delete append bind Interface
        $providerPath = core_path('app/Providers/RepositoryServiceProvider.php');
        $lineNumberProvider = $this->getLineNumberContent($providerPath, $module->model . "Interface");
        if ($lineNumberProvider !== -1) {
            $this->replaceContentProvider($providerPath, $lineNumberProvider);
        }
		// Delete record in migrations Table
        DB::table('migrations')
            ->where('migration', 'like', '%_create_' . $module->name_db . '_table%')
            ->delete();
        // Delete table
        Schema::dropIfExists($module->name_db);
		//Delete Module
		$module->delete();
    }

    /**
     * Change file RepositoryProvider when remove module
     *
     * @param $fileName
     * @param $lineNumber
     */
    public function replaceContentProvider($fileName, $lineNumber)
    {
        $lines = file($fileName);
        $content = $lines[$lineNumber - 1] . $lines[$lineNumber] . $lines[$lineNumber + 1] . $lines[$lineNumber + 2];
        $fileData = file_get_contents($fileName);
        $fileData = str_replace($content, '', $fileData);
        file_put_contents($fileName, $fileData);
    }

    /**
     * Change file Route when remove module
     *
     * @param mixed $fileName
     * @param mixed $lineNumber
     * @return void
     * @author Means
     */
    public function replaceContentRouter($fileName, $lineNumber)
    {
        $lines = file($fileName);
        $content = $lines[$lineNumber - 2] . $lines[$lineNumber - 1] . $lines[$lineNumber];
        $fileData = file_get_contents($fileName);
        $fileData = str_replace($content, '', $fileData);
        file_put_contents($fileName, $fileData);
	}

    /**
     * Get line Number file content
     *
     * @param mixed $fileName
     * @param mixed $str
     * @return int
     * @author
     * @Means
     */
    public function getLineNumberContent($fileName, $str)
    {
        $lines = file($fileName);
		foreach ($lines as $lineNumber => $line) {
			if (strpos($line, $str) !== false) {
                return $lineNumber;
			}
		}
		return -1;
	}
}
