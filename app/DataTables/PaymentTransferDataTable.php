<?php

namespace App\DataTables;

use App\Models\Payment;
use App\Models\PaymentTransfer;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PaymentTransferDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'payment_transfers.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Payment $model)
    {
        return $model->newQuery()->with(['masterfile','unit'])->where('transfered_by','<>',null)->orderByDesc('payments.updated_at');
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
                'scrollX'=>true,
//                'dom'     => 'Bfrtip',
//                'order'   => [[0, 'desc']],
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
            'ref_number',
//            'TransID',
            'payment_mode',
            'transferred_from',

            'unit.unit_number'=>[
               'title'=> 'Transferred To House'
            ],
            'masterfile.full_name'=>[
                'title'=>'Transferred to Tenant'
            ],
            'amount',
            'transfered_by',
//            'paybill',
//            'phone_number',
//            'BillRefNumber',
//            'TransTime',
//            'FirstName',
//            'middleName',
//            'LastName',
//            'received_on',
//            'client_id',
//            'created_by',
//            'status',
//            'updated_by',
//            'bank_id'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'payment_transfersdatatable_' . time();
    }
}