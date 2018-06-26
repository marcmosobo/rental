<?php

namespace App\Repositories;

use App\Models\LandlordSettlement;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LandlordSettlementRepository
 * @package App\Repositories
 * @version June 26, 2018, 1:24 pm EAT
 *
 * @method LandlordSettlement findWithoutFail($id, $columns = ['*'])
 * @method LandlordSettlement find($id, $columns = ['*'])
 * @method LandlordSettlement first($columns = ['*'])
*/
class LandlordSettlementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'landlord_id',
        'date',
        'amount_collected',
        'commission_percentage',
        'commission_amount',
        'overdraft'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LandlordSettlement::class;
    }
}
