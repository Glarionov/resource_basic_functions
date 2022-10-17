<?php

namespace Database\Seeders;

use App\Models\AppointmentType;
use Illuminate\Database\Seeder;

class AppointmentsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Доверенность', 'Наследство', 'Справка'];

        foreach ($names as $name) {
            $type = new AppointmentType();
            $type->name = $name;
            $type->save();
        }
    }
}
