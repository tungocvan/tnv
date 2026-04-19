<?php

namespace Modules\Ntd\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Ntd\Models\Application;
use Modules\Ntd\Models\Student;
use Illuminate\Support\Str;
// php artisan db:seed --class="Modules\Ntd\database\seeders\ApplicationSeeder"
class ApplicationSeeder extends Seeder
{
    public function run()
    {
        // ❗ Xóa dữ liệu cũ (test lại sạch)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Student::truncate();
        Application::truncate();

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $statuses = ['draft', 'submitted'];
        $genders = ['male', 'female'];

        for ($i = 1; $i <= 200; $i++) {

            // =====================
            // APPLICATION
            // =====================
            $application = Application::create([
                'code' => 'MHS_' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'status' => $statuses[array_rand($statuses)],
                'school_year' => '2026-2027',
                'addresses' => json_encode([]),
                'registration' => json_encode([
                    'class_type' => rand(0, 1) ? 'standard' : 'advanced'
                ]),
                'created_at' => now()->subDays(rand(0, 30)),
            ]);

            // =====================
            // RANDOM: có hoặc không có student (test null)
            // =====================
            if (rand(0, 10) > 1) {

                Student::create([
                    'application_id' => $application->id,

                    'full_name' => $this->fakeName(),
                    'date_of_birth' => now()->subYears(rand(5, 10))->format('Y-m-d'),
                    'gender' => $genders[array_rand($genders)],

                    'phone' => '09' . rand(10000000, 99999999),

                    // 🎯 MÃ ĐỊNH DANH (quan trọng)
                    'identity_number' => rand(100000000000, 999999999999),
                ]);
            }
        }

        $this->command->info('✅ Seeded 200 applications!');
    }

    // =====================
    // Fake tên VN
    // =====================
    private function fakeName()
    {
        $last = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng'];
        $middle = ['Văn', 'Thị', 'Hữu', 'Đức', 'Minh'];
        $first = ['An', 'Bình', 'Cường', 'Dũng', 'Hà', 'Linh'];

        return $last[array_rand($last)] . ' ' .
               $middle[array_rand($middle)] . ' ' .
               $first[array_rand($first)];
    }
}