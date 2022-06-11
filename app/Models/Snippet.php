<?php

namespace App\Models;

use App\Models\Traits\SearchableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use MasterRO\LaravelXSSFilter\XSSCleanerFacade;

/**
 * @property int    $id
 * @property string $title
 * @property string $code
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Snippet extends Model
{
    // Simple text search
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'code',
        'desc',
    ];

    /**
     * Dates attributes
     *
     * @var array<int, string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Code attribute mutator
     *
     * @param string $val
     *
     * @return void
     */
    public function setCodeAttribute($val)
    {
        if ($val != null){
            $val = XSSCleanerFacade::clean($val);
        }
        $this->attributes['code'] = $val;
    }

    /**
     * Searchable columns for SearchTrait
     *
     * @var array
     */
    protected static $searchables = ['title'];
}
