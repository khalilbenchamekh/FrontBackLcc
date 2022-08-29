<?php

namespace App\Services\Fees;



interface IFeesService
{
    public function index($request);
    public function saveBusinessFees($request);
    public function show();
    public function update();
    public function destroy();
}

