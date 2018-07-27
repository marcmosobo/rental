<?php

namespace App\Repositories;

use App\Models\OfficeRevenue;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OfficeRevenueRepository
 * @package App\Repositories
 * @version July 27, 2018, 12:17 pm EAT
 *
 * @method OfficeRevenue findWithoutFail($id, $columns = ['*'])
 * @method OfficeRevenue find($id, $columns = ['*'])
 * @method OfficeRevenue first($columns = ['*'])
*/
class OfficeRevenueRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'office_expenditure_id',
        'transaction_type',
        'ref_number',
        'amount',
        'date',
        'created_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OfficeRevenue::class;
    }
}
