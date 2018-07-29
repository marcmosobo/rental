<?php

namespace App\Repositories;

use App\Models\Loan;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LoanRepository
 * @package App\Repositories
 * @version July 29, 2018, 8:09 am EAT
 *
 * @method Loan findWithoutFail($id, $columns = ['*'])
 * @method Loan find($id, $columns = ['*'])
 * @method Loan first($columns = ['*'])
*/
class LoanRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'landlord_id',
        'principle',
        'rate',
        'loan_date',
        'created_by',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Loan::class;
    }
}
