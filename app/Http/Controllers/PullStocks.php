<?php

namespace App\Http\Controllers;

use App\CustomClasses\AES\GetKey;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PullStocks extends Controller
{

    const GET = 'GET';
    const BASE_URL = 'http://89.108.115.241:6969/api/stocks';

    public function getAndSaveStocks(Request $request)
    {
        $dateFrom = $request->input('dateFrom');
        $perPage = 100;
        $currentPage = 1;
        $dataFetched = true;
        $key = GetKey::get(1);

        DB::table('stocks')->delete();

        while ($dataFetched) {
            $response = Http::get(self::BASE_URL, [
                'dateFrom' => $dateFrom,
                'key' => $key,
                'limit' => $perPage,
                'page' => $currentPage
            ]);

            if ($response->successful()) {
                $stocksData = $response->json()['data'];

                if (count($stocksData) === 0) {
                    $dataFetched = false;
                }

                foreach ($stocksData as $stockData) {
                    $stock = new Stock();
                    $stock->date = $stockData['date'];
                    $stock->last_change_date = $stockData['last_change_date'];
                    $stock->supplier_article = $stockData['supplier_article'];
                    $stock->tech_size = $stockData['tech_size'];
                    $stock->barcode = $stockData['barcode'];
                    $stock->quantity = $stockData['quantity'];
                    $stock->is_supply = $stockData['is_supply'];
                    $stock->is_realization = $stockData['is_realization'];
                    $stock->quantity_full = $stockData['quantity_full'];
                    $stock->warehouse_name = $stockData['warehouse_name'];
                    $stock->in_way_to_client = $stockData['in_way_to_client'];
                    $stock->in_way_from_client = $stockData['in_way_from_client'];
                    $stock->nm_id = $stockData['nm_id'];
                    $stock->subject = $stockData['subject'];
                    $stock->category = $stockData['category'];
                    $stock->brand = $stockData['brand'];
                    $stock->sc_code = $stockData['sc_code'];
                    $stock->price = $stockData['price'];
                    $stock->discount = $stockData['discount'];
                    $stock->save();
                }

                $currentPage++;
            } else {
                return response()->json(['message' => $response->body()], 500);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully added'
        ]);

    }
}
