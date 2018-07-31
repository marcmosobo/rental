<?php

namespace App\Repositories;

use App\Models\LandlordBank;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LandlordBankRepository
 * @package App\Repositories
 * @version July 31, 2018, 8:21 am EAT
 *
 * @method LandlordBank findWithoutFail($id, $columns = ['*'])
 * @method LandlordBank find($id, $columns = ['*'])
 * @method LandlordBank first($columns = ['*'])
*/
class LandlordBankRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'landlord_id',
        'account_number'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LandlordBank::class;
    }
}
