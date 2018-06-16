<?php

namespace App\Repositories;

use App\Models\PayBill;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PayBillRepository
 * @package App\Repositories
 * @version June 16, 2018, 9:07 pm EAT
 *
 * @method PayBill findWithoutFail($id, $columns = ['*'])
 * @method PayBill find($id, $columns = ['*'])
 * @method PayBill first($columns = ['*'])
*/
class PayBillRepository extends BaseRepository
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
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PayBill::class;
    }
}
