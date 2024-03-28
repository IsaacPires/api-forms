<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create user 1
        $user1 = User::create([
            'name' => 'test1',
            'email' => 'test1@example.com',
            'password' => bcrypt('password'),
        ]);

        $token1 = $user1->createToken('test1_token')->plainTextToken;

        $user2 = User::create([
            'name' => 'test2',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        $token2 = $user2->createToken('test2_token')->plainTextToken;

        SanctumPersonalAccessToken::create([
            'tokenable_type' => User::class,
            'tokenable_id' => $user1->id,
            'name' => 'test1_token',
            'token' => $token1,
            'abilities' => json_encode(['*']),
        ]);

        SanctumPersonalAccessToken::create([
            'tokenable_type' => User::class,
            'tokenable_id' => $user2->id,
            'name' => 'test2_token',
            'token' => $token2,
            'abilities' => json_encode(['*']),
        ]);
    }
}