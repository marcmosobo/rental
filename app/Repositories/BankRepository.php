<?php

namespace App\Repositories;

use App\Models\Bank;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BankRepository
 * @package App\Repositories
 * @version June 23, 2018, 8:52 am EAT
 *
 * @method Bank findWithoutFail($id, $columns = ['*'])
 * @method Bank find($id, $columns = ['*'])
 * @method Bank first($columns = ['*'])
*/
class BankRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'branch',
        'account_number'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bank::class;
    }
}
