<?php

namespace App\Repositories;

use App\Models\Expenditure;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ExpenditureRepository
 * @package App\Repositories
 * @version July 12, 2018, 6:21 pm EAT
 *
 * @method Expenditure findWithoutFail($id, $columns = ['*'])
 * @method Expenditure find($id, $columns = ['*'])
 * @method Expenditure first($columns = ['*'])
*/
class ExpenditureRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Expenditure::class;
    }
}
