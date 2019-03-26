<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();


        DB::table('locations')->insert([
            'title' => 'Hồ Chí Minh',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hà Nội',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'ĐBSCL',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'An Giang',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bà Rịa - Vũng Tàu',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bắc Kạn',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bắc Giang',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bạc Liêu',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bắc Ninh',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bến Tre',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Biên Hòa',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bình Định',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bình Dương',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bình Phước',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Bình Thuận',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Cà Mau',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Cần Thơ',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Cao Bằng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Đà Nẵng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Đắk Lắk',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Điện Biên',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Đồng Nai',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Đồng Tháp',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Gia Lai',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hà Giang',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hà Nam',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hà Tây',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hà Tĩnh',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hải Dương',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hải Phòng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hòa Bình',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Huế',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hưng Yên',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Khánh Hòa',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Kon Tum',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Lai Châu',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Lâm Đồng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Lạng Sơn',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Lào Cai',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Long An',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Nam Định',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Nghệ An',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Ninh Bình',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Ninh Thuận',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Phú Thọ',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Phú Yên',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Quảng Bình',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Quảng Nam',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Quảng Ngãi',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Quảng Ninh',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Quảng Trị',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Sóc Trăng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Sơn La',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Tây Ninh',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Thái Bình',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Thái Nguyên',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Thanh Hóa',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Thừa Thiên-Huế',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Tiền Giang',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Trà Vinh',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Tuyên Quang',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Kiên Giang',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Vĩnh Long',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Vĩnh Phúc',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Yên Bái',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Khác',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Quốc tế',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Hậu Giang',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('locations')->insert([
            'title' => 'Đắk Nông',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
