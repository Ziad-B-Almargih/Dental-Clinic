<?php

namespace App\Http\Controllers;

use App\Services\DebtsServices;
use Illuminate\Http\Request;

class DebtsController extends Controller
{
    public function __invoke()
    {
        return $this->success(
            DebtsServices::debts()
        );
    }
}
