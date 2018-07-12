<?php

namespace App\Repositories;

use App\Models\LandlordRemittance;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LandlordRemittanceRepository
 * @package App\Repositories
 * @version July 12, 2018, 7:02 pm EAT
 *
 * @method LandlordRemittance findWithoutFail($id, $columns = ['*'])
 * @method LandlordRemittance find($id, $columns = ['*'])
 * @method LandlordRemittance first($columns = ['*'])
*/
class LandlordRemittanceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'landlord_id',
        'amount',
        'remitted_by',
        'date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LandlordRemittance::class;
    }
}
