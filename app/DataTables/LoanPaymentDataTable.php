<?php

namespace App\DataTables;

use App\Http\Controllers\LoggedUserController;
use App\Models\LoanPayment;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LoanPaymentDataTable extends DataTable
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

        return $dataTable
            ->editColumn('date',function($date){
                return Carbon::parse($date->date)->toDateString();
            })
            ->addColumn('action', 'loan_payments.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LoanPayment $model)
    {
        return $model->newQuery()
            ->select('landlord_accounts.*')
            ->where('landlord_accounts.transaction_type',debit)
            ->orderByDesc('landlord_accounts.id')->with(['masterfile']);
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
        }
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
//            ->addAction(['width' => '80px'])
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

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'masterfile.full_name'=>[
                'title'=>'Landlord'
            ],
//            'landlord_id',
            'reference',
            'transaction_type',
            'amount',
            'date'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'loan_paymentsdatatable_' . time();
    }
}