<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Cart\Cart;
use App\Models\CartItem;
use App\Models\File;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\SliderRepositoryInterface;
use ReflectionClass;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class CartItemRepository extends BaseRepository
{

    public function __construct(CartItem $model)
    {
        parent::__construct($model);
    }



}
