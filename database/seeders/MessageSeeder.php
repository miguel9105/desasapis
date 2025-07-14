<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
/**
 * Seeder para poblar la tabla 'messages' con datos de ejemplo.
 * Útil para pruebas del sistema de mensajería (chat).
 */
class MessageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('messages')->insert([
            ['content' => 'Hola, bienvenido al sistema.', 'is_admin_message' => 1, 'is_read' => 0],
            ['content' => 'Gracias por su mensaje.', 'is_admin_message' => 0, 'is_read' => 1],
            ['content' => '¿Cómo podemos ayudarte hoy?', 'is_admin_message' => 1, 'is_read' => 0],
            ['content' => 'Tu solicitud ha sido recibida.', 'is_admin_message' => 0, 'is_read' => 0],
            ['content' => 'Estamos revisando tu caso.', 'is_admin_message' => 1, 'is_read' => 1],
        ]);
    }
}
