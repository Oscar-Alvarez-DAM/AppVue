<?php

namespace Database\Seeders;

use App\Models\courses;
use App\Models\students;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear algunos cursos
        $course1 = courses::create([
            'name' => 'Programación en PHP',
            'description' => 'Aprende los fundamentos de PHP moderno con Laravel',
        ]);

        $course2 = courses::create([
            'name' => 'Frontend con Vue 3',
            'description' => 'Domina Vue 3 y construye interfaces modernas',
        ]);

        $course3 = courses::create([
            'name' => 'Bases de Datos',
            'description' => 'Diseño y gestión de bases de datos relacionales',
        ]);

        // Crear estudiantes
        students::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'course_id' => $course1->id,
        ]);

        students::create([
            'name' => 'María García',
            'email' => 'maria@example.com',
            'course_id' => $course1->id,
        ]);

        students::create([
            'name' => 'Carlos López',
            'email' => 'carlos@example.com',
            'course_id' => $course2->id,
        ]);

        students::create([
            'name' => 'Ana Rodrigues',
            'email' => 'ana@example.com',
            'course_id' => $course2->id,
        ]);

        students::create([
            'name' => 'Fernando Martínez',
            'email' => 'fernando@example.com',
            'course_id' => $course3->id,
        ]);
    }
}
