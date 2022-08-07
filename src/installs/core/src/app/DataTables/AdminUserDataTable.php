<?php


namespace Core\DataTables;

use Core\Repositories\Contracts\AdminUserInterface;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminUserDataTable extends DataTable
{
    /**
     * @var AdminUserInterface
     */
    protected $userRepository;

    public function __construct(AdminUserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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
            ->editColumn('operations', function ($item) {
                return view('core::admin.common.operation', [
                    'item' => $item,
                    'module' => 'admin_users',
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
        $users = $this->userRepository->select();
        return $this->applyScopes($users);
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
            ->scrollX(true)
            ->orderBy(1)
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
                ->width(60)->title(trans('core::admin.button.operation'))
                ->addClass('text-center'),
            'id' => [
                'name' => 'id',
                'title' => 'ID',
                'class' => '',
            ],
            'username' => [
                'name' => 'username',
                'title' => trans('core::user.table.username'),
                'class' => '',
            ],
            'email' => [
                'name' => 'email',
                'title' => trans('core::user.table.email'),
                'class' => '',
            ],
            'updated_at' => [
                'name' => 'updated_at',
                'title' => trans('core::admin.button.updated_at'),
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
        return 'AdminUser_' . date('YmdHis');
    }
}
