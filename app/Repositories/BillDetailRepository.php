<?php

namespace App\Repositories;

use App\Models\BillDetail;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BillDetailRepository
 * @package App\Repositories
 * @version June 16, 2018, 1:39 pm EAT
 *
 * @method BillDetail findWithoutFail($id, $columns = ['*'])
 * @method BillDetail find($id, $columns = ['*'])
 * @method BillDetail first($columns = ['*'])
*/
class BillDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'bill_id',
        'service_bill_id',
        'amount',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BillDetail::class;
    }
}
