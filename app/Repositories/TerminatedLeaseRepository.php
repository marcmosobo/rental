<?php

namespace App\Repositories;

use App\Models\TerminatedLease;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TerminatedLeaseRepository
 * @package App\Repositories
 * @version July 2, 2018, 12:56 pm EAT
 *
 * @method TerminatedLease findWithoutFail($id, $columns = ['*'])
 * @method TerminatedLease find($id, $columns = ['*'])
 * @method TerminatedLease first($columns = ['*'])
*/
class TerminatedLeaseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unit_id',
        'property_id',
        'tenant_id',
        'start_date',
        'status',
        'created_by',
        'client_id',
        'is_reversed',
        'reversed_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TerminatedLease::class;
    }
}
