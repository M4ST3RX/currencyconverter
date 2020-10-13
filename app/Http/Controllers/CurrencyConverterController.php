<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyConverterController extends Controller
{
    public function favouritesAndHistory() {
        return view('history');
    }

    public function index() {
        return view('welcome');
    }

    public function api_currencies() {
        $ch = curl_init("http://www.floatrates.com/daily/gbp.xml");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = curl_exec($ch); // execute curl request
        curl_close($ch);

        $xml = simplexml_load_string($data);

        $data = [];

        $data[] = [
            "currency" => "gbp",
            "name" => "U.K. Pounds",
            "exchangeRate" => 1,
            "inverseRate" => 1
        ];

        foreach ($xml->item as $item) {
            $data[] = [
                "currency" => strtolower($item->targetCurrency),
                "name" => strval($item->targetName),
                "exchangeRate" => (float) strval($item->exchangeRate),
                "inverseRate" => (float) strval($item->inverseRate)
            ];
        }

        return response()->json($data);
    }
}
