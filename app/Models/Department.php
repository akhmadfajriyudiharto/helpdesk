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
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property int $all_agents
 * @property int $public
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|User[] $agent
 * @property-read int|null $agent_count
 * @method static Builder|Department newModelQuery()
 * @method static Builder|Department newQuery()
 * @method static Builder|Department query()
 * @method static Builder|Department whereAllAgents($value)
 * @method static Builder|Department whereCreatedAt($value)
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereName($value)
 * @method static Builder|Department wherePublic($value)
 * @method static Builder|Department whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Department extends Model
{
    use HasFactory;

    public function agent(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_departments', 'department_id', 'user_id');
    }

    public function agents()
    {
        if (!$this->all_agents) {
            return $this->agent->all();
        }
        return User::whereIn('role_id', UserRole::where('dashboard_access', true)->pluck('id'))
            ->where('status', true)
            ->get();
    }
}
