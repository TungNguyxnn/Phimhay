<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use App\Models\VipPlan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Quản trị viên', 'email' => 'admin@phim.test', 'password' => 'admin123', 'role' => 'admin']);
        User::create(['name' => 'Thành viên mẫu', 'email' => 'user@phim.test', 'password' => '123456', 'role' => 'member']);

        $cats = collect(['Hành động', 'Tình cảm', 'Hài hước', 'Kinh dị', 'Hoạt hình', 'Viễn tưởng'])
            ->mapWithKeys(fn ($n) => [$n => Category::create(['name' => $n])]);

        foreach ([['Gói 1 tháng', 49000, 30], ['Gói 6 tháng', 249000, 180], ['Gói 1 năm', 449000, 365]] as [$n, $p, $d]) {
            VipPlan::create(['name' => $n, 'price' => $p, 'days' => $d]);
        }

        $actors = collect(['Trấn Thành', 'Ngô Thanh Vân', 'Tom Hanks', 'Song Hye Kyo'])->map(fn ($n) => Actor::create(['name' => $n]));

        $samples = [
            ['Đại Chiến Thành Phố', 2024, 'Mỹ', 'le', false, ['Hành động', 'Viễn tưởng']],
            ['Mùa Thu Lá Bay', 2023, 'Hàn Quốc', 'bo', false, ['Tình cảm']],
            ['Gia Đình Siêu Quậy', 2022, 'Việt Nam', 'le', false, ['Hài hước']],
            ['Căn Nhà Ma Ám', 2025, 'Thái Lan', 'le', true, ['Kinh dị']],
            ['Chú Mèo Phiêu Lưu', 2021, 'Nhật Bản', 'bo', false, ['Hoạt hình', 'Hài hước']],
            ['Hành Tinh Cuối Cùng', 2026, 'Mỹ', 'bo', true, ['Viễn tưởng', 'Hành động']],
        ];

        foreach ($samples as $i => [$title, $year, $country, $type, $vip, $cs]) {
            $m = Movie::create([
                'title' => $title, 'year' => $year, 'country' => $country, 'type' => $type, 'is_vip' => $vip,
                'duration' => 100, 'views' => rand(10, 500),
                'description' => "Nội dung mẫu của phim \"$title\". Đây là dữ liệu demo cho đồ án.",
                'poster' => 'https://placehold.co/300x450/1f4e79/ffffff?text=' . urlencode($title),
            ]);
            $m->categories()->sync(collect($cs)->map(fn ($c) => $cats[$c]->id));
            $m->actors()->attach($actors[$i % 4]->id, ['role_name' => 'Vai chính']);

            $eps = $type === 'bo' ? 3 : 1;
            for ($n = 1; $n <= $eps; $n++) {
                $m->episodes()->create([
                    'number' => $n, 'title' => "Tập $n",
                    'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4', 'duration' => 45,
                ]);
            }
        }
    }
}
