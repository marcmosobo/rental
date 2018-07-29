<?php

namespace App\Repositories;

use App\Models\LandlordAccount;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LandlordAccountRepository
 * @package App\Repositories
 * @version July 29, 2018, 8:41 am EAT
 *
 * @method LandlordAccount findWithoutFail($id, $columns = ['*'])
 * @method LandlordAccount find($id, $columns = ['*'])
 * @method LandlordAccount first($columns = ['*'])
*/
class LandlordAccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'loan_id',
        'landlord_id',
        'reference',
        'transaction_type',
        'amount',
        'date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LandlordAccount::class;
    }
}
