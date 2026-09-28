<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $snacks = [
            [
                'name' => 'Item 1',
                'price' => 'Rp 16.000',
                'image' => null,
            ],
            [
                'name' => 'Item 2',
                'price' => 'Rp 12.000',
                'image' => null,
            ],
            [
                'name' => 'Item 3',
                'price' => 'Rp 15.000',
                'image' => null,
            ],
            [
                'name' => 'Item 4',
                'price' => 'Rp 10.000',
                'image' => null,
            ],
            [
                'name' => 'Item 5',
                'price' => 'Rp 14.000',
                'image' => null,
            ],
        ];

        $drinks = [
            [
                'name' => 'Drink 1',
                'price' => 'Rp 5.000',
                'image' => null,
            ],
            [
                'name' => 'Drink 2',
                'price' => 'Rp 7.000',
                'image' => null,
            ],
            [
                'name' => 'Drink 3',
                'price' => 'Rp 12.000',
                'image' => null,
            ],
            [
                'name' => 'Drink 4',
                'price' => 'Rp 15.000',
                'image' => null,
            ],
            [
                'name' => 'Drink 5',
                'price' => 'Rp 13.000',
                'image' => null,
            ],
        ];

        return view('dashboard', compact('snacks', 'drinks'));
    }
}