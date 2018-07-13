<?php

namespace App\DataTables;

use App\Models\PropertyListing;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PropertyListingDataTable extends DataTable
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
            ->editColumn('status',function ($prop){
                if(!$prop->status){
                    return '<label class="label label-success">available</label>';
                }
                return '<label class="label label-info">sold</label>';
            })
            ->rawColumns(['action','status'])
            ->addColumn('action', 'property_listings.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PropertyListing $model)
    {
        return $model->newQuery()->with(['type','masterfile']);
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
                'title'=> 'Customer'
            ],
            'type.name'=>[
                'title'=>"Property Type"
            ],
            'location',
            'description',
            'price',
            'sale_commission',
            'status',
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
        return 'property_listingsdatatable_' . time();
    }
}