<?php

namespace App\Repositories;

use App\Models\PaymentTransfer;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PaymentTransferRepository
 * @package App\Repositories
 * @version July 11, 2018, 2:45 pm EAT
 *
 * @method PaymentTransfer findWithoutFail($id, $columns = ['*'])
 * @method PaymentTransfer find($id, $columns = ['*'])
 * @method PaymentTransfer first($columns = ['*'])
*/
class PaymentTransferRepository extends BaseRepository
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
        return PaymentTransfer::class;
    }
}
