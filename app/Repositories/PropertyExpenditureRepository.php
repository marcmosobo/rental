<?php

namespace App\Repositories;

use App\Models\PropertyExpenditure;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PropertyExpenditureRepository
 * @package App\Repositories
 * @version July 12, 2018, 6:22 pm EAT
 *
 * @method PropertyExpenditure findWithoutFail($id, $columns = ['*'])
 * @method PropertyExpenditure find($id, $columns = ['*'])
 * @method PropertyExpenditure first($columns = ['*'])
*/
class PropertyExpenditureRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'expenditure_id',
        'property_id',
        'landlord_id',
        'created_by',
        'amount',
        'date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PropertyExpenditure::class;
    }
}
