<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PessoasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$places as $place) {
            DB::table('places')->insert([
                'name' => $place,
                'visited' => rand(0,1) == 1
            ]);
        }
    }

    /*
        Efetuar um tratamento deste seeder
    */

    class PessoaTableSeeder extends Seeder {
 
        public function run()
        {
            DB::table('pessoas')->delete();
     
            User::create(['pessoa_nome' => 'juliet','status' => 'A']);
            User::create(['pessoa_nome' => 'julieta','status' => 'A']);
            User::create(['pessoa_nome' => 'Marlene','status' => 'A']);
            User::create(['pessoa_nome' => 'Vania','status' => 'A']);
            User::create(['pessoa_nome' => 'Antonio','status' => 'A']);
            User::create(['pessoa_nome' => 'Bandeiras','status' => 'A']);
            User::create(['pessoa_nome' => 'Joana Calcanhoto','status' => 'A']);
            User::create(['pessoa_nome' => 'Priscilla','status' => 'A']);
            User::create(['pessoa_nome' => 'Charlotte','status' => 'A']);
            User::create(['pessoa_nome' => 'Jonhson m.','status' => 'A']);
            User::create(['pessoa_nome' => 'Luigi','status' => 'A']);
            User::create(['pessoa_nome' => 'Mario','status' => 'A']);
            User::create(['pessoa_nome' => 'Mariano','status' => 'A']);
            User::create(['pessoa_nome' => 'Paola','status' => 'A']);
            User::create(['pessoa_nome' => 'Lucas','status' => 'A']);
            User::create(['pessoa_nome' => 'Hiro','status' => 'A']);
            User::create(['pessoa_nome' => 'Samantha','status' => 'A']);
            User::create(['pessoa_nome' => 'Sirlene','status' => 'A']);
            User::create(['pessoa_nome' => 'Marco Aurelio','status' => 'A']);
            User::create(['pessoa_nome' => 'Vicente','status' => 'A']);
            User::create(['pessoa_nome' => 'Garou','status' => 'A']);
            User::create(['pessoa_nome' => 'Verstapen','status' => 'A']);
    
        }
     
    }
}
