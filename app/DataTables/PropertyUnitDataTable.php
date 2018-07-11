<?php

namespace App\DataTables;

use App\Http\Controllers\LoggedUserController;
use App\Models\PropertyUnit;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PropertyUnitDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */

    private $_id;
    public function __construct($id)
    {
        $this->_id = $id;
    }

    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->editColumn('created_at',function ($unit){
              return '<a href="'.url('unitBills/'.$unit->id).'" class="btn btn-success btn-xs">Add/Edit Service bills</a>';
            })
            ->rawColumns(['created_at','action'])
            ->addColumn('action', 'property_units.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PropertyUnit $model)
    {
        return $model->newQuery()->where('property_id',$this->_id)->orderByDesc('id');
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
        }else{
            return $this->builder()
                ->columns($this->getColumns())
                ->minifiedAjax()
//                ->addAction(['width' => '80px'])
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
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
//            'property_id',
            'unit_number',
            'created_at'=>[
                'title'=>'Service Bills'
            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'property_unitsdatatable_' . time();
    }
}