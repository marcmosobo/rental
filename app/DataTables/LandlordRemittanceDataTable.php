<?php

namespace App\DataTables;

use App\Http\Controllers\LoggedUserController;
use App\Models\LandlordRemittance;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LandlordRemittanceDataTable extends DataTable
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
            ->editColumn('date',function ($expense){
                return Carbon::parse($expense->date)->toFormattedDateString();
            })
            ->addColumn('action', 'landlord_remittances.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LandlordRemittance $model)
    {
        return $model->newQuery()
            ->select('landlord_remittances.*')
            ->orderByDesc('landlord_remittances.id')
            ->with(['masterfile']);
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
        }else{
            return $this->builder()
                ->columns($this->getColumns())
                ->minifiedAjax()
//                ->addAction(['width' => '80px'])
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
            'payment_mode',
            'amount',
            'date'
//            'remitted_by',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'landlord_remittancesdatatable_' . time();
    }
}