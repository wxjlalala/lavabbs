<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        // 查找所有用户id
        $user_ids = User::all()->pluck('id')->toArray();

        //查找所有分类id
        $categories = Category::all()->pluck('id')->toArray();

        // 获取Faker示例
        $faker = app(\Faker\Generator::class);

        $topics = factory(Topic::class)->times(50)->make()->each(function ($topic, $index) use ($faker,$user_ids,$categories) {
            // 随机取值并赋值
            $topic->user_id = $faker->randomElement($user_ids);
            $topic->category_id = $faker->randomElement($categories);
        });

        Topic::insert($topics->toArray());
    }

}

