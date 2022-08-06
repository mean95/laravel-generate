<?php

namespace Core\app\Helpers;


use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Core\app\Repositories\Contracts\ModuleInterface;

class FormMaker
{

    /**
	  * Print form using blade directive @mean_form
	 **/
	public function form($module, $fields = [])
	{
		if (count($fields) == 0) {
			$fields = array_keys($module->module_fields);
		}
		$output = "";
		foreach ($fields as $field) {
			$output .= $this->input($module, $field);
		}
		return $output;
	}

    /**
     * Render form Input
     *
     * @param $module
     * @param $fieldName
     * @param null $default
     * @param array $params
     * @return string
     * @throws \Throwable
     * @author Means
     */
    public function input($module, $fieldName, $default = null, $params = [])
    {
        $label = $module->module_fields[$fieldName]['label'];
        $fieldTypeId = $module->module_fields[$fieldName]['module_field_type_id'];
        $unique = $module->module_fields[$fieldName]['unique'];
        $defaultValue = $module->module_fields[$fieldName]['default_value'];
        $minlength = $module->module_fields[$fieldName]['minlength'];
        $maxlength = $module->module_fields[$fieldName]['maxlength'];
        $required = $module->module_fields[$fieldName]['required'];
        $popupVal = $module->module_fields[$fieldName]['popup_val'];
        $row = $module->row;

        $fieldType = getModuleFieldTypes()[$fieldTypeId];
        $params['class'] = $params['class'] ?? 'form-control form-control-sm';
        $params['placeholder'] = empty($params['placeholder']) ? 'Enter ' . $label : $params['placeholder'];
        $params['minlength'] = empty($params['minlength']) ? $minlength : $params['minlength'];
        $params['maxlength'] = empty($params['maxlength']) ? $maxlength : $params['maxlength'];
        if ($required === 1) {
            $params['required'] = true;
        }
        if ($unique && !isset($params['unique'])) {
            $params['data-unique'] = "true";
            $params['data-field-id'] = $module->module_fields[$fieldName]['id'];
            $params['data-prefix'] = getPrefix();
            $params['data-row-id'] = $row ? $row->id : 0;
        }
        $options['prefix'] = getPrefix();
        $options['field_id'] = $module->module_fields[$fieldName]['id'];
        $options['required_ast'] = $required === 1 ? ' *' : '';
        $options['default_value'] = $row ? $row->$fieldName : $default ?? $defaultValue;
        $options['label'] = $label;

        $html = '';
        switch ($fieldType) {
            case 'Address':
                $html .= $this->inputAddress($fieldName, $options, $params);
                break;
            case 'Checkbox':
                $html .= $this->inputCheckbox($fieldName, $popupVal, $options, $params);
                break;
            case 'Boolean':
                $html .= $this->inputBoolean($fieldName, $options, $params);
                break;
            case 'Currency':
                $html .= $this->inputCurrency($fieldName, $options, $params);
                break;
            case 'Date':
                $html .= $this->inputDate($fieldName, $options, $params);
                break;
            case 'DateTime':
                $html .= $this->inputDateTime($fieldName, $options, $params);
                break;
            case 'Decimal':
                $html .= $this->inputDecimal($fieldName, $options, $params);
                break;
            case 'Dropdown':
                $html .= $this->inputDropdown($fieldName, $popupVal, $options, $params);
                break;
            case 'Email':
                $html .= $this->inputEmail($fieldName, $options, $params);
                break;
            case 'File':
                $html .= $this->inputFile($fieldName, $options, $params);
                break;
            case 'Float':
                $html .= $this->inputFloat($fieldName, $options, $params);
                break;
            case 'Editor':
                $html .= $this->inputEditor($fieldName, $options, $params);
                break;
            case 'Integer':
                $html .= $this->inputInteger($fieldName, $options, $params);
                break;
            case 'MultiSelect':
                $html .= $this->inputMultiSelect($fieldName, $popupVal, $options, $params);
                break;
            case 'Password':
                $html .= $this->inputPassword($fieldName, $options, $params);
                break;
            case 'Radio':
                $html .= $this->inputRadio($fieldName, $popupVal, $options, $params);
                break;
            case 'String':
            case 'Mobile':
                $html .= $this->inputString($fieldName, $options, $params);
                break;
            case 'TagInput':
                $html .= $this->inputTagInput($fieldName, $options, $params);
                break;
            case 'Textarea':
                $html .= $this->inputTextarea($fieldName, $options, $params);
                break;
            case 'URL':
                $html .= $this->inputUrl($fieldName, $options, $params);
                break;
        }
        return $html;
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputAddress($fieldName, $options, array $params)
    {
        $params['cols'] = 30;
        $params['rows'] = 3;
        return view('core::admin.common.input_forms.input_address', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputCheckbox($fieldName, $popupVal, $options, array $params)
    {
        unset($params['placeholder']);
        unset($params['maxlength']);
        unset($params['minlength']);
        $params['class'] = 'm-checkbox';
        $popupVales = $this->processValues($popupVal);
        return view('core::admin.common.input_forms.input_checkbox', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
            'popupVales' => $popupVales,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputBoolean($fieldName, $options, array $params)
    {
        unset($params['placeholder']);
        unset($params['maxlength']);
        unset($params['minlength']);
        $params['data-toggle'] = 'toggle';
        $params['data-width'] = '50';
        $params['data-size'] = 'mini';
        return view('core::admin.common.input_forms.input_boolean', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputCurrency($fieldName, $options, array $params)
    {
        unset($params['maxlength']);
        $params['data-currency'] = "true";
        $params['min'] = 0;
        return view('core::admin.common.input_forms.input_currency', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputDate($fieldName, $options, array $params)
    {
        unset($params['maxlength']);
        unset($params['minlength']);
        $params['class'] = $params['class'] . ' date-picker';
        return view('core::admin.common.input_forms.input_date', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputDateTime($fieldName, $options, array $params)
    {
        unset($params['maxlength']);
        unset($params['minlength']);
        $params['class'] = $params['class'] . ' datetime-picker';
        return view('core::admin.common.input_forms.input_datetime', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputDecimal($fieldName, $options, array $params)
    {
        unset($params['maxlength']);
        return view('core::admin.common.input_forms.input_decimal', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $popupVal
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputDropdown($fieldName, $popupVal, $options, array $params)
    {
        unset($params['maxlength']);
        unset($params['placeholder']);
        $params['class'] .= ' custom-select-sm';
        $popupVales = $this->processValues($popupVal);
        return view('core::admin.common.input_forms.input_dropdown', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
            'popupVales' => $popupVales,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputEmail($fieldName, $options, array $params)
    {
        return view('core::admin.common.input_forms.input_email', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputFile($fieldName, $options, array $params)
    {
        return view('core::admin.common.input_forms.input_file', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputFloat($fieldName, $options, array $params)
    {
        unset($params['maxlength']);
        return view('core::admin.common.input_forms.input_float', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputEditor($fieldName, $options, array $params)
    {
        $params['class'] = $params['class'] . ' js-summernote';
        return view('core::admin.common.input_forms.input_editor', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputInteger($fieldName, $options, array $params)
    {
        return view('core::admin.common.input_forms.input_integer', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputMultiSelect($fieldName, $popupVal, $options, array $params)
    {
        unset($params['placeholder']);
        unset($params['maxlength']);
        unset($params['minlength']);
        $params['class'] = 'form-control select2';
        $params['multiple'] = 'multiple';
        $popupVales = $this->processValues($popupVal);
        return view('core::admin.common.input_forms.input_multi_select', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
            'popupVales' => $popupVales,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputPassword($fieldName, $options, array $params)
    {
        return view('core::admin.common.input_forms.input_password', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputRadio($fieldName, $popupVal, $options, array $params)
    {
        unset($params['placeholder']);
        unset($params['maxlength']);
        unset($params['minlength']);
        $params['class'] = 'm-radio';
        $popupVales = $this->processValues($popupVal);
        return view('core::admin.common.input_forms.input_radio', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
            'popupVales' => $popupVales,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param $params
     * @return array|string
     * @throws \Throwable
     * @author Means
     */
    public function inputString($fieldName, $options, array $params)
    {
        return view('core::admin.common.input_forms.input_string', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputTagInput($fieldName, $options, array $params)
    {
        unset($params['placeholder']);
        unset($params['maxlength']);
        unset($params['minlength']);
        $params['data-role'] = 'tagsinput';
        $params['multiple'] = '';
        $options['default_value'] = getPopupValTagsInput($options['default_value']);
        return view('core::admin.common.input_forms.input_tag_input', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param array $params
     * @return array|string
     * @throws \Throwable
     */
    public function inputTextarea($fieldName, $options, array $params)
    {
        $params['cols'] = 30;
		$params['rows'] = 3;
        return view('core::admin.common.input_forms.input_textarea', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $fieldName
     * @param $options
     * @param $params
     * @return array|string
     * @throws \Throwable
     * @author Means
     */
    public function inputUrl($fieldName, $options, array $params)
    {
        return view('core::admin.common.input_forms.input_url', [
            'fieldName' => $fieldName,
            'options' => $options,
            'params' => $params,
        ])->render();
    }

    /**
     * @param $json
     * @return array
     */
    public function processValues($json) {
        $output = [];
		// Check if populated values are from Module or Database Table
		if (is_string($json) && startsWith($json, "@")) {

			// Get Module / Table Name
			$json = str_ireplace("@", "", $json);
            $tableName = strtolower(Str::plural($json));

			// Search Module
            $module = app(ModuleInterface::class)->getByTable($tableName);
			if (isset($module->id)) {
                $output = app(ModuleInterface::class)->getRecordByTable($module->name);
			}
		} else if (is_string($json)) {
            $array = json_decode($json);
            foreach ($array as $value) {
                $output[$value] = $value;
            }
		} else if(is_array($json)) {
			foreach ($json as $value) {
				$output[$value] = $value;
			}
		}
		return $output;
	}
}
