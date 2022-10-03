<?php
/**
 *  app/Models/File.php
 *
 * Date-Time: 10.06.21
 * Time: 09:55
 * @author Insite LLC <hello@insite.international>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Partner extends Model
{
    use HasFactory;



    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partners';

    protected $appends = [
        'file_full_url'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'path',
        'format',
        'company_name'
    ];


    /**
     * Get the user's file full url.
     *
     * @return string
     */
    public function getFileUrlAttribute(): string
    {
        return $this->path . '/' . $this->title;
    }


    public function getFileFullUrlAttribute(): string
    {
        return asset($this->path . '/' . $this->title);
    }
}
