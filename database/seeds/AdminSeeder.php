<?php


use App\Models\User;
use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();

        $administrator = new Role(['name' => 'administrator']);
        $administrator->save();
        $moderator = new Role(['name' => 'moderator']);
        $moderator->save();

        $access = new Permission(['name' => 'access administration']);
        $users = new Permission(['name' => 'manage users']);
        $initiatives = new Permission(['name' => 'manage initiatives']);
        $events = new Permission(['name' => 'manage events']);
        $pages = new Permission(['name' => 'manage pages']);
        $menu = new Permission(['name' => 'manage menu']);
        $settings = new Permission(['name' => 'manage settings']);
        $files = new Permission(['name' => 'manage files']);
        $translations = new Permission(['name' => 'manage translations']);
        $backups = new Permission(['name' => 'manage backups']);

        $administrator->permissions()->saveMany([
            $access, $users, $initiatives, $events, $pages, $menu, $settings, $files, $translations, $backups
        ]);
        $moderator->permissions()->saveMany([
            $access, $initiatives, $events, $pages
        ]);
        $administrator->users()->create([
            'name' => 'Administrator',
            'email' => 'graddd@gmail.com',
            'password' => bcrypt('secret')
        ]);
//        DB::table('users')->insert([
//            'name' => 'Administrator',
//            'email' => 'graddd@gmail.com',
//            'password' => bcrypt('secret')
//        ]);
    }
}
