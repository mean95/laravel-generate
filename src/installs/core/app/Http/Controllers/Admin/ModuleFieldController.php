<?php

namespace Core\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Core\app\Repositories\Contracts\ModuleFieldInterface;
use Core\app\Repositories\Contracts\ModuleFieldTypeInterface;

class ModuleFieldController extends Controller
{
    /**
     * @var ModuleFieldInterface
     */
    protected $moduleField;

    /**
     * @param ModuleFieldInterface $moduleField
     */
    public function __construct(
        ModuleFieldInterface $moduleField
    )
    {
        $this->moduleField = $moduleField;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request): RedirectResponse
    {
        $field = $this->moduleField->store($request->except(['_token']));
        if (!$field) {
            return back()->with('error', trans('core::admin.flash_message.failed'));
        }
        if ($request['submit'] === 'save') {
            return redirect()->route(getPrefix() . '.modules.show', $request->module_id)
                ->with('success', trans('core::admin.flash_message.create_success'));
        }
        return redirect()->route(getPrefix() . '.module_fields.edit', $field->id)
                ->with('success', trans('core::admin.flash_message.create_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return View
     */
    public function edit($id): View
    {
        $field = $this->moduleField->with('module')->find($id);
        $moduleFieldTypes = app(ModuleFieldTypeInterface::class)->getModuleFieldTypeEdit($field->module->name_db);
        $tables = listTables();
        return view('core::admin.modules.fields.edit', [
            'field' => $field,
            'moduleFieldTypes' => $moduleFieldTypes,
            'tables' => $tables,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $field = $this->moduleField->updateField($request->except(['_token']), $id);
        if (!$field) {
            return back()->with('error', trans('core::admin.flash_message.failed'));
        }
        if ($request['submit'] === 'save') {
            return redirect()->route(getPrefix() . '.modules.show', $request->module_id)
                ->with('success', trans('core::admin.flash_message.update_success'));
        }
        return redirect()->route(getPrefix() . '.module_fields.edit', $field->id)
                ->with('success', trans('core::admin.flash_message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
		$field = $this->moduleField->with('module')->find($id);
        $module = $field->module;
		Schema::table($module->name_db, function ($table) use ($field, $module) {
            $foreign = $module->name_db . '_'. $field->column_name .'_foreign';
            if (in_array($foreign, schemaManager()->listForeignKeys($module->name_db))) {
                $table->dropForeign($foreign);
            }
            if (in_array($field->column_name, schemaManager()->listColumns($module->name_db))) {
                $table->dropColumn($field->column_name);
            }
		});
		$field->delete();
        return redirect()->route('admin.modules.show', $module->id)
            ->with('success', trans('core::admin.flash_message.delete_success'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uniqueFieldValue(Request $request): JsonResponse
    {
        $valExists = false;
		$field = $this->moduleField->with('module')->find($request['field_id']);
        $rowCount = DB::table($field->module->name_db)
            ->where($field->column_name, $request['field_value'])
            ->where("id", "<>", $request['row_id'])->count();
		if ($rowCount > 0) {
			$valExists = true;
		}
		return response()->json(['exists' => $valExists]);
    }
}
