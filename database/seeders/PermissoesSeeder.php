<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permissao;

class PermissoesSeeder extends Seeder
{
    public function run()
    {
        $permissoes = [
           
            ['email' => 'raissa.adm@agroaraca.com.br', 'tipo' => 'dashboard'],
            ['email' => 'raissa.adm', 'tipo' => 'dashboard'],
            ['email' => 'raissa.adm@agroaraca.com.br', 'tipo' => 'cartões'],
            ['email' => 'raissa.adm', 'tipo' => 'cartões'],
            ['email' => 'raissa.santos@agroaraca.com.br', 'tipo' => 'cartões'],
            ['email' => 'raissa.santos', 'tipo' => 'cartões'],
            
        ];

        foreach ($permissoes as $permissao) {
            Permissao::firstOrCreate($permissao);
        }
    }
}
