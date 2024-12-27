<?php
//app/Model/Keyword.php
namespace Acelle\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Keyword extends Model
{
    protected $table = 'keywords';

    protected $fillable = [
        'uid', 'keyword', 'ranking', 'difficulty', 'date_time', 'status'
    ];

    public static $itemsPerPage = 25;

    // Define the relationship: Each keyword belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'uid'); // `uid` is the foreign key
    }

    /**
     * Format the date_time field.
     *
     * @param string $name
     * @return string
     */
    public function formatDateTime(string $name = 'datetime_full')
    {
        // Attempt to get the current authenticated admin's formatDateTime method
        if (Auth::check() && Auth::user()->admin) {
            return Auth::user()->admin->formatDateTime(Carbon::parse($this->date_time), $name);
        }

        // Fallback to a generic format (24-hour time format)
        return Carbon::parse($this->date_time)->format('F j, Y, H:i');
    }

    public static function search($request)
    {
        $query = self::filter($request);
        $query = $query->orderBy($request->sort_order, $request->sort_direction);
        return $query;
    }

    public function scopeFilter(Builder $query, $filters)
    {
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['keyword'])) {
            $query->where('message', 'like', '%' . $filters['keyword'] . '%');
        }

        return $query;
    }
}
