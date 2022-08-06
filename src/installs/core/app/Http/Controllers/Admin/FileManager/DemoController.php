<?php

namespace Core\app\Http\Controllers\Admin\FileManager;

class DemoController extends LfmController
{
    public function index()
    {
        return view('core::admin.file_manager.demo');
    }
}
