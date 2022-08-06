<?php


namespace Core\app\Traits;


use Illuminate\Support\Facades\DB;

trait ModuleFieldTrait
{
    /**
     * Create field schema
     * @param $table
     * @param $field
     * @param $module
     * @author Means
     */
    public function createFieldSchema($table, $field, $module)
    {
        $fieldTypes = getModuleFieldTypes();
        $fieldType = $fieldTypes[$field->module_field_type_id];
        $var = '';
        switch ($fieldType) {
            case 'Textarea':
            case 'Address':
                if ($field->maxlength === 0) {
                    $var = $table->text($field->column_name);
                } else {
                    $var = $table->string($field->column_name, $field->maxlength);
                }
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'Radio':
            case 'Checkbox':
            case 'Dropdown':
                if ($field->popup_val === '') {
                    if (is_int($field->default_value)) {
                        $var = $table->unsignedBigInteger($field->column_name)->default($field->default_value);
                        break;
                    }
                    if (is_string($field->default_value)) {
                        $var = $table->string($field->column_name)->default($field->default_value);
                        break;
                    }
                }
                if (is_string($field->popup_val) && startsWith($field->popup_val, "@")) {
                    $foreignTableName = str_replace("@", "", $field->popup_val);
                    $var = $table->unsignedBigInteger($field->column_name);
                    if ($field->default_value !== '') {
                        $var->default($field->default_value);
                    }
                    $table->foreign($field->column_name)->references('id')->on($foreignTableName)->onDelete('cascade');
                }
                $popup_val = json_decode($field->popup_val);
                if (is_array($popup_val)) {
                    $var = $table->string($field->column_name);
                    if ($field->default_value !== '') {
                        $var->default($field->default_value);
                    }
                    if ($field->required === 0) {
                        $var->nullable();
                    }
                }
                if (is_object($popup_val)) {
                    $var = $table->unsignedBigInteger($field->column_name);
                }
                break;
            case 'Boolean':
                $var = $table->boolean($field->column_name);
                $default = !empty($field->default_value) ? true : false;
                $var->default($default);
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'Currency':
                $var = $table->decimal($field->column_name, 15, 2);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'Date':
                $var = $table->date($field->column_name);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                if ($field->unique === 1) {
                    $var->unique();
                }
                break;
            case 'DateTime':
                $var = $table->timestamp($field->column_name);
                if ($field->default_value !== "") {
                    $var->default($field->default_value);
                }
                if ($field->unique === 1) {
                    $var->unique();
                }
                break;
            case 'Decimal':
                $var = $table->decimal($field->column_name, 15, 3);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'Email':
                if ($field->maxlength == 0) {
                    $var = $table->string($field->column_name, 100);
                } else {
                    $var = $table->string($field->column_name, $field->maxlength);
                }
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                if ($field->unique === 1) {
                    $var->unique();
                }
                break;
            case 'File':
                $var = $table->string($field->column_name, 255);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'Float':
                $var = $table->float($field->column_name);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                if ($field->unique === 1) {
                    $var->unique();
                }
                break;
            case 'Editor':
                $var = $table->longText($field->column_name);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'Integer':
                $var = $table->unsignedBigInteger($field->column_name, false);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                if ($field->unique === 1) {
                    $var->unique();
                }
                break;
            case 'Mobile':
                if ($field->maxlength == 0) {
                    $var = $table->string($field->column_name);
                } else {
                    $var = $table->string($field->column_name, $field->maxlength);
                }
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                if ($field->unique === 1) {
                    $var->unique();
                }
                break;
            case 'MultiSelect':
                $var = $table->string($field->column_name, 256);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'Password':
                if ($field->maxlength === 0) {
                    $var = $table->string($field->column_name);
                } else {
                    $var = $table->string($field->column_name, $field->maxlength);
                }
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'String':
                if ($field->maxlength === 0) {
                    $var = $table->string($field->column_name);
                } else {
                    $var = $table->string($field->column_name, $field->maxlength);
                }
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                if ($field->unique === 1) {
                    $var->unique();
                }
                break;
            case 'TagInput':
                $var = $table->string($field->column_name, 1000);
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
            case 'URL':
                if ($field->maxlength === 0) {
                    $var = $table->string($field->column_name);
                } else {
                    $var = $table->string($field->column_name, $field->maxlength);
                }
                if ($field->default_value !== '') {
                    $var->default($field->default_value);
                }
                if ($field->required === 0) {
                    $var->nullable();
                }
                break;
        }
        $columns = schemaManager()->listColumns($module->name_db);
        $columnSlice = array_slice($columns, -4);
        $columnName = reset($columnSlice);
        $var->after($columnName);
    }

    /**
     * Update field scheme
     * @param $table
     * @param $field
     * @param $module
     * @author Means
     */
    public function updateFieldSchema($table, $field, $module)
    {
        $fieldTypes = getModuleFieldTypes();
        $fieldType = $fieldTypes[$field->module_field_type_id];
        $foreign = $module->name_db . "_" . $field->column_name . "_foreign";
        if (in_array($foreign, schemaManager()->listForeignKeys($module->name_db))) {
            DB::statement("ALTER TABLE $module->name_db DROP FOREIGN KEY $foreign");
            DB::statement("ALTER TABLE $module->name_db DROP INDEX $foreign");
        }
        switch ($fieldType) {
            case 'Textarea':
            case 'Address':
                if ($field->maxlength === 0) {
                    $var = $table->text($field->column_name)->change();
                } else {
                    $var = $table->string($field->column_name, $field->maxlength)->change();
                }
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                break;
            case 'Radio':
            case 'Checkbox':
                if ($field->popup_val === '') {
                    if (is_int($field->default_value)) {
                        $var = $table->unsignedBigInteger($field->column_name)->change();
                        $this->setDefaultValue($field->default_value, $var);
                        break;
                    }
                    if (is_string($field->default_value)) {
                        $var = $table->string($field->column_name)->change();
                        $this->setDefaultValue($field->default_value, $var);
                        break;
                    }
                }
                $popup_val = json_decode($field->popup_val);
                if (startsWith($field->popup_val, "@")) {
                    $foreignTableName = str_replace("@", "", $field->popup_val);
                    $var = $table->unsignedBigInteger($field->column_name)->change();
                    $defaultValue = is_int($field->default_value) ? $field->default_value : 1;
                    $var->default($defaultValue);
                    $table->foreign($field->column_name)->references('id')->on($foreignTableName)->onDelete('cascade');
                }
                if (is_array($popup_val)) {
                    $var = $table->string($field->column_name)->change();
                    $this->setDefaultValue($field->default_value, $var);
                    $this->setRequiredValue($field->required, $var);
                }
                if (is_object($popup_val)) {
                    $table->unsignedBigInteger($field->column_name)->change();
                }
                break;
            case 'Boolean':
                $var = $table->boolean($field->column_name)->change();
                $default = !empty($field->default_value) ? 1 : 0;
                $var->default($default);
                $this->setRequiredValue($field->required, $var);
                break;
            case 'Currency':
                $var = $table->decimal($field->column_name, 15, 2)->change();
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                break;
            case 'Date':
                $var = $table->date($field->column_name)->change();
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                $this->setUniqueValue($field, $var, $module, $table);
                break;
            case 'Decimal':
                $var = $table->decimal($field->column_name, 15, 3)->change();
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                break;
            case 'Dropdown':
                if ($field->popup_val === '') {
                    if (is_int($field->default_value)) {
                        $var = $table->unsignedBigInteger($field->column_name)->change();
                        $this->setDefaultValue($field->default_value, $var);
                        break;
                    } elseif (is_string($field->default_value)) {
                        $var = $table->string($field->column_name)->change();
                        $this->setDefaultValue($field->default_value, $var);
                        break;
                    }
                }
                $popup_val = json_decode($field->popup_val);
                if (startsWith($field->popup_val, "@")) {
                    $foreignTableName = str_replace("@", "", $field->popup_val);
                    $var = $table->unsignedBigInteger($field->column_name)->change();
                    $defaultValue = is_int($field->default_value) ? $field->default_value : 1;
                    $var->default($defaultValue);
                    $table->foreign($field->column_name)->references('id')->on($foreignTableName)->onDelete('cascade');
                }
                if (is_array($popup_val)) {
                     $var = $table->string($field->column_name)->change();
                     $this->setDefaultValue($field->default_value, $var);
                     $this->setRequiredValue($field->required, $var);
                }
                if (is_object($popup_val)) {
                    $var = $table->unsignedBigInteger($field->column_name)->change();
                }
                break;
            case 'Email':
                if ($field->maxlength == 0) {
                    $var = $table->string($field->column_name, 100)->change();
                } else {
                   $var = $table->string($field->column_name, $field->maxlength)->change();
                }
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                $this->setUniqueValue($field, $var, $module, $table);
                break;
            case 'File':
                $var = $table->string($field->column_name, 255)->change();
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                break;
            case 'Float':
                $var = $table->float($field->column_name)->change();
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                $this->setUniqueValue($field, $var, $module, $table);
                break;
            case 'Editor':
                $var = $table->longText($field->column_name)->change();
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                break;
            case 'Integer':
                $var = $table->unsignedBigInteger($field->column_name)->change();
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                $this->setUniqueValue($field, $var, $module, $table);
                break;
            case 'Mobile':
                if ($field->maxlength == 0) {
                    $var = $table->string($field->column_name)->change();
                } else {
                    $var = $table->string($field->column_name, $field->maxlength)->change();
                }
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                $this->setUniqueValue($field, $var, $module, $table);
                break;
            case 'MultiSelect':
                 $var = $table->string($field->column_name, 255)->change();
                 $this->setDefaultValue($field->default_value, $var);
                 $this->setRequiredValue($field->required, $var);
                break;
            case 'Password':
            case 'URL':
                if ($field->maxlength == 0) {
                     $var = $table->string($field->column_name)->change();
                } else {
                    $var = $table->string($field->column_name, $field->maxlength)->change();
                }
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                break;
            case 'String':
                if ($field->maxlength === 0) {
                     $var = $table->string($field->column_name)->change();
                } else {
                     $var = $table->string($field->column_name, $field->maxlength)->change();
                }
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                $this->setUniqueValue($field, $var, $module, $table);
                break;
            case 'TagInput':
                $var = $table->string($field->column_name, 1000)->change();
                $this->setDefaultValue($field->default_value, $var);
                $this->setRequiredValue($field->required, $var);
                break;
        }
    }

    /**
     * @param $defaultValue
     * @param $var
     */
    public function setDefaultValue($defaultValue, $var)
    {
        if ($defaultValue === '') {
            $var->default(NULL);
        } else {
            $var->default($defaultValue);
        }
    }

    /**
     * @param $required
     * @param $var
     */
    public function setRequiredValue($required, $var)
    {
        if ($required === 0) {
            $var->nullable();
        } else {
            $var->nullable(false);
        }
    }

    /**
     * @param $field
     * @param $var
     * @param $module
     * @param $table
     */
    public function setUniqueValue($field, $var, $module, $table)
    {
        $uniqueKey = $module->name_db . '_'. strtolower($field->column_name) . '_unique';
        if (!$field->unique) {
            $table->dropUnique($uniqueKey);
        } else {
            if (!in_array($uniqueKey, schemaManager()->listIndexes($module->name_db))) {
                $var->unique();
            }
        }
    }

    /**
     * @param $table
     * @return bool
     */
    public function checkExistsDataInModule($nameDB): bool
    {
        return DB::table($nameDB)->count() > 0;
    }
}
