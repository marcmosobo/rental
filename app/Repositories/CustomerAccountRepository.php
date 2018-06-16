<?php

namespace App\Repositories;

use App\Models\CustomerAccount;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CustomerAccountRepository
 * @package App\Repositories
 * @version June 16, 2018, 1:40 pm EAT
 *
 * @method CustomerAccount findWithoutFail($id, $columns = ['*'])
 * @method CustomerAccount find($id, $columns = ['*'])
 * @method CustomerAccount first($columns = ['*'])
*/
class CustomerAccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tenant_id',
        'lease_id',
        'unit_id',
        'bill_id',
        'payment_id',
        'ref_number',
        'transaction_type',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CustomerAccount::class;
    }
}
