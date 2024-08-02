<?php

namespace Database\Seeders;

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $data = [
            'name' => 'Администратор',
            'email' => 'admin@bani-menu.ru',
            'password'=> Hash::make('1q23ty3io')
        ];
        $admin= User::create($data);
        $admin->assignRole($role);
    }
}
