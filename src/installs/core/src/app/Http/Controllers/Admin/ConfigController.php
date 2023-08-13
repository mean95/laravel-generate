<?php

namespace Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $timeZones = getListTimeZone();
        return view('core::admin.configs.index', [
            'timeZones' => $timeZones
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        unset($request['_token']);
        foreach ($request->except(['_token']) as $key => $value) {
            $valueBefore = getConfig($key);
            if ($value !== $valueBefore) {
                updateConfig($key, $value);
            }
        }

        $request->session()->flash('success', trans('core::admin.flash_message.update_success'));

        return back();
    }
}