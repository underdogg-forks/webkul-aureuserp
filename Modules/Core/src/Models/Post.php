<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Database\Factories\PostFactory;
use Modules\Core\Models\User;
class Post extends BaseModel
{
    use HasFactory;

    use SoftDeletes;

    public $timestamps = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
    /**
     * protected $fillable = [
     * 'title',
     * 'sub_title',
     * 'content',
     * 'slug',
     * 'image',
     * 'author_name',
     * 'is_published',
     * 'published_at',
     * 'visits',
     * 'meta_title',
     * 'meta_keywords',
     * 'meta_description',
     * 'category_id',
     * 'author_id',
     * 'creator_id',
     * 'last_editor_id',
     * ];
     */
    protected $guarded = [];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'blogs_posts';

    #region Static Methods
    /*
    |--------------------------------------------------------------------------
    | Static Methods
    |--------------------------------------------------------------------------
    */

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastEditor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggables');
    }

    #endregion

    #region Accessors
    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get image url for the product image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if ( ! $this->image) {
            return;
        }

        return Storage::url($this->image);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));

        $minutes = ceil($wordCount / 200);

        return $minutes . ' min read';
    }

    #endregion

    #region Mutators
    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    #endregion

    #region Scopes
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #endregion

    #region Factory
    /*
    |--------------------------------------------------------------------------
    | Factory
    |--------------------------------------------------------------------------
    */

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }

    #endregion
}
