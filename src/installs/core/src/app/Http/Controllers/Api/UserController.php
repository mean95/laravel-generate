<?php

namespace Core\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Core\Repositories\Contracts\AdminUserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Core\DataTables\UserDataTable;
use Core\Http\Requests\Admin\UserRequest;
use Core\Repositories\Contracts\ModuleInterface;
use Core\Repositories\Contracts\RoleInterface;

class UserController extends Controller
{
    /**
     * @var ModuleInterface
     */
    protected $moduleRepository;

    /**
    
     * @var AdminUserInterface
     */
    protected $userRepository;

    /**
    
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @param ModuleInterface $moduleRepository
     * @param AdminUserInterface $userRepository
     * @param RoleInterface $roleRepository
     */
    public function  __construct(
        ModuleInterface $moduleRepository,
        AdminUserInterface $userRepository,
        RoleInterface $roleRepository
    )
    {
        $this->moduleRepository = $moduleRepository;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->userRepository->all();
        if (!empty($request['username'])) {
           $user = $this->userRepository->findWhere(['username' => $request['username']]);
        }
        return $user;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $module = $this->moduleRepository->get('Users');
        $roles = $this->roleRepository->all();
        return view('core::admin.users.create', [
            'module' => $module,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepository->store($request->except(['_token']));
        if ($request['submit'] === 'save') {
            return redirect()->route(getPrefix() . '.users.index')
                ->with('success', trans('core::admin.flash_message.create_success'));
        }
        return redirect()->route(getPrefix() . '.users.edit', $user->id)
            ->with('success', trans('core::admin.flash_message.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->with('roleUser')->find($id);
        $module = $this->moduleRepository->get('Users', $user);
        $roles = $this->roleRepository->all();
        return view('core::admin.users.edit', [
            'user' => $user,
            'module' => $module,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->userRepository->updateUser($request->except(['_token']), $id);
        $this->userRepository->changePassword($user, $request['password']);
        if ($request['submit'] === 'save') {
            return redirect()->route(getPrefix() . '.users.index')
                ->with('success', trans('core::admin.flash_message.update_success'));
        }
        return redirect()->route(getPrefix() . '.users.edit', $user->id)
            ->with('success', trans('core::admin.flash_message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->destroy($id);
        if ($user) {
            return back()->with('success', trans('core::admin.flash_message.delete_success'));
        }
        return back()->with('error', trans('core::admin.flash_message.failed'));
    }

}
