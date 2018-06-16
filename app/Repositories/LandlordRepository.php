<?php

namespace App\Repositories;

use App\Models\Landlord;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LandlordRepository
 * @package App\Repositories
 * @version June 13, 2018, 3:51 pm EAT
 *
 * @method Landlord findWithoutFail($id, $columns = ['*'])
 * @method Landlord find($id, $columns = ['*'])
 * @method Landlord first($columns = ['*'])
*/
class LandlordRepository extends BaseRepository
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
        return Landlord::class;
    }
}
