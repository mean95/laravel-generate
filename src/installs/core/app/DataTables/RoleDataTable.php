<?php

namespace Core\app\DataTables;

use Core\app\Models\Role;
use Core\app\Repositories\Contracts\RoleInterface;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    public function __construct(RoleInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
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
                return date('d/m/Y', strtotime($item->updated_at));
            })
            ->editColumn('operations', function ($item) {
                return view('core::admin.common.operation', [
                    'item' => $item,
                    'module' => 'roles',
                ]);
            })
            ->editColumn('mean_checkbox', function ($item) {
                return view('core::admin.common.checkbox', [
                    'id' => $item->id,
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $roles = $this->roleRepository->select();
        return $this->applyScopes($roles);
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
            ->orderBy(2)
            ->scrollX(true)
            ->fixedColumnsLeftColumns(1);
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
            Column::computed('operations')
                ->width(60)
                ->addClass('text-center'),
            Column::computed('mean_checkbox')
                ->width(10)
                ->title(tableCheckbox()),
            'id' => [
                'name' => 'id',
                'title' => 'ID',
                'class' => '',
            ],
            'name' => [
                'name' => 'name',
                'title' => trans('core::role.table.name'),
                'class' => '',
            ],
            'display_name' => [
                'name' => 'display_name',
                'title' => trans('core::role.table.display_name'),
                'class' => '',
            ],
            'updated_at' => [
                'name' => 'updated_at',
                'title' => trans('core::role.table.updated_at'),
                'class' => '',
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Role_' . date('YmdHis');
    }
}
