<?php

use App\User;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'admin', 
        	'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
  
        $role = Role::create(['name' => 'Admin']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);

        $role = Role::create(['name' => 'User']);
        $role->givePermissionTo('user-account');

        factory(User::class, 10)->create();
        
        $users = User::where('id', '>' , '1')->get();

        foreach($users as $user) {
            $user->assignRole([$role->id]);
        }
    }
}
