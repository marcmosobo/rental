<?php

namespace App\Repositories;

use App\Models\Masterfile;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MasterfileRepository
 * @package App\Repositories
 * @version May 17, 2018, 5:33 pm EAT
 *
 * @method Masterfile findWithoutFail($id, $columns = ['*'])
 * @method Masterfile find($id, $columns = ['*'])
 * @method Masterfile first($columns = ['*'])
*/
class MasterfileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'full_name',
        'gender',
        'email',
        'phone_number',
        'role_id',
        'address',
        'national_id',
        'created_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Masterfile::class;
    }
}
