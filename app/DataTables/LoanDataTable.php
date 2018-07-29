<?php

namespace App\DataTables;

use App\Http\Controllers\LoggedUserController;
use App\Models\Loan;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LoanDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'loans.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Loan $model)
    {
        return $model->newQuery()->with(['masterfile']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        if(LoggedUserController::isAllAccessGranted()){
            return $this->builder()
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->addAction(['width' => '80px'])
                ->parameters([
//                'dom'     => 'Bfrtip',
                    'order'   => [[0, 'desc']],
                    'buttons' => [
                        'create',
                        'export',
                        'print',
                        'reset',
                        'reload',
                    ],
                ]);
        }else{
            return $this->builder()
                ->columns($this->getColumns())
                ->minifiedAjax()
//                ->addAction(['width' => '80px'])
                ->parameters([
//                'dom'     => 'Bfrtip',
                    'order'   => [[0, 'desc']],
                    'buttons' => [
                        'create',
                        'export',
                        'print',
                        'reset',
                        'reload',
                    ],
                ]);
        }
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'masterfile.full_name'=>[
                'title'=> 'Landlord'
            ],
            'principle',
            'rate',
            'loan_date',
//            'created_by',
//            'status'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'loansdatatable_' . time();
    }
}