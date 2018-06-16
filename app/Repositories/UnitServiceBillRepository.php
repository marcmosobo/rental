<?php

namespace App\Repositories;

use App\Models\UnitServiceBill;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UnitServiceBillRepository
 * @package App\Repositories
 * @version June 15, 2018, 5:29 pm EAT
 *
 * @method UnitServiceBill findWithoutFail($id, $columns = ['*'])
 * @method UnitServiceBill find($id, $columns = ['*'])
 * @method UnitServiceBill first($columns = ['*'])
*/
class UnitServiceBillRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unit_id',
        'service_bill_id',
        'amount',
        'period',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UnitServiceBill::class;
    }
}
