<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Mfo extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'appraisal_id',
        'number',
        'title',
        'description',
        'Q',
        'E',
        'T',
    ];

    protected $hidden = [
        'appraisal_id',
    ];

    protected $casts = [
    ];

    protected $appends = ['is_new', 'averageRating', 'adjectivalRating'];

    protected static $logName = 'Mfo';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName == 'created')
            return 'A Mfo has been assigned to an appraisals.';
        if ($eventName == 'updated')
            return 'A Mfo of an appraisals has been updated.';
        if ($eventName == 'deleted')
            return 'A Mfo has been removed from an appraisals.';
    }

    public function getAverageRatingAttribute()
    {
        return number_format(round($this->rawAverageRating, 3), 3, '.') ?? 'NAN';
    }

    public function getRawAverageRatingAttribute()
    {
        $items = collect(['Q', 'E', 'T'])->filter(fn($key) => $this->{ $key})->map(fn($key) => $this->{ $key});

        return $items->isEmpty() ? 0 : $items->sum() / $items->count();
    }

    public function getAdjectivalRatingAttribute()
    {
        $rating = null;

        if ($this->rawAverageRating < 1)
            $rating = 'Not Applicable';
        else if ($this->rawAverageRating < 2)
            $rating = 'Poor';
        else if ($this->rawAverageRating < 3)
            $rating = 'Unsatisfactory';
        else if ($this->rawAverageRating < 4)
            $rating = 'Satisfactory';
        else if ($this->rawAverageRating < 5)
            $rating = 'Very Satisfactory';
        else
            $rating = 'Outstanding';

        return $rating;
    }

}