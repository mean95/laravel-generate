<?php


namespace Core\DataTables;

use Illuminate\Http\Request;
use Core\Repositories\Contracts\ModuleFieldInterface;
use Core\Repositories\Contracts\ModuleInterface;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ModuleFieldDataTable extends DataTable
{
    /**
     * @var ModuleInterface
     */
    protected $moduleRepository;
    protected $moduleFieldRepository;

    public function __construct(ModuleInterface $moduleRepository, ModuleFieldInterface $moduleFieldRepository)
    {
        $this->moduleRepository = $moduleRepository;
        $this->moduleFieldRepository = $moduleFieldRepository;
    }

    /**
     * Build DataTable class.
     *
     * @param $query
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($this->query())
            ->editColumn('module_field_type_id', function ($field) {
                return getModuleFieldTypes()[$field->module_field_type_id];
            })
            ->editColumn('unique', function ($field) {
                return view('core::admin.modules.fields.unique', [
                    'status' => $field->unique,
                ]);
            })
            ->editColumn('required', function ($field) {
                return view('core::admin.modules.fields.unique', [
                    'status' => $field->required,
                ]);
            })
            ->editColumn('popup_val', function ($field) {
                return view('core::admin.modules.fields.popup_val', [
                    'popupVal' => $field->popup_val,
                ]);
            })
            ->editColumn('operations', function ($field) {
                return view('core::admin.modules.fields.operation', [
                    'field' => $field,
                    'module' => $field->module,
                ]);
            })
           ;
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $moduleFields = $this->moduleRepository->with('moduleFields')
            ->find(request()->route('module'))
            ->moduleFields()->orderBy('id', 'ASC')->select();
        return $this->applyScopes($moduleFields);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     * @throws \Throwable
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->scrollX(true)
            ->pageLength(50);
    }

    /**
     * Get columns.
     *
     * @return array
     * @throws \Throwable
     */
    protected function getColumns()
    {
        return [

            'id' => [
                'name' => 'id',
                'title' => 'ID',
                'class' => '',
            ],
            'label' => [
                'name' => 'label',
                'title' => trans('core::module.table.label'),
                'class' => '',
            ],
            'column_name' => [
                'name' => 'column_name',
                'title' => trans('core::module.table.column_name'),
                'class' => '',
            ],
            'module_field_type_id' => [
                'name' => 'module_field_type_id',
                'title' => trans('core::module.table.type'),
                'class' => '',
            ],
            'unique' => [
                'name' => 'unique',
                'title' => trans('core::module.table.unique'),
                'class' => '',
            ],
            'default_value' => [
                'name' => 'default_value',
                'title' => trans('core::module.table.default'),
                'class' => '',
            ],
            'minlength' => [
                'name' => 'minlength',
                'title' => trans('core::module.table.min'),
                'class' => '',
            ],
            'maxlength' => [
                'name' => 'maxlength',
                'title' => trans('core::module.table.max'),
                'class' => '',
            ],
            'required' => [
                'name' => 'required',
                'title' => trans('core::module.table.required'),
                'class' => '',
            ],
            'popup_val' => [
                'name' => 'popup_val',
                'title' => trans('core::module.table.value'),
                'class' => '',
            ],
            Column::computed('operations')
                ->width(60)->title(trans('core::admin.button.operation')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ModuleField_' . date('YmdHis');
    }
}
