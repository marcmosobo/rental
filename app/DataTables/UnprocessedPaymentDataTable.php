<?php

namespace App\DataTables;

use App\Models\Payment;
use App\Models\UnprocessedPayment;
use App\User;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UnprocessedPaymentDataTable extends DataTable
{
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
                return '<label class="label label-warning">Un processed</label>';
            })

            ->editColumn('created_by',function($payment){
                if(!$payment->status){
                    return '<a href="#edit-modal" data-toggle="modal" e-id="'.$payment->id.'" hint="'.url('payments/'.$payment->id).'" class="btn btn-default btn-xs edit-common" ><i class="glyphicon glyphicon-eye-edit"></i>update</a>';
                }
                if(!is_null($payment->updated_by)){
                    return User::find($payment->updated_by)->name;
                }
                return '';
            })
            ->rawColumns(['status','created_by','action','split_payment'])
            ->addColumn('action', function($payment){
                if(!$payment->status){
                    return '<a href="#delete-modal" data-toggle="modal" action="'.url('processPayment/'.$payment->id).'" class="btn btn-success btn-xs delete-common"><i class=""></i> process payment</a>';
                }
                return '';
            })
            ->addColumn('split_payment',function($payment){
                return '<a href="#split-payment" data-toggle="modal" action="'.url('processPayment/'.$payment->id).'" class="btn btn-primary btn-xs">split payment</a>';
            })
            ;
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
            ->where('status',false)
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
            ->addAction(['width' => '80px'])
            ->parameters([
//                'dom'     => 'Bfrtip',
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
            'house_number',
            'phone_number',
            'FirstName',
            'LastName',
            'received_on',
//            'payment_mode',
//            'house_number',
//            'tenant_id',
//
            'amount',
            'status',
//            'TransID',
//            'TransTime',
//            'middleName',

//            'client_id',
            'created_by'=>[
                'title'=>'Update / Updated by'
            ],
            'split_payment'
        ];
    }

    protected function filename()
    {
        return 'unprocessed_paymentsdatatable_' . time();
    }
}