<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.org',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@example.org',
                'password' => Hash::make('12345678'),
                'role' => 'customer'
            ]
        ];

        DB::table('users')->insert($userData);

        $categoriesData = [
            // Parent categories
            ['name' => 'Wardrobe', 'parent_id' => NULL],
            ['name' => 'Audio', 'parent_id' => NULL],

            // Subcategory lvl 1
            ['name' => 'T-Shirts', 'parent_id' => 1],
            ['name' => 'Jeans', 'parent_id' => 1],
            ['name' => 'Sweaters', 'parent_id' => 1],
            ['name' => 'Shorts', 'parent_id' => 1],
            ['name' => 'Socks', 'parent_id' => 1],

            ['name' => 'CD & Vinyls', 'parent_id' => 2],
            ['name' => 'Equipment', 'parent_id' => 2],

            // Subcategory lvl 2
            ['name' => 'Cotton T-Shirts', 'parent_id' => 3],
            ['name' => 'Polyester T-Shirts', 'parent_id' => 3],
            ['name' => 'Cargo Jeans', 'parent_id' => 4],
            ['name' => 'Denim Jeans', 'parent_id' => 4],
            ['name' => 'Cotton Shorts', 'parent_id' => 6],
            ['name' => 'Denim Shorts', 'parent_id' => 6],

            ['name' => 'Audio Speakers', 'parent_id' => 9],
            ['name' => 'Instruments', 'parent_id' => 9],


            // Subcategory lvl 3

            ['name' => 'Pianos', 'parent_id' => 17],
            ['name' => 'Guitars', 'parent_id' => 17],
            ['name' => 'Flutes', 'parent_id' => 17],

            // Subcategory lvl 4
            ['name' => 'Electric Guitars', 'parent_id' => 19],
            ['name' => 'Acoustic Guitars', 'parent_id' => 19],

        ];

        DB::table('categories')->insert($categoriesData);

        $postsData = [
            ['title' => 'Zara denim shorts', 'description' => 'Im selling this product, feel free to contact me!', 'price' => 500, 'state' => 'New', 'image_url' => 'https://static.zara.net/photos///2022/I/0/3/p/9632/716/400/2/w/1920/9632716400_6_2_1.jpg?ts=1658474632741', 'contact' => 38164481324, 'location' => 'Novi Sad, Serbia', 'user_id' => 1, 'category_id' => 15],
            ['title' => 'Pull&Bear denim shorts', 'description' => 'Im selling this product, feel free to contact me!', 'price' => 400, 'state' => '', 'image_url' => 'https://static.zara.net/photos///2022/I/0/1/p/8228/031/250/2/w/1920/8228031250_1_1_1.jpg?ts=1651759074804', 'contact' => 38164481324, 'location' => 'Novi Sad, Serbia', 'user_id' => 1, 'category_id' => 15],

            ['title' => 'Fender CD60', 'description' => 'Im selling this guitar, feel free to contact me!', 'price' => 1340, 'state' => '', 'image_url' => 'https://www.mitrosmusic.com/media/inlineimage/upload_34791_1.jpg', 'contact' => 38164481324, 'location' => 'Novi Sad, Serbia', 'user_id' => 2, 'category_id' => 19],
            ['title' => 'Fender Stratocaster', 'description' => 'Im selling this product, feel free to contact me!', 'price' => 1500, 'state' => '', 'image_url' => 'https://www.mitrosmusic.com/media/inlineimage/upload_5761_1.jpg', 'contact' => 38164481324, 'location' => 'Novi Sad, Serbia', 'user_id' => 2, 'category_id' => 19],
            ['title' => 'Korg synth piano', 'description' => 'Im selling this product, feel free to contact me!', 'price' => 2550, 'state' => '', 'image_url' => 'https://cdn.korg.com/us/products/upload/e316a0710a897fcd34b29c7cd00db75a.jpg', 'contact' => 38164481324, 'location' => 'Novi Sad, Serbia', 'user_id' => 2, 'category_id' => 18],

        ];

        DB::table('posts')->insert($postsData);
    }
}
