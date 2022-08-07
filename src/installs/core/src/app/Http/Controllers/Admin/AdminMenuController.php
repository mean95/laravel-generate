<?php

namespace Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Core\Http\Requests\Admin\AdminMenuRequest;
use Core\Repositories\Contracts\AdminMenuInterface;
use Core\Repositories\Contracts\ModuleInterface;

class AdminMenuController extends Controller
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
     * @return View
     */
    public function index(): View
    {
        $modules = $this->moduleRepository->all();
        $menus = $this->adminMenu->getMenus();
        return view('core::admin.admin_menus.index', [
            'menus' => $menus,
            'modules' => $modules,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminMenuRequest $request
     * @return RedirectResponse
     */
    public function store(AdminMenuRequest $request)
    {
        $this->adminMenu->store($request->except(['_token']));
        if (!empty($request['module_id'])) {
            return response()->json([
                "status" => "success",
                'msg' => trans('core::admin.flash_message.create_success')
            ], 200);
        }
        return back()->with('success', trans('core::admin.flash_message.create_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return RedirectResponse|View
     * @throws \Exception
     */
    public function edit($id)
    {
        $menu = $this->adminMenu->find($id);
        if ($menu->type === config('const.menu_type.module')) {
            return redirect()->route(getPrefix() . '.admin_menus.index')
                ->with('warning', trans('core::menu.warning_edit'));
        }
        $menus = $this->adminMenu->getMenus();
        return view('core::admin.admin_menus.edit', [
            'menus' => $menus,
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminMenuRequest $request
     * @param  $id
     * @return RedirectResponse
     */
    public function update(AdminMenuRequest $request, $id): RedirectResponse
    {
        $attributes = $request->except(['_token']);
        $this->adminMenu->update($attributes, $id);
        return back()->with('success', trans('core::admin.flash_message.update_success'));
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
        $menu = $this->adminMenu->delete($id);
        if ($menu) {
            return redirect()->route(getPrefix() . '.admin_menus.index')
                ->with('success', trans('core::admin.flash_message.delete_success'));
        }
        return back()->with('error', trans('core::admin.flash_message.failed'));
    }

    /**
     * Update Menu Hierarchy
     *
     * @return \Illuminate\Http\Response
     */
    public function updateHierarchy(Request $request)
    {
        return $this->adminMenu->updateHierarchy($request['jsonData']);
    }
}
