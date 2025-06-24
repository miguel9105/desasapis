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
                'title' => 'Alerta de Inundación',
                'type' => 'Emergencia',
                'severity' => 'Alta',
                'location' => 'Zona Norte',
                'description' => 'Se reporta inundación severa en la zona norte de la ciudad.',
                'image' => 'inundacion1.jpg',
            ],
            [
                'title' => 'Alerta de Terremoto',
                'type' => 'Emergencia',
                'severity' => 'Alta',
                'location' => 'Zona Centro',
                'description' => 'Se ha detectado un terremoto de magnitud 7.2 en la zona centro.',
                'image' => 'terremoto1.jpg',
            ],
            [
                'title' => 'Alerta de Tormenta',
                'type' => 'Clima',
                'severity' => 'Media',
                'location' => 'Zona Sur',
                'description' => 'Se pronostica una tormenta eléctrica en la zona sur.',
                'image' => 'tormenta1.jpg',
            ],
        ];

        foreach ($publications as $publication) {
            Publication::create($publication);
        }
    }
}
