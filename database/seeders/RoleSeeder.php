<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {



        $roles = [
            [
                'nombre' => 'Chofer',
                'salario_base' => 30.00,
                'bono_por_hora' => 10.00
            ],
            [
                'nombre' => 'Cargador',
                'salario_base' => 30.00,
                'bono_por_hora' => 5.00
            ],
            [
                'nombre' => 'Auxiliar',
                'salario_base' => 30.00,
                'bono_por_hora' => 0.00
            ]
        ];
        foreach ($roles as $rol) {
            Role::updateOrCreate(
                ['nombre' => $rol['nombre']],
                $rol
            );
        }
    }
}
