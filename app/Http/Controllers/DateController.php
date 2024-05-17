<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDateRequest;
use App\Models\Date;
use App\Services\DatesServices;
use Illuminate\Http\JsonResponse;

class DateController extends Controller
{

    public function __construct(
        private readonly DatesServices $datesServices
    )
    {
    }

    public function index(): JsonResponse
    {

        $dates =$this->datesServices->getDatesThisWeek();
        $data = Date::query()
            ->whereIn('date', $dates)
            ->orderBy('date')
            ->orderBy('from')
            ->get();
        return $this->success(
            $this->datesServices->format($data->toArray())
        );
    }



    public function create(CreateDateRequest $request): JsonResponse
    {
        $data = $request->validated();

        if($this->datesServices->thereCollision($data['date'], $data['from'], $data['to']))
            return $this->failed('there collision');

        $date = Date::query()
            ->create($data);

        return $this->success($date, 'created', 201);
    }

    public function delete(Date $date): JsonResponse
    {
        $date->delete();

        return $this->noResponse();
    }

}
