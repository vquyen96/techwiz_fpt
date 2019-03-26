<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();


        DB::table('categories')->insert([
            'title' => 'An toàn lao động',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Bác sĩ',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Bán hàng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Bán hàng kỹ thuật',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Bán lẻ/Bán sỉ',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Bảo hiểm',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Bảo trì/Sửa chữa',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Bất động sản',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Biên phiên dịch',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Cấp quản lý điều hành',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Chứng khoán',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Cơ khí',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Công nghệ cao',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Dầu khí',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Dệt may/Da giày',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Dịch vụ khách hàng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Dược Phẩm/Công nghệ sinh học',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Dược sĩ',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Giáo dục/Đào tạo',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Hàng cao cấp',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Hàng gia dụng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Hàng hải',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Hàng không/Du lịch',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Hàng tiêu dùng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Hành chánh/Thư ký',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Hóa học/Hóa sinh',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Hoạch định/Dự án',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'In ấn/ Xuất bản',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Internet/Online Media',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'IT - Phần mềm',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'IT-Phần cứng/Mạng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Kế toán',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Khác',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Kho vận',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Kiểm toán',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Kiến trúc/Thiết kế nội thất ',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Marketing',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Mới tốt nghiệp',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Môi trường/Xử lý chất thải',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Mỹ Thuật/Nghệ Thuật/Thiết Kế',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Ngân hàng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Người nước ngoài/Việt Kiều',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Nhà hàng/Khách sạn',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Nhân sự',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Nông nghiệp/Lâm nghiệp',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Overseas Jobs',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Pháp lý',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Phi chính phủ/Phi lợi nhuận',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'QA/QC',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Quảng cáo/Khuyến mãi/Đối ngoại',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Sản phẩm công nghiệp',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Sản Xuất',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Tài chính/Đầu tư',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Thời trang',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Thời vụ/Hợp đồng ngắn hạn',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Thu Mua/Vật Tư/Cung Vận',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Thực phẩm &amp; Đồ uống',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Trình dược viên',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Truyền hình/Truyền thông/Báo chí',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Tư vấn',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Tự động hóa/Ô tô',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Vận chuyển/Giao nhận',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Viễn Thông',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Xây dựng',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Xuất nhập khẩu',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Y sĩ/Hộ lý',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Y tế/Chăm sóc sức khỏe',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Địa chất/Khoáng sản',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Điện lạnh/Nhiệt lạnh',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('categories')->insert([
            'title' => 'Điện/Điện tử',
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
