<?php

namespace App\Repositories;

use App\Models\LoanPayment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LoanPaymentRepository
 * @package App\Repositories
 * @version July 29, 2018, 9:35 am EAT
 *
 * @method LoanPayment findWithoutFail($id, $columns = ['*'])
 * @method LoanPayment find($id, $columns = ['*'])
 * @method LoanPayment first($columns = ['*'])
*/
class LoanPaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'loan_id',
        'landlord_id',
        'reference',
        'transaction_type',
        'amount',
        'date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LoanPayment::class;
    }
}
