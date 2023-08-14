<?php

use Core\Facades\ConfigFacade;
use Illuminate\Support\Facades\Route;
use Core\Facades\FormFacade;
use Core\Facades\MenuFacade;
use Core\Facades\SchemaManagerFacade;
use Core\Repositories\Contracts\ModuleFieldTypeInterface;
use Illuminate\Support\Facades\Schema;

if (!function_exists('platform_path')) {
    /**
     * @param null $path
     * @return string
     */
    function platform_path($path = null)
    {
        return base_path('platform' . DIRECTORY_SEPARATOR . $path);
    }
}

if (!function_exists('core_path')) {
    /**
     * @param null $path
     * @return string
     */
    function core_path($path = null): string
    {
        return base_path('core/src' . DIRECTORY_SEPARATOR . $path);
    }
}

if (!function_exists('configs')) {
    /**
     * @return mixed
     */
    function configs()
    {
        return ConfigFacade::getFacadeRoot();
    }
}

app()->singleton('configs', function () {
    if (!Schema::hasTable('configs')) {
        return null;
    }
    return configs()->all()->keyBy('key')->toArray();
});

if (!function_exists('getConfig')) {
    /**
     * @param $key
     * @return \Illuminate\Cache\CacheManager|mixed|null
     * @throws Exception
     * @author Rent
     * @since 1.0
     */
    function getConfig($key)
    {
        $configs = app('configs');
        $config = !empty($configs[$key]) ? (object) $configs[$key] : null;
        return $config->value ?? null;
    }
}

if (!function_exists('updateConfig')) {
    /**
     * @param $key
     * @param $value
     * @return bool
     * @throws Exception
     */
    function updateConfig($key, $value)
    {
        configs()->updateOrCreate(
            ['key' => $key],
            [
                'key' => $key,
                'value' => $value,
            ]
        );
        return true;
    }
}

if (!function_exists('getListTimeZone')) {
    /**
     * Get list time zone.
     *
     * @return array
     * @author Rent
     */
    function getListTimeZone(): array
    {
        $zones_array = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zones_array;
    }
}

if (!function_exists('getModuleFieldTypes')) {
    /**
     * Get all module field type for config
     * @return array
     * @author Means
     */
    function getModuleFieldTypes(): array
    {
        return app(ModuleFieldTypeInterface::class)->getModuleFieldTypes();
    }
}

if (!function_exists('getPrefix')) {
    /**
     * Get prefix site admin
     *
     * @return string
     * @throws Exception
     * @author Rent
     */
    function getPrefix()
    {
        return 'admin';
    }
}

if (!function_exists('listTables')) {
    /**
     * Get all table in db
     * @param array $removeTables
     * @return array
     * @author Means
     */
    function listTables($removeTables = []) {
        $tables = schemaManager()->listTables();
        $tablesOut = [];
        foreach ($tables as $table) {
            $table = (array) $table;
            $tablesOut[] = array_values($table)[0];
        }
        $arrayRemoveTable = [
            'configs',
            'admin_menus',
            'migrations',
            'modules',
            'module_fields',
            'module_field_types',
            'password_resets',
            'permissions',
            'permission_role',
            'roles',
            'admin_user_role',
            'failed_jobs',
            'jobs',
        ];
        $removeTables = array_merge($removeTables, $arrayRemoveTable);
        $removeTables = array_unique($removeTables);
        $tablesOut = array_diff($tablesOut, $removeTables);

        $arrayTablesOut = [];
        foreach ($tablesOut as $table) {
            $arrayTablesOut[$table] = $table;
        }

        return $arrayTablesOut;
    }
}

if (!function_exists('tableCheckbox')) {
    /**
     * @param $id
     * @return string
     *
     * @throws Throwable
     */
    function tableCheckbox($id = null): string
    {
        return view('core::admin.common.checkbox', [
            'id' => $id,
        ]);
    }
}

if (!function_exists('formatDateTime')) {
    /**
     * @param $dateTime
     * @return string
     *
     */
    function formatDateTime($dateTime): string
    {
        $format = getConfig('date_format') ?? 'd/m/Y';
        return $dateTime ? date($format, strtotime($dateTime)) : '';
    }
}

if (!function_exists('getPopupValTagsInput')) {
    /**
     * @param $popupVal
     * @return array
     *
     */
    function getPopupValTagsInput($popupVal): array
    {
        $popupVal = json_decode($popupVal);
        $dataVal = [];
        foreach ($popupVal ?? [] as $key => $value) {
            $dataVal[$value] = $value;
        }
        return $dataVal;
    }
}

if (!function_exists('scanFolder')) {
    /**
     * @param $path
     * @param array $ignoreFiles
     * @return array
     * @author Means
     */
    function scanFolder($path, $ignoreFiles = [])
    {
        try {
            if (is_dir($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..', '.DS_Store'], $ignoreFiles));
                natsort($data);
                return $data;
            }
            return [];
        } catch (Exception $ex) {
            return [];
        }
    }
}

if (!function_exists('formMaker')) {

    /**
     * Get facade form
     *
     * @return mixed
     * @author Means
     */
    function formMaker() {
        return FormFacade::getFacadeRoot();
    }
}

if (!function_exists('adminMenu')) {

    /**
     * Get facade form
     *
     * @return mixed
     * @author Means
     */
    function adminMenu() {
        return MenuFacade::getFacadeRoot();
    }
}

if (!function_exists('schemaManager')) {

    /**
     * Get facade schema manager
     *
     * @return mixed
     * @author Means
     */
    function schemaManager() {
        return SchemaManagerFacade::getFacadeRoot();
    }
}

if (!function_exists('getUriPermissions')) {

    /**
     * Get all uri permissions
     * @return array
     * @author Means
     */
    function getUriPermissions(): array {
        $routes = Route::getRoutes();
        $arrayRoutes = [];
        foreach ($routes as $value) {
            if (str_contains($value->uri, 'admin/')
                && !in_array($value->uri, ['admin/login', 'admin/logout'])) {
                $arrayRoutes[$value->uri . '/' . $value->methods[0]] = [
                    'method' => $value->methods[0],
                    'uri' => $value->uri,
                    'name_route' => $value->getAction()['as'],
                ];
            }
        }
        return $arrayRoutes;
    }
}

if (!function_exists('getPathStorageDefault')) {

    /**
     * Get path storage default
     * @return string
     * @author Means
     */
    function getPathStorageDefault(): string {
        $disk = config('lfm.disk', '');
        switch ($disk) {
            case 's3':
                return config('filesystems.disks.s3');
                break;
            default:
                return url('');
                break;
        }
    }
}

if (!function_exists('getUrlFile')) {

    /**
     * Get url file
     * @return string
     * @author Means
     */
    function getUrlFile($file): string {
        if (empty($file)) {
            return '';
        }
        $path = getPathStorageDefault();
        return $path . $file;
    }
}

if (!function_exists('getUrlFileThumbnail')) {

    /**
     * Get url image
     * @return string
     * @author Means
     */
    function getUrlFileThumbnail($file): string {
        if (empty($file)) {
            return '';
        }
        $path = getPathStorageDefault();
        $fileExplode = explode('/', $file);
        $nameFile = end($fileExplode);
        return $path . str_replace($nameFile, 'thumbs/', $file) . $nameFile;
    }
}
