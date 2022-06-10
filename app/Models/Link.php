<?php

namespace App\Models;

use App\Models\Traits\SearchableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $title
 * @property string $link
 * @property int    $new_tab
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Link extends Model
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
        'link',
        'new_tab',
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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['new_tab' => 'int'];

    /**
     * Searchable columns for SearchTrait
     *
     * @var array
     */
    protected static $searchables = ['title', 'link'];
}
