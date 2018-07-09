<?php

namespace App\Repositories;

use App\Models\UnprocessedPayment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UnprocessedPaymentRepository
 * @package App\Repositories
 * @version July 9, 2018, 2:35 pm EAT
 *
 * @method UnprocessedPayment findWithoutFail($id, $columns = ['*'])
 * @method UnprocessedPayment find($id, $columns = ['*'])
 * @method UnprocessedPayment first($columns = ['*'])
*/
class UnprocessedPaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'payment_mode',
        'house_number',
        'tenant_id',
        'ref_number',
        'amount',
        'paybill',
        'phone_number',
        'BillRefNumber',
        'TransID',
        'TransTime',
        'FirstName',
        'middleName',
        'LastName',
        'received_on',
        'client_id',
        'created_by',
        'status',
        'updated_by',
        'bank_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UnprocessedPayment::class;
    }
}
