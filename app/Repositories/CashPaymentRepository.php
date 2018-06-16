<?php

namespace App\Repositories;

use App\Models\CashPayment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CashPaymentRepository
 * @package App\Repositories
 * @version June 16, 2018, 8:25 pm EAT
 *
 * @method CashPayment findWithoutFail($id, $columns = ['*'])
 * @method CashPayment find($id, $columns = ['*'])
 * @method CashPayment first($columns = ['*'])
*/
class CashPaymentRepository extends BaseRepository
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
        'created_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CashPayment::class;
    }
}
