<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function create()
    {
        return view('example.create');
    }

    public function result(Request $request)
    {
        $request->validate([
            'n' => 'required|integer'
        ]);

        $n = $request->input('n');

        $sequence = [];
        $sequence[0] = $n;
        $sequence[1] = $n + 1;

        for ($i = 2; $i < 10; $i++) {
            $sequence[$i] = $sequence[$i - 1] + $sequence[$i - 2];
        }

        return view('example.result', compact('sequence'));
    }
}
