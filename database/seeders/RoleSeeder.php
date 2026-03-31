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
                'salario_base' => 8000,
                'bono_por_hora' => 50
            ],
            [
                'nombre' => 'Cargador',
                'salario_base' => 6000,
                'bono_por_hora' => 40
            ],
            [
                'nombre' => 'Auxiliar',
                'salario_base' => 5000,
                'bono_por_hora' => 30
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
