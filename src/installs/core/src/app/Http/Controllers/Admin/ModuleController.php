<?php

namespace Core\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Core\app\DataTables\ModuleDataTable;
use Core\app\DataTables\ModuleFieldDataTable;
use Core\app\Http\Requests\Admin\ModuleRequest;
use Core\app\Repositories\Contracts\AdminMenuInterface;
use Core\app\Repositories\Contracts\ModuleInterface;
use Route;

class ModuleController extends Controller
{
    /**
     * @var AdminMenuInterface
     */
    protected $adminMenu;

    /**
     * @var ModuleInterface
     */
    protected $moduleRepository;

    /**
     * @param AdminMenuInterface $adminMenu
     * @param ModuleInterface $moduleRepository
     */
    public function __construct(
        AdminMenuInterface $adminMenu,
        ModuleInterface $moduleRepository
    )
    {
        $this->adminMenu = $adminMenu;
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ModuleDataTable $dataTable
     * @return Response
     */
    public function index(ModuleDataTable $dataTable)
    {
        return $dataTable->render('core::admin.modules.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ModuleRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(ModuleRequest $request): RedirectResponse
    {
        $this->moduleRepository->generateBase($request['name'], $request['icon']);
        return redirect()->route(getPrefix() . '.modules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param ModuleFieldDataTable $dataTable
     * @param $id
     * @return Response
     */
    public function show(ModuleFieldDataTable $dataTable, $id)
    {
        $module = $this->moduleRepository->with('moduleFields')->find($id);
        $countItemModule = $this->moduleRepository->itemCount($module->name);
        return $dataTable->render('core::admin.modules.show', [
            'module' => $module,
            'countItemModule' => $countItemModule,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return View
     */
    public function edit($id): View
    {
        $moduleFieldTypes = getModuleFieldTypes();
        $module = $this->moduleRepository->find($id);
        $tables = listTables();
        return view('core::admin.modules.edit', [
            'module' => $module,
            'tables' => $tables,
            'moduleFieldTypes' => $moduleFieldTypes,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy($id): RedirectResponse
    {
        $module = $this->moduleRepository->find($id);
        $module->deleteModule();
        return redirect()->route(getPrefix() . '.modules.index')
            ->with('success', trans('core::admin.flash_message.delete_success'));
    }


    /**
     * Set view cole column for module_fields of module
     *
     * @param mixed $moduleId
     * @param mixed $columnName
     * @return RedirectResponse
     * @author Means
     */
    public function setViewCol($moduleId, $columnName): RedirectResponse
    {
        $attributes['view_col'] = $columnName;
        $this->moduleRepository->update($attributes, $moduleId);
        return back()->with('success', trans('core::admin.flash_message.update_success'));
    }

    /**
     * Generate migration and CRUD
     *
     * @param $id
     * @return RedirectResponse
     */
    public function generateMigrateCrud($id): RedirectResponse
    {
        $module = $this->moduleRepository->with('moduleFields')->find($id);
        $config = $module->generateConfig();
        $module->createFormRequest($config);

        // Generate CRUD
        $module->generateMigration($config);
        $module->createController($config);
        $module->createDataTable($config);
        $module->createModel($config);
        $module->createContract($config);
        $module->createEloquent($config);
        $module->appendRoutes($config);
        $module->appendProvider($config);
        $module->createViews($config);
		$this->adminMenu->addMenu($config);

		$data['is_gen'] = 1;
        $this->moduleRepository->update($data, $id);

        return back()->with('success', trans('core::module.generate_success'));
    }

    /**
     * Generate migration
     *
     * @param $id
     * @return RedirectResponse
     */
    public function generateMigrate($id): RedirectResponse
    {
        $module = $this->moduleRepository->with('moduleFields')->find($id);
        $config = $module->generateConfig();
        $module->generateMigration($config);
        return back()->with('success', trans('core::module.generate_success'));
    }

    /**
     * Generate migration and CRUD
     *
     * @param $id
     * @return RedirectResponse
     */
    public function generateCrudUpdate($id): RedirectResponse
    {
        $module = $this->moduleRepository->with('moduleFields')->find($id);
        $config = $module->generateConfig();
        
        // Generate CRUD
        $module->createFormRequest($config);
        $module->createDataTable($config);
        $module->createModel($config);
        $module->createViews($config);
        return back()->with('success', trans('core::module.generate_success'));
    }

    /**
     * Generate update migration
     *
     * @param $id
     * @return RedirectResponse
     */
    public function generateMigrateUpdate($id): RedirectResponse
    {
        $module = $this->moduleRepository->with('moduleFields')->find($id);
        $config = $module->generateConfig();
        $module->deleteMigrateBeforeUpdate();
        $module->generateMigration($config);
        return back()->with('success', trans('core::module.generate_success'));
    }
}
