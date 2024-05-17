<?php

namespace App\Http\Controllers;

use App\Http\Resources\NearDateResource;
use App\Models\Date;
use App\Models\Patient;
use App\Services\DatesServices;
use App\Services\DebtsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomePageController extends Controller
{
    public function __construct(
        private readonly DatesServices $datesServices
    )
    {
    }

    public function __invoke()
    {
        $patientsNumber = Patient::query()->count();
        $datesNumber = $this->datesServices->getNumberOfDatesToday();
        $totalDebts = DebtsServices::totalDebts();
        $date = $this->datesServices->nearDate();
        $nearDate = null;
        if($date){
            $nearDate = NearDateResource::make($date);
        }
        return $this->success([
            'patients_number' => $patientsNumber,
            'dates_number' => $datesNumber,
            'total_debts' => $totalDebts,
            'near_date' => $nearDate,
        ]);
    }


}
