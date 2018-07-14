<?php

namespace App\Repositories;

use App\Models\OpeningBalance;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OpeningBalanceRepository
 * @package App\Repositories
 * @version July 14, 2018, 11:28 am EAT
 *
 * @method OpeningBalance findWithoutFail($id, $columns = ['*'])
 * @method OpeningBalance find($id, $columns = ['*'])
 * @method OpeningBalance first($columns = ['*'])
*/
class OpeningBalanceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'landlord_id',
        'opening_balance'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OpeningBalance::class;
    }
}
