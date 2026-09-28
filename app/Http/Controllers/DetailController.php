<?php

namespace App\Http\Controllers;

class DetailController extends Controller
{
    public function index($id = 1)
    {
        $products = [

            // =========================
            // MAKANAN RINGAN
            // =========================

            1 => [
                'name' => 'Snack 1',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            2 => [
                'name' => 'Snack 2',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            3 => [
                'name' => 'Snack 3',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            4 => [
                'name' => 'Snack 4',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            5 => [
                'name' => 'Snack 5',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            // =========================
            // MINUMAN
            // =========================

            6 => [
                'name' => 'Drink 1',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            7 => [
                'name' => 'Drink 2',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            8 => [
                'name' => 'Drink 3',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            9 => [
                'name' => 'Drink 4',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],

            10 => [
                'name' => 'Drink 5',
                'price' => 15000,
                'category' => 'Lorem Ipsum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.',
                'image' => null,
                'stock' => 20,
            ],
        ];

        // Jika ID produk tidak ditemukan
        if (!isset($products[$id])) {
            abort(404);
        }

        $product = $products[$id];

        return view('detail', compact('product', 'id'));
    }
}