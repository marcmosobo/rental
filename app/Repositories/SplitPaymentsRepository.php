<?php

namespace App\Repositories;

use App\Models\SplitPayments;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SplitPaymentsRepository
 * @package App\Repositories
 * @version August 1, 2018, 9:17 am EAT
 *
 * @method SplitPayments findWithoutFail($id, $columns = ['*'])
 * @method SplitPayments find($id, $columns = ['*'])
 * @method SplitPayments first($columns = ['*'])
*/
class SplitPaymentsRepository extends BaseRepository
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
        'bank_id',
        'transferred_from',
        'transferred_to',
        'transfered_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SplitPayments::class;
    }
}
