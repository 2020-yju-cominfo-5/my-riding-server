<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use App\User;

class NotificationTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('ko_kr');

        // 사용자 한 명당 생성할 알림 레코드 수
        $num_of_record = 5;

        // 알림 유형
        // 1001 - Like, 1002 - Record, 1003 - Badge
        $noti_type = [1001 => '1001', 1002 => '1002', 1003 => '1003'];

        // 번호가 1 ~ 3 인 회원의 수만큼 반복
        for ($count_user = 0; $count_user < 3; $count_user++) {
            // 회원마다 5개씩 알림 레코드 생성
            for ($count_noti = 0; $count_noti < $num_of_record; $count_noti++) {
                // 랜덤 날짜 생성
                $temp_date = $faker->date('Y-m-d');
                // 랜덤 키값 생성
                $tempNum = random_int(1001, 1003);

                // 랜덤 날짜의 연, 월, 일 저장
                $date_y = date('Y', strtotime($temp_date));
                $date_m = date('m', strtotime($temp_date));
                $date_d = date('d', strtotime($temp_date));


                // 알림 유형별 메시지
                $noti_msg = [
                    1001 => '경로_' . ($count_noti + 1) . '에 좋아요를 누르셨습니다.',
                    1002 => $date_y . '년 ' . $date_m . '월 ' . $date_d . '일 ' . '라이딩이 완료되었습니다.',
                    1003 => '신기록_' . ($count_noti + 1) . '을(를) 달성하여 배지를 획득하셨습니다.'
                ];

                // 랜덤 숫자 생성
                $random_num = random_int(1, 30);
                // 알림 유형별 이동 페이지 주소
                $noti_url = [
                    1001 => '/route/show/' . $random_num,
                    1002 => '/record/show/' . $random_num,
                    1003 => '없음'
                ];

                // 알림 확인 유무(true / false) 랜덤 생성
                $noti_check = $faker->boolean;
                // 알림 확인 유무(true / false) 에 따른 updatedCheck 날짜 랜덤 생성
                $temp_date = $faker->dateTimeBetween($startDate = '-2 year', $endDate = 'now');
                $updated_at = $noti_check === true ? $temp_date : null;

                DB::table('notifications')->insert([
                    'id' => 0,
                    'noti_user_id' => $count_user + 1,
                    'noti_type' => $noti_type[$tempNum],
                    'noti_msg' => $noti_msg[$tempNum],
                    'noti_url' => $noti_url[$tempNum],
                    'noti_check' => $noti_check,
                    'created_at' => $faker->dateTimeBetween($startDate = '-3 year', $endDate = '-2 year'),
                    'updated_at' => $updated_at
                ]);
            }
        }
    }
}
