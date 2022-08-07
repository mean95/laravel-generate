<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => getPrefix(), 'as' => getPrefix() . '.'], function () {
    Route::group([
        'namespace' => 'Core\Http\Controllers\Admin\Auth',
        'middleware' => ['web'],
    ], function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });

    Route::group([
        'namespace' => 'Core\Http\Controllers\Admin',
        'middleware' => ['web', 'admin'],
    ], function () {
        Route::get('/media', 'HomeController@media')->name('media');
        Route::group([
            'prefix' => 'file-manager/', 'as' => 'file_manager.',
            'namespace' => 'FileManager'
        ], function () {
            Route::get('', 'LfmController@show')->name('show');
            Route::get('errors', 'LfmController@getErrors')->name('getErrors');

            // upload
            Route::any('upload', 'UploadController@upload')->name('upload');

            // list images & files
            Route::get('jsonitems', 'ItemsController@getItems')->name('getItems');
            Route::get('move', 'ItemsController@move')->name('move');
            Route::get('domove', 'ItemsController@domove')->name('domove');

            // folders
            Route::get('newfolder', 'FolderController@getAddfolder')->name('getAddfolder');
            Route::get('folders', 'FolderController@getFolders')->name('getFolders');

            // crop
            Route::get('crop', 'CropController@getCrop')->name('getCrop');
            Route::get('cropimage', 'CropController@getCropimage')->name('getCropimage');
            Route::get('cropnewimage', 'CropController@getNewCropimage')->name('getCropnewimage');

            // rename
            Route::get('rename', 'RenameController@getRename')->name('getRename');

            // scale/resize
            Route::get('resize', 'ResizeController@getResize')->name('getResize');
            Route::get('doresize', 'ResizeController@performResize')->name('performResize');

            // download
            Route::get('download', 'DownloadController@getDownload')->name('getDownload');

            // delete
            Route::get('delete', 'DeleteController@getDelete')->name('getDelete');

            Route::get('/demo', 'DemoController@index');
        });

        Route::get('/', 'HomeController@index')->name('home');

        Route::resource('admin_menus', 'AdminMenuController')->except(['create', 'show']);
        Route::get('admin_menus/update_hierarchy', 'AdminMenuController@updateHierarchy')
            ->name('admin_menus.update_hierarchy');

        Route::resource('admin_users', 'AdminUserController')->except(['show']);

        Route::resource('modules', 'ModuleController')->except(['create']);
        Route::get('modules/{id}/set_view_col/{field_name}', 'ModuleController@setViewCol')
            ->name('modules.set_view_col');
        Route::post('modules/module_generate_migrate_crud/{id}', 'ModuleController@generateMigrateCrud')
            ->name('modules.module_generate_migrate_crud');
        Route::post('modules/module_generate_update/{id}', 'ModuleController@generateCrudUpdate')
            ->name('modules.module_generate_crud_update');

        Route::post('modules/module_generate_migrate/{id}', 'ModuleController@generateMigrate')
            ->name('modules.module_generate_migrate');
        Route::post('modules/module_generate_migrate_update/{id}', 'ModuleController@generateMigrateUpdate')
            ->name('modules.module_generate_migrate_update');

        Route::resource('module_fields', 'ModuleFieldController');
        Route::get('ajax/module_fields/unique_field_value', 'ModuleFieldController@uniqueFieldValue')
            ->name('ajax.module_fields.unique_field_value');

        /* ================== Roles ================== */
        Route::resource('roles', 'RoleController');
    });
});
