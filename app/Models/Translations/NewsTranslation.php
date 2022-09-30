<?php
/**
 *  app/Models/Translations/ProductTranslation.php
 *
 * Date-Time: 30.07.21
 * Time: 10:34
 * @author Insite LLC <hello@insite.international>
 */
namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends BaseTranslationModel
{
    use HasFactory;

    protected $table = 'news_translations';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'text',
    ];
}
