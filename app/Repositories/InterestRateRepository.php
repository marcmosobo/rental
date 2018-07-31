<?php

namespace App\Repositories;

use App\Models\InterestRate;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class InterestRateRepository
 * @package App\Repositories
 * @version July 31, 2018, 9:04 am EAT
 *
 * @method InterestRate findWithoutFail($id, $columns = ['*'])
 * @method InterestRate find($id, $columns = ['*'])
 * @method InterestRate first($columns = ['*'])
*/
class InterestRateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'rate'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return InterestRate::class;
    }
}
