<?php

namespace App\Models;

use Eloquent;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CannedReply
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $body
 * @property int $shared
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @method static Builder|CannedReply filter($input = [], $filter = null)
 * @method static Builder|CannedReply newModelQuery()
 * @method static Builder|CannedReply newQuery()
 * @method static Builder|CannedReply paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|CannedReply query()
 * @method static Builder|CannedReply simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|CannedReply whereBeginsWith($column, $value, $boolean = 'and')
 * @method static Builder|CannedReply whereBody($value)
 * @method static Builder|CannedReply whereCreatedAt($value)
 * @method static Builder|CannedReply whereEndsWith($column, $value, $boolean = 'and')
 * @method static Builder|CannedReply whereId($value)
 * @method static Builder|CannedReply whereLike($column, $value, $boolean = 'and')
 * @method static Builder|CannedReply whereName($value)
 * @method static Builder|CannedReply whereShared($value)
 * @method static Builder|CannedReply whereUpdatedAt($value)
 * @method static Builder|CannedReply whereUserId($value)
 * @mixin Eloquent
 */
class CannedReply extends Model
{
    use Filterable, HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
