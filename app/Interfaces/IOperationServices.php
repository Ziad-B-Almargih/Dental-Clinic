<?php

namespace App\Interfaces;

use App\Models\Patient;

interface IOperationServices
{
    public function index(Patient $patient, ?int $number);

    public function create(array $data);
}
