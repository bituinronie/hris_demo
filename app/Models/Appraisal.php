<?php
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Support\Str;

use Illuminate\Support\Carbon;
use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appraisal extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'date',
        'semester',
        'monthFrom',
        'monthTo',
        'remarks',
    ];

    protected $hidden = [
        'employee_id',
        'mfos'
    ];

    protected $casts = [
    ];

    protected $appends = ['numericRating', 'adjectivalRating', 'dateOnDisplay', 'semesterOnDisplay', 'hasMfo', 'is_new', 'isOkToDelete'];

    protected static $logName = 'Appraisal';

    public function mfos()
    {
        return $this->hasMany(Mfo::class);
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName == 'created')
            return 'A Appraisal has been assigned to an employees.';
        if ($eventName == 'updated')
            return 'A Appraisal of an employees has been updated.';
        if ($eventName == 'deleted')
            return 'A Appraisal has been removed from an employees.';
    }

    public function getSemesterOnDisplayAttribute(){
        return match($this->semester) {
            'OTHERS' => Str::upper(Carbon::createFromFormat('m', $this->monthFrom)->format('F').' to '.Carbon::createFromFormat('m', $this->monthTo)->format('F')),
            default => $this->semester
        };
    }

    public function getNumericRatingAttribute()
    {
        return number_format($this->rawNumericRating,3,'.');
    }

    public function getRawNumericRatingAttribute()
    {
        $items = $this->mfos->filter(fn($item) => $item->rawAverageRating)->map(fn($item) => $item->rawAverageRating);

        return $items->isEmpty() ? 0 : $items->sum() / $items->count();
    }

    public function getAdjectivalRatingAttribute()
    {
        $rating = null;

        if ($this->rawNumericRating < 1)
            $rating = 'Not Applicable';
        else if ($this->rawNumericRating < 2)
            $rating = 'Poor';
        else if ($this->rawNumericRating < 3)
            $rating = 'Unsatisfactory';
        else if ($this->rawNumericRating < 4)
            $rating = 'Satisfactory';
        else if ($this->rawNumericRating < 5)
            $rating = 'Very Satisfactory';
        else
            $rating = 'Outstanding';

        return $rating;
    }

    public function getAdjectivalRatingCodeAttribute()
    {
        $rating = null;

        if ($this->rawNumericRating < 1)
            $rating = 'NA';
        else if ($this->rawNumericRating < 2)
            $rating = 'P';
        else if ($this->rawNumericRating < 3)
            $rating = 'US';
        else if ($this->rawNumericRating < 4)
            $rating = 'S';
        else if ($this->rawNumericRating < 5)
            $rating = 'VS';
        else
            $rating = 'O';

        return $rating;
    }

    public function getDateOnDisplayAttribute()
    {
        return Carbon::parse($this->date)->format('F d, Y');
    }

    public function getHasMfoAttribute()
    {
        return $this->mfos?->first() ? true : false;
    }

    public function getIsOkToDeleteAttribute()
    {
        return $this->mfos?->first() ? false : true;
        
    }
}