<?php
/**
 *
 *
 * Date-Time: 07.06.21
 * Time: 17:02
 * @author alex
 */

namespace App\Repositories\Eloquent;


use App\Models\Category;
use App\Models\CategoryColor;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class CategoryColorRepository extends BaseRepository
{

    public function __construct(CategoryColor $model)
    {
        parent::__construct($model);
    }





}
