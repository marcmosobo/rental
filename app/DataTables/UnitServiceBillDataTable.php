<?php

namespace App\DataTables;

use App\Models\UnitServiceBill;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UnitServiceBillDataTable extends DataTable
{
    private $_unitId;
    public function __construct($id)
    {
        $this->_unitId = $id;
    }

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
            ->editColumn('status',function ($t){
                if($t->status){
                    return '<label class="label label-success">Active</label>';
                }
                return '<label class="label label-danger">In active</label>';
            })
            ->rawColumns(['status','action'])
            ->addColumn('action', 'unit_service_bills.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UnitServiceBill $model)
    {
        return $model->newQuery()
            ->select('unit_service_bills.*')
            ->where('unit_id',$this->_unitId)
            ->with(['bill']);
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
//            'unit_id',
            'bill.name',
            'amount',
            'period',
            'status'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'unit_service_billsdatatable_' . time();
    }
}