<?php

namespace App\Models;

use Eloquent;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Storage;

/**
 * App\Models\File
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $server_name
 * @property int $size
 * @property string $mime
 * @property string $extension
 * @property string $disk
 * @property string $path
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|File filter($input = [], $filter = null)
 * @method static Builder|File newModelQuery()
 * @method static Builder|File newQuery()
 * @method static Builder|File paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|File query()
 * @method static Builder|File simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|File whereBeginsWith($column, $value, $boolean = 'and')
 * @method static Builder|File whereCreatedAt($value)
 * @method static Builder|File whereDisk($value)
 * @method static Builder|File whereEndsWith($column, $value, $boolean = 'and')
 * @method static Builder|File whereExtension($value)
 * @method static Builder|File whereId($value)
 * @method static Builder|File whereLike($column, $value, $boolean = 'and')
 * @method static Builder|File whereMime($value)
 * @method static Builder|File whereName($value)
 * @method static Builder|File wherePath($value)
 * @method static Builder|File whereServerName($value)
 * @method static Builder|File whereSize($value)
 * @method static Builder|File whereUpdatedAt($value)
 * @method static Builder|File whereUserId($value)
 * @method static Builder|File whereUuid($value)
 * @mixin Eloquent
 */
class File extends Model
{
    use Filterable, HasFactory;

    public function url(): ?string
    {
        if ($this->disk === 'public') {
            return Storage::disk($this->disk)->url($this->path.DIRECTORY_SEPARATOR.$this->server_name);
        }
        return null;
    }

    public function download(): string
    {
        return route('files.download', $this->uuid);
    }

    public function ticketReply(): ?TicketReply
    {
        return TicketReply::whereHas('ticketAttachments', function (Builder $builder) {
            return $builder->where('file_id', $this->id);
        })->first();
    }
}
