<?php

namespace Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Core\DataTables\RoleDataTable;
use Core\Http\Requests\Admin\RoleRequest;
use Core\Repositories\Contracts\PermissionInterface;
use Core\Repositories\Contracts\RoleInterface;

class RoleController extends Controller
{
    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @param RoleInterface $roleRepository
     */
    public function  __construct(
        RoleInterface $roleRepository
    )
    {
        $this->roleRepository = $roleRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param RoleDataTable $dataTable
     * @return Response
     */
    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('core::admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('core::admin.roles.create', [
            'uriPermissions' => getUriPermissions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $role = $this->roleRepository->handleStore($request->except(['_token']));
        if ($request['submit'] === 'save') {
            return redirect()->route(getPrefix() . '.roles.index')
                ->with('success', trans('core::admin.flash_message.create_success'));
        }
        return redirect()->route(getPrefix() . '.roles.edit', $role->id)
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
        $role = $this->roleRepository->find($id);
        $checkPermissions = app(PermissionInterface::class)->getArrayCheckPermissionByRole($role);
        return view('core::admin.roles.edit', [
            'role' => $role,
            'uriPermissions' => getUriPermissions(),
            'checkPermissions' => $checkPermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(RoleRequest $request, $id): RedirectResponse
    {
        $this->roleRepository->handleUpdate($request->except(['_token']), $id);
        if ($request['submit'] === 'save') {
            return redirect()->route(getPrefix() . '.roles.index')
                ->with('success', trans('core::admin.flash_message.update_success'));
        }
        return redirect()->route(getPrefix() . '.roles.edit', $id)
            ->with('success', trans('core::admin.flash_message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $role = $this->roleRepository->destroy($id);
        if ($role) {
            return back()->with('success', trans('core::admin.flash_message.delete_success'));
        }
        return back()->with('error', trans('core::admin.flash_message.failed'));
    }
}
