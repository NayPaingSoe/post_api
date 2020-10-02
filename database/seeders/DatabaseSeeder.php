<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // factory(App\Models\User::class,30)->create();
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'name'=>'naypaingsoe',
           'email'=>'nps@gmail.com',
           'password'=>bcrypt('11111111')
        ]);
          
        //feed
        \App\Models\Feed::create([
            'user_id'=>1,
           'description'=>'Hello guys',
           'image'=>'/public/images/default.png'
        ]);
//comment
        \App\Models\Comment::create([
            'user_id'=>1,
           'feed_id'=>1,
           'comment'=>'Nice post'
        ]);

        \App\Models\Like::create([
            'user_id'=>1,
           'feed_id'=>1,
        ]);
          
    }
}
