<?php

namespace App\Repositories;

use App\Models\OfficeExpenditure;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OfficeExpenditureRepository
 * @package App\Repositories
 * @version July 27, 2018, 12:07 pm EAT
 *
 * @method OfficeExpenditure findWithoutFail($id, $columns = ['*'])
 * @method OfficeExpenditure find($id, $columns = ['*'])
 * @method OfficeExpenditure first($columns = ['*'])
*/
class OfficeExpenditureRepository extends BaseRepository
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
        return OfficeExpenditure::class;
    }
}
