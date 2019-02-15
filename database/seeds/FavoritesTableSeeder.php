<?php

use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('favorites')->delete();
        $users=\App\User::pluck('id')->all();
        $numberOfUsers=count($users);
        foreach (\App\Question::all() as $question){
            for ($i=0;$i<rand(1,$numberOfUsers);$i++){
                $user=$users[$i];
                $question->favorites()->attach($user);
            }
        }
    }
}
