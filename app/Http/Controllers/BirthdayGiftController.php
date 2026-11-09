<?php

namespace App\Http\Controllers;

use App\Support\BirthdayGift;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BirthdayGiftController extends Controller
{
    /**
     * Novi membuka salah satu kotak: undi isinya di server dan kunci hasilnya.
     */
    public function store(Request $request): JsonResponse
    {
        $lastBox = count(BirthdayGift::options()) - 1;

        $validated = $request->validate([
            'box' => ['required', 'integer', 'min:0', "max:{$lastBox}"],
        ]);

        return response()->json(BirthdayGift::pick((int) $validated['box']));
    }
}
