<?php

namespace App\Models;

use Eloquent;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property string $uuid
 * @property string $subject
 * @property int|null $status_id
 * @property int|null $priority_id
 * @property int|null $department_id
 * @property int|null $user_id
 * @property int|null $agent_id
 * @property int|null $closed_by
 * @property Carbon|null $closed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $agent
 * @property-read User $closedBy
 * @property-read Department|null $department
 * @property-read Collection|Label[] $labels
 * @property-read int|null $labels_count
 * @property-read Priority|null $priority
 * @property-read Status|null $status
 * @property-read Collection|TicketReply[] $ticketReplies
 * @property-read int|null $ticket_replies_count
 * @property-read User|null $user
 * @method static Builder|Ticket filter($input = [], $filter = null)
 * @method static Builder|Ticket newModelQuery()
 * @method static Builder|Ticket newQuery()
 * @method static Builder|Ticket paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Ticket query()
 * @method static Builder|Ticket simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Ticket whereAgentId($value)
 * @method static Builder|Ticket whereBeginsWith($column, $value, $boolean = 'and')
 * @method static Builder|Ticket whereClosedAt($value)
 * @method static Builder|Ticket whereClosedBy($value)
 * @method static Builder|Ticket whereCreatedAt($value)
 * @method static Builder|Ticket whereDepartmentId($value)
 * @method static Builder|Ticket whereEndsWith($column, $value, $boolean = 'and')
 * @method static Builder|Ticket whereId($value)
 * @method static Builder|Ticket whereLike($column, $value, $boolean = 'and')
 * @method static Builder|Ticket wherePriorityId($value)
 * @method static Builder|Ticket whereStatusId($value)
 * @method static Builder|Ticket whereSubject($value)
 * @method static Builder|Ticket whereUpdatedAt($value)
 * @method static Builder|Ticket whereUserId($value)
 * @method static Builder|Ticket whereUuid($value)
 * @mixin Eloquent
 */
class Ticket extends Model
{
    use Filterable, HasFactory;

    protected $casts = [
        'status_id' => 'integer',
        'priority_id' => 'integer',
        'department_id' => 'integer',
        'user_id' => 'integer',
        'agent_id' => 'integer',
        'closed_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticketReplies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'ticket_labels');
    }

    public function verifyUser(User $user): bool
    {
        if ($user->role_id !== 1) {
            $userId = $user->id;
            return $this->department_id === null || ($this->department->all_agents || $this->department->agent()->pluck('id')->contains($userId)) || ($this->agent_id === null || $this->agent_id === $userId) || $this->closed_by === $userId;
        }
        return true;
    }
}
