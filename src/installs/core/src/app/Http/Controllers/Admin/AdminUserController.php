<?php

namespace Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Core\DataTables\AdminUserDataTable;
use Core\Http\Requests\Admin\AdminUserRequest;
use Core\Http\Requests\Admin\UserRequest;
use Core\Repositories\Contracts\AdminUserInterface;
use Core\Repositories\Contracts\RoleInterface;

class AdminUserController extends Controller
{
    /**
     * @var AdminUserInterface
     */
    protected $userRepository;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @param AdminUserInterface $userRepository
     * @param RoleInterface $roleRepository
     */
    public function  __construct(
        AdminUserInterface $userRepository,
        RoleInterface $roleRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param AdminUserDataTable $dataTable
     * @return Response
     */
    public function index(AdminUserDataTable $dataTable)
    {
        return $dataTable->render('core::admin.admin_users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $roles = $this->roleRepository->all();
        return view('core::admin.admin_users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminUserRequest  $request
     * @return RedirectResponse
     */
    public function store(AdminUserRequest $request): RedirectResponse
    {
        $user = $this->userRepository->store($request->except(['_token']));
        if ($request['submit'] === 'save') {
            return redirect()->route(getPrefix() . '.admin_users.index')
                ->with('success', trans('core::admin.flash_message.create_success'));
        }
        return redirect()->route(getPrefix() . '.admin_users.edit', $user->id)
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
        $user = $this->userRepository->with('adminUserRole')->find($id);
        $roles = $this->roleRepository->all();
        return view('core::admin.admin_users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminUserRequest $request
     * @param $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(AdminUserRequest $request, $id): RedirectResponse
    {
        $user = $this->userRepository->updateUser($request->except(['_token']), $id);
        $this->userRepository->changePassword($user, $request['password']);
        if ($request['submit'] === 'save') {
            return redirect()->route(getPrefix() . '.admin_users.index')
                ->with('success', trans('core::admin.flash_message.update_success'));
        }
        return redirect()->route(getPrefix() . '.admin_users.edit', $user->id)
            ->with('success', trans('core::admin.flash_message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $user = $this->userRepository->destroy($id);
        if ($user) {
            return back()->with('success', trans('core::admin.flash_message.delete_success'));
        }
        return back()->with('error', trans('core::admin.flash_message.failed'));
    }
}
