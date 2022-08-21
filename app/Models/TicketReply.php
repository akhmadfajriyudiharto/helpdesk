<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\TicketReply
 *
 * @property int $id
 * @property int|null $ticket_id
 * @property int|null $user_id
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Ticket|null $ticket
 * @property-read Collection|\App\Models\File[] $ticketAttachments
 * @property-read int|null $ticket_attachments_count
 * @property-read \App\Models\User|null $user
 * @method static Builder|TicketReply newModelQuery()
 * @method static Builder|TicketReply newQuery()
 * @method static Builder|TicketReply query()
 * @method static Builder|TicketReply whereBody($value)
 * @method static Builder|TicketReply whereCreatedAt($value)
 * @method static Builder|TicketReply whereId($value)
 * @method static Builder|TicketReply whereTicketId($value)
 * @method static Builder|TicketReply whereUpdatedAt($value)
 * @method static Builder|TicketReply whereUserId($value)
 * @mixin Eloquent
 */
class TicketReply extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function ticketAttachments(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'ticket_attachments');
    }
}
