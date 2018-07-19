<?php

namespace App\DataTables;

use App\Http\Controllers\LoggedUserController;
use App\Models\BillDetail;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class BillDetailDataTable extends DataTable
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
            ->editColumn('bill_date',function($bill){
                if(!is_null($bill->bill_date)){
                    return Carbon::parse($bill->bill_date)->toDateString();
                }
                return '';
            })
            ->addColumn('action', 'bill_details.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BillDetail $model)
    {
        return $model->newQuery()
            ->select('bill_details.*')
            ->orderByDesc('bill_details.id')->with(['bill.lease.unit','bill.lease.masterfile','service','bill.lease.property']);
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
                    'scrollX'=>true,
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

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'bill.lease.property.name'=>[
                'title'=>'Plot'
            ],
            'bill.lease.unit.unit_number'=>[
                'title'=>'House Number'
            ],
            'bill.lease.masterfile.full_name'=>[
                'title'=>'Tenant'
            ],
            'service.name',
            'amount',
            'bill_date',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'bill_detailsdatatable_' . time();
    }
}