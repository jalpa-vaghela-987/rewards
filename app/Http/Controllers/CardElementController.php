<?php

namespace App\Http\Controllers;

use App\Models\CardElement;

class CardElementController extends Controller
{
    public function getTranscodingStatus(CardElement $cardElement)
    {
        return response()->json([
            'processed' => $cardElement->media_processed,
        ]);
    }
}
