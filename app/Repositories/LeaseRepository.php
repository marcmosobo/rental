<?php

namespace App\Repositories;

use App\Models\Lease;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LeaseRepository
 * @package App\Repositories
 * @version June 16, 2018, 9:23 am EAT
 *
 * @method Lease findWithoutFail($id, $columns = ['*'])
 * @method Lease find($id, $columns = ['*'])
 * @method Lease first($columns = ['*'])
*/
class LeaseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unit_id',
        'tenant_id',
        'start_date',
        'status',
        'created_by',
        'client_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Lease::class;
    }
}
