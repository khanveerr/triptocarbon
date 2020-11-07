<?php

namespace App\Http\Controllers;

use App\Footprint;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class FootprintController extends Controller
{
    //
    public function save($data = array())
    {
        
        try {
            return ['status' => 'success', 'data' => Footprint::create($data)];
        } catch (\Illuminate\Database\QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            return ['status' => 'failure', 'errors' => $exception->errorInfo];
        }

    }

}
