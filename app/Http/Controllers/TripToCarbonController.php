<?php

namespace App\Http\Controllers;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use Cache;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\FootprintController;

class TripToCarbonController extends Controller
{

    /**
     * Consume Third Party API
     *
     * @return void
     */
    public function index(Request $request)
    {
        // Validating required parameters for calling third party API
        $validator = Validator::make($request->all(), [
            'activity' => 'required|numeric',
            'activityType' => ['required',Rule::in(['miles', 'fuel'])],
            'country' => ['required',Rule::in(['usa', 'gbr', 'def'])],
            'fuelType' => [Rule::in(['motorGasoline', 'diesel', 'aviationGasoline', 'jetFuel'])],
            'mode' => [Rule::in(['dieselCar', 'petrolCar', 'anyCar', 'taxi', 'economyFlight', 'businessFlight', 'firstclassFlight', 'anyFlight', 'motorbike', 'bus', 'transitRail'])]
        ]);

        // Check if validation fails and send appropriate error message in API response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = $request->all();

        if($data['activityType'] == "fuel" && !isset($data['fuelType'])) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['fuelType' => ['Fuel Type is required']]
            ], 400);
        }

        if($data['activityType'] == "miles" && !isset($data['mode'])) {
            return response()->json([
                'status' => 'failure',
                'errors' => ['mode' => ['Mode is required']]
            ], 400);
        }

        // Setting parameters for callling external API
        $params = [
            'query' => $data
        ];

        if($data['activityType'] == "fuel") {
            unset($data['mode']);
        }

        if($data['activityType'] == "miles") {
            unset($data['fuelType']);
        }


        $key_array = [];
        foreach($data as $key => $value) {
            $key_array[] = $value;
        };


        /**
         * Creating a key for saving response in cache
         * This key will later use to get the already saved response from cache
         */
        $key_array = implode("_",$key_array);

        // Checking if key is available in cache
        if (Cache::has($key_array)){

            $json_response = Cache::get($key_array);
            $decode_response = json_decode($json_response);

        } else {

            $client = new \GuzzleHttp\Client();
            
            // Calling third party API
            try {
                $response = $client->request('GET', 'https://api.triptocarbon.xyz/v1/footprint', $params);
                $json_response = $response->getBody()->getContents();

                // Save response in Cache
                Cache::put($key_array, $json_response, 24*60);

                $decode_response = json_decode($json_response);
                
                $data['response'] = $decode_response->carbonFootprint;
                
                // Save request and response in database
                $db_response = (new FootprintController)->save($data);
                if($db_response['status'] == 'failure') {
                    return response()->json(['status' => 'failure', 'errors' => $db_response['errors'], 'message' => 'Error saving data'], 400);
                }

            } catch (ClientException $e) {
                // Throws an error if there will be any external API error
                $response = $e->getResponse();
                $json_response = json_decode($response->getBody()->getContents());
                return response()->json(['status' => 'failure', 'errors' => $json_response->invalidParameters, 'message' => 'Error fetching API'], 400);
            }
        }
        
        return response()->json($decode_response);
    }
}
