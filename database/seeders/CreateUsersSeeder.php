<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'Pasien',
                'email' => 'pasien@pasien.com',
                'no_telepon' => '62895617545305',
                'type' => 0,
                'password' => bcrypt('123456'),
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'no_telepon' => '62895617545306',
                'type' => 1,
                'password' => bcrypt('123456'),
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'Perawat',
                'email' => 'perawat@perawat.com',
                'no_telepon' => '62895617545307',
                'type' => 2,
                'password' => bcrypt('123456'),
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'Dokter',
                'email' => 'dokter@dokter.com',
                'no_telepon' => '62895617545308',
                'type' => 3,
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
