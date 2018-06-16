<?php

namespace App\Repositories;

use App\Models\Bill;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BillRepository
 * @package App\Repositories
 * @version June 16, 2018, 1:38 pm EAT
 *
 * @method Bill findWithoutFail($id, $columns = ['*'])
 * @method Bill find($id, $columns = ['*'])
 * @method Bill first($columns = ['*'])
*/
class BillRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'lease_id',
        'tenant_id',
        'property_id',
        'description',
        'ref_number',
        'total'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bill::class;
    }
}
