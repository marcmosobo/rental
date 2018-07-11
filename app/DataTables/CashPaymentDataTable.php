<?php

namespace App\DataTables;

use App\Http\Controllers\LoggedUserController;
use App\Models\CashPayment;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CashPaymentDataTable extends DataTable
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
                return Carbon::parse($payment->received_on)->toDateString();
            })
            ->editColumn('paybill',function($payment){
                return '<a data-toggle="modal" e-id="'.$payment->id.'" href="#edit-modal" hint="'.url('cashPayments/'.$payment->id).'"  class="btn btn-xs btn-success edit-common">Edit payment</a>';
            })->rawColumns(['action','paybill'])
            ->editColumn('action', function($payment){
            return '<a href="'.url('receipt/'.$payment->id).'" class="btn btn-xs btn-primary">view/print receipt</a>';
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CashPayment $model)
    {
        return $model->newQuery()
            ->select(['payments.*'])
            ->where('payment_mode',cash)
            ->orWhere('payment_mode','Bank')
            ->orderByDesc('payments.id')
            ->with(['masterfile','unit'])
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
            ->addAction(['width' => '80px'])
            ->parameters([
//                'dom'     => 'Bfrtip',
//                'order'   => [[0, 'desc']],
                'scrollX'=>true,
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
        if(LoggedUserController::isAllAccessGranted()){
            return [
                'masterfile.full_name'=>[
                    'title'=>'Tenant Name'
                ],
                'unit.unit_number'=>[
                    'title'=>'Unit Number'
                ],
                'ref_number',
                'amount',
                'received_on',
                'paybill'=>[
                    'title'=>'Edit'
                ]
            ];

        }else{
            return [
                'masterfile.full_name'=>[
                    'title'=>'Tenant Name'
                ],
                'unit.unit_number'=>[
                    'title'=>'Unit Number'
                ],
                'ref_number',
                'amount',
                'received_on',
            ];
        }

    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'cash_paymentsdatatable_' . time();
    }
}