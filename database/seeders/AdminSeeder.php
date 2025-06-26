<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

Role::firstOrCreate(['name' => 'admin']);
Role::firstOrCreate(['name' => 'user']);

$user = User::create([
  'name' => 'Admin',
  'email' => 'admin@mail.com',
  'password' => bcrypt('Admin#123')
]);

$user->assignRole('admin');

?>