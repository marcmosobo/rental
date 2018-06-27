<?php

namespace App\DataTables;

use App\Models\Payment;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PaymentDataTable extends DataTable
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
            ->editColumn('received_on',function($payment){
                return Carbon::parse($payment->received_on)->toDayDateTimeString();
            })
            ->editColumn('status',function ($payment){
                if($payment->status){
                    return '<label class="label label-success">Processed</label>';
                }
                return '<label class="label label-warning">Legacy Client</label>';
            })
            ->rawColumns(['status'])
            ->addColumn('action', 'payments.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Payment $model)
    {
        return $model->newQuery()->where('payment_mode',mpesa)
            ->orderByDesc('payments.id')
            ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
//            ->addAction(['width' => '80px'])
            ->parameters([
                'dom'     => 'Bfrtip',
//                'order'   => [[0, 'desc']],
                'scrollX'=>true,
                'buttons' => [
//                    'create',
                    'export',
//                    'print',
//                    'reset',
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
            'ref_number',
            'BillRefNumber'=>[
                'title'=>'Account'
            ],
            'phone_number',
            'FirstName',
            'LastName',
            'received_on',
            'payment_mode',
//            'house_number',
//            'tenant_id',
//
            'amount',
            'status',
//            'TransID',
//            'TransTime',
//            'middleName',

//            'client_id',
//            'created_by'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'paymentsdatatable_' . time();
    }
}