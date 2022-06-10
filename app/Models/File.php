<?php

namespace App\Models;

use App\Models\Traits\SearchableTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @property int    $id
 * @property string $title
 * @property string $filename
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class File extends Model
{
    // Simple text search
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file',
        'title',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['public_path'];

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
     * Searchable columns for SearchTrait
     *
     * @var array
     */
    protected static $searchables = ['title'];

    /**
     * File attribute mutator for uploading the file directly through mass assignment
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return void
     */
    public function setFileAttribute(UploadedFile $file)
    {
        $filename = time() . rand(0, 999) . "." . $file->getClientOriginalExtension();
        if (!Storage::put($filename, $file->getContent())) {
            throw new Exception('Error uploading the file.');
        }
        $this->attributes['filename'] = $filename;
        return true;
    }

    /**
     * Return public path of the file
     *
     * @return string
     */
    public function getPublicPathAttribute()
    {
        return config('app.url') . 'storage/' . $this->filename;
    }

    /** Model Boot Function */
    public static function boot()
    {
        parent::boot();

        // Delete stored file from drive once deleted
        self::deleting(function (self $model) {
            Storage::delete($model->filename);
        });
    }
}
