<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publication;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publications = [
           [
                'title_publication' => 'Alerta de Inundación',
                'type_publication' => 'Emergencia',
                'severity_publication' => 'Alta',
                'location_publication' => 'Zona Norte',
                'description_publication' => 'Se reporta una inundación severa en la zona norte de la ciudad.',
                'url_imagen' => 'inundacion.jpg',
                'role_id' => 1
            ]
        ];

        foreach ($publications as $publication) {
            Publication::create($publication);
        }
    }
}
