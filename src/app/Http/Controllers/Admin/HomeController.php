<?php

namespace Core\app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('core::admin.index');
    }

    /**
     * Show the application media.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function media()
    {
        return view('core::admin.media');
    }
}
