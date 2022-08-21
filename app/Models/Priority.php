<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Priority
 *
 * @property int $id
 * @property int $value
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Priority newModelQuery()
 * @method static Builder|Priority newQuery()
 * @method static Builder|Priority query()
 * @method static Builder|Priority whereCreatedAt($value)
 * @method static Builder|Priority whereId($value)
 * @method static Builder|Priority whereName($value)
 * @method static Builder|Priority whereUpdatedAt($value)
 * @method static Builder|Priority whereValue($value)
 * @mixin Eloquent
 */
class Priority extends Model
{
    use HasFactory;
}
