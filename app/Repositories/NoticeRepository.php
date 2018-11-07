<?php

namespace App\Repositories;

use App\Models\Notice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NoticeRepository
 * @package App\Repositories
 * @version August 12, 2018, 2:38 am EAT
 *
 * @method Notice findWithoutFail($id, $columns = ['*'])
 * @method Notice find($id, $columns = ['*'])
 * @method Notice first($columns = ['*'])
*/
class NoticeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'body'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notice::class;
    }
}
