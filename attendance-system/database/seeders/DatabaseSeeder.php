<?php

namespace Database\Seeders;

use App\Enums\UserGender;
use App\Models\College;
use App\Models\Level;
use App\Models\Major;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RolesAndPermissionsSeeder::class);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'gender' => UserGender::Male->value
        ])->assignRole('admin');

      /* $computerCollege =  College::query()->create([
            'name' => 'كلية الحاسبات'
        ]);


        $ecoCollege =  College::query()->create([
            'name' => 'كلية الاقتصاد'
        ]);

        Major::query()->create([
            'name' => 'تقنية المعلومات',
            'college_id' => $computerCollege->id
        ]);

        Major::query()->create([
            'name' => 'الادارة',
            'college_id' => $ecoCollege->id
        ]);*/

        Level::query()->create([
            'name' => 'الاول'
        ]);

        Level::query()->create([
            'name' => 'الثاني'
        ]);

        Level::query()->create([
            'name' => 'الثالث'
        ]);

        Level::query()->create([
            'name' => 'الرابع'
        ]);

        Level::query()->create([
            'name' => 'الخامس'
        ]);

        Level::query()->create([
            'name' => 'السادس'
        ]);

        Level::query()->create([
            'name' => 'السابع'
        ]);
    }
}
