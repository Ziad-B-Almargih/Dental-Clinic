<?php

namespace App\Services;

use App\Models\Date;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class DatesServices
{
    private array $days = [
        'Saturday',
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
    ];

    public function getDatesThisWeek(): array
    {
        $index = request('page') ?? 0;
        $dates = [];
        foreach ($this->days as $day) {
            $carbon = $this->getDateOf($day)->addDays($index * 7);
            $dates[] = $carbon->format('Y/m/d');
        }

        return $dates;
    }

    private function getDateOf($day): Carbon
    {
        $str = 'this ';
        if ($this->indexOf($day) < $this->indexOf((new Carbon('today'))->dayName))
            $str = 'last ';

        return new Carbon($str . $day);
    }

    private function indexOf(string $day): int
    {
        for ($i = 0; $i < 7; $i++) {
            if ($this->days[$i] == $day)
                return $i;
        }
        return -1;
    }

    public function thereCollision(string $date, string $from, string $to): bool
    {
        return Date::query()
            ->where('date', $date)
            ->where(function (Builder $q) use ($from, $to) {
                return $q
                    ->where(function (Builder $q) use ($from, $to) {
                        return $q
                            ->whereTime('from', '<=', $from)
                            ->WhereTime('to', '>', $from);
                    })
                    ->orWhere(function (Builder $q) use ($from, $to) {
                        return $q
                            ->whereTime('from', '<', $to)
                            ->WhereTime('to', '>=', $to);
                    });
            })->exists();
    }

    public function format(array $data): array
    {
        $dates = [];
        $DaysIndex = -1;
        $DatesIndex = 0;
        $lastDate = 'no date';
        foreach ($data as $item) {
            if ($lastDate != $item['date']) {
                $lastDate = $item['date'];
                $DaysIndex++;
                $dates[$DaysIndex]['day'] = Carbon::createFromDate($item['date'])->dayName;
                $dates[$DaysIndex]['date'] = $item['date'];
                $DatesIndex = 0;
            }
            $dates[$DaysIndex]['dates'][$DatesIndex]['id'] = $item['id'];
            $dates[$DaysIndex]['dates'][$DatesIndex]['from'] = $item['from'];
            $dates[$DaysIndex]['dates'][$DatesIndex++]['to'] = $item['to'];
        }
        return $dates;
    }

    public function nearDate(): ?Date{
        $today = now()->format('Y/m/d');
        $now = now()->format('H:i');
        $date = Date::query()
            ->whereDate('date', $today)
            ->whereTime('from', '>', $now)
            ->orderBy('from')
            ->first();

        return $date;
    }

    public function getNumberOfDatesToday(): int {
        return
            Date::query()
                ->whereDate('date', '=', Carbon::make('today')->toDateString())
                ->count();
    }

}
