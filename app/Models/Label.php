<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Label
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Ticket[] $tickets
 * @property-read int|null $tickets_count
 * @method static Builder|Label newModelQuery()
 * @method static Builder|Label newQuery()
 * @method static Builder|Label query()
 * @method static Builder|Label whereColor($value)
 * @method static Builder|Label whereCreatedAt($value)
 * @method static Builder|Label whereId($value)
 * @method static Builder|Label whereName($value)
 * @method static Builder|Label whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Label extends Model
{
    use HasFactory;

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'ticket_labels');
    }
}
