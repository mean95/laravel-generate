<?php


namespace Core\DataTables;

use Core\Repositories\Contracts\ModuleInterface;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ModuleDataTable extends DataTable
{
    /**
     * @var ModuleInterface
     */
    protected $moduleRepository;

    public function __construct(ModuleInterface $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($this->query())
            ->editColumn('updated_at', function ($item) {
                return formatDateTime($item->updated_at);
            })
            ->editColumn('name', function ($item) {
                return view('core::admin.modules._particle.name', [
                    'module' => $item,
                ]);
            })
            ->editColumn('operations', function ($item) {
                return view('core::admin.modules._particle.operation', [
                    'module' => $item,
                ]);
            })
            ->editColumn('item', function ($item) {
                return $this->moduleRepository->itemCount($item->name);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $modules = $this->moduleRepository->select();
        return $this->applyScopes($modules);
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
            'name' => [
                'name' => 'name',
                'title' => trans('core::module.table.name'),
                'class' => '',
            ],
            'name_db' => [
                'name' => 'name_db',
                'title' => trans('core::module.table.table'),
                'class' => '',
            ],
            Column::computed('item')
                ->title(trans('core::module.table.item')),
            'updated_at' => [
                'name' => 'updated_at',
                'title' => trans('core::admin.button.updated_at'),
                'class' => '',
            ],
            Column::computed('operations')
                ->width(60)->title(trans('core::admin.button.operation'))
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Module_' . date('YmdHis');
    }
}
