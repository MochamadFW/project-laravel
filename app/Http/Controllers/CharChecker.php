<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CharCheckerHistories;

class CharChecker extends Controller
{
    public function index()
    {
        return view('char_checker.index');
    }

    public function validate(Request $request)
    {
        $inputOne = $request->input('input_one');
        $inputTwo = $request->input('input_two');

        // Validasi input
        $request->validate([
            'input_one' => 'required|string',
            'input_two' => 'required|string',
        ]);

        $inputOneChars = str_split($inputOne);
        $inputOneLen = strlen($inputOne);
        $matchCount = 0;

        foreach ($inputOneChars as $char) {
            if (stripos($inputTwo, $char) !== false) {
                $matchCount++;
            }
        }

        $percentage = ($matchCount / $inputOneLen) * 100;

        $check = CharCheckerHistories::create([
            'input_one' => $inputOne,
            'input_two' => $inputTwo,
            'percentage' => $percentage,
        ]);

        return response()->json([
            'message' => 'Pengecekan berhasil!',
            'data' => $check,
        ]);
    }

}
