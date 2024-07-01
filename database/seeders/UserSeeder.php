<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@zrix.com', 
            'password' => bcrypt('123456'),
            'user_name' => 'admin', 
        ]);
        $role = Role::find(1);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        $this->command->info('Admin User created with email : admin@zrix.com and password : 123456');
    }
}
