<?php

namespace App\Repositories;

use App\Models\Tenant;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TenantRepository
 * @package App\Repositories
 * @version June 14, 2018, 9:55 am EAT
 *
 * @method Tenant findWithoutFail($id, $columns = ['*'])
 * @method Tenant find($id, $columns = ['*'])
 * @method Tenant first($columns = ['*'])
*/
class TenantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'full_name',
        'national_id',
        'gender',
        'phone_number',
        'email',
        'b_role',
        'created_by',
        'client_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tenant::class;
    }
}
