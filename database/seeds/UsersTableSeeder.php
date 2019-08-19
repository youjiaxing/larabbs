<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);
        // 头像假数据
        $avatars = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        $users = factory(\App\Models\User::class)->times(10)->make()->each(function ($user, $index) use ($faker, $avatars) {
            $user->avatar = $faker->randomElement($avatars);

            if ($index == 0) {
                $user->name = 'yjx';
                $user->email = 'yjx@qq.com';
                $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
            }
        });
        /* @var \Illuminate\Database\Eloquent\Collection $users */
        $users_array = $users->makeVisible('password', 'remember_token')->toArray();

        \App\Models\User::insert($users_array);
    }
}
