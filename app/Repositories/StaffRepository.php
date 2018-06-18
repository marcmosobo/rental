<?php

namespace App\Repositories;

use App\Models\Staff;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StaffRepository
 * @package App\Repositories
 * @version June 18, 2018, 9:58 am EAT
 *
 * @method Staff findWithoutFail($id, $columns = ['*'])
 * @method Staff find($id, $columns = ['*'])
 * @method Staff first($columns = ['*'])
*/
class StaffRepository extends BaseRepository
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
        return Staff::class;
    }
}
