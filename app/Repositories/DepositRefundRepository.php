<?php

namespace App\Repositories;

use App\Models\DepositRefund;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepositRefundRepository
 * @package App\Repositories
 * @version July 26, 2018, 2:54 pm EAT
 *
 * @method DepositRefund findWithoutFail($id, $columns = ['*'])
 * @method DepositRefund find($id, $columns = ['*'])
 * @method DepositRefund first($columns = ['*'])
*/
class DepositRefundRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'lease_id',
        'amount',
        'refunded_by',
        'refund_date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DepositRefund::class;
    }
}
