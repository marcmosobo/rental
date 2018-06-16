<?php

namespace App\DataTables;

use App\Models\Property;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PropertyDataTable extends DataTable
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
            ->editColumn('created_at',function ($property){
                return '<a href="'.url('units/'.$property->id).'" class="btn btn-primary btn-xs">View/Add units</a>';
            })
            ->rawColumns(['action','created_at'])
            ->addColumn('action', 'properties.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Property $model)
    {
        return $model->newQuery()
            ->select('properties.*')
            ->orderByDesc('properties.id')
            ->with(['masterfile']);
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
            'name',
            'code',
            'location',
            'property_type',
            'units'=>[
                'title'=>'Number of Units'
            ],
            'masterfile.full_name'=>[
                'title'=>'Landlord'
            ],
//            'created_by',
//            'client_id',
            'created_at'=>[
                'title'=>'View Units'
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
        return 'propertiesdatatable_' . time();
    }
}