<?php
// Cấu hình file CSV
$csv_file = '65HTTT_Danh_sach_diem_danh.csv';
$data = [];
$headers = [];
$error = null;

// Kiểm tra xem tệp có tồn tại không
if (!file_exists($csv_file)) {
    $error = "Lỗi: Không tìm thấy tệp tin '$csv_file' trong cùng thư mục. Vui lòng tạo tệp này.";
} else {
    // Mở tệp tin để đọc
    // 'r': mở để chỉ đọc; ký tự ',' là dấu phân cách (delimiter)
    if (($handle = fopen($csv_file, "r")) !== FALSE) {
        // Đọc dòng đầu tiên (tiêu đề cột)
        if (($headers = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Đọc các dòng còn lại (dữ liệu)
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Đảm bảo số lượng cột khớp
                if (count($row) === count($headers)) {
                    $data[] = $row;
                }
            }
        }
        fclose($handle);
    } else {
        $error = "Lỗi: Không thể mở tệp tin '$csv_file'. Vui lòng kiểm tra quyền truy cập.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 03: Đọc và Hiển thị Dữ liệu CSV</title>
    <!-- Tải Tailwind CSS để tạo giao diện responsive -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Tùy chỉnh thanh cuộn cho bảng */
        .table-container::-webkit-scrollbar {
            height: 8px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background-color: #6366f1;
            border-radius: 4px;
        }
        .table-container::-webkit-scrollbar-track {
            background-color: #e0e7ff;
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-8">

    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-2xl p-6 md:p-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-center text-indigo-700 mb-4">
            ĐỌC VÀ HIỂN THỊ DỮ LIỆU TỪ TỆP CSV
        </h1>
        <p class="text-center text-gray-500 mb-8">
            Dữ liệu được đọc từ tệp tin: <code class="text-indigo-600 font-semibold"><?php echo htmlspecialchars($csv_file); ?></code>
        </p>

        <?php if ($error): ?>
            <!-- Hiển thị thông báo lỗi nếu có -->
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Lỗi!</strong>
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php elseif (empty($data)): ?>
             <!-- Thông báo nếu không có dữ liệu (chỉ có tiêu đề hoặc tệp rỗng) -->
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Thông báo!</strong>
                <span class="block sm:inline">Tệp CSV không chứa dữ liệu tài khoản nào (hoặc chỉ có dòng tiêu đề).</span>
            </div>
        <?php else: ?>
            <!-- Khu vực chứa bảng (có thanh cuộn ngang nếu màn hình nhỏ) -->
            <div class="overflow-x-auto table-container shadow-lg rounded-lg">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-indigo-600 text-white sticky top-0">
                        <tr>
                            <?php foreach ($headers as $header): ?>
                                <th class="py-3 px-4 text-left font-semibold uppercase text-sm border-r border-indigo-700 last:border-r-0">
                                    <?php echo htmlspecialchars(trim($header)); ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($data as $index => $row): ?>
                            <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50 hover:bg-gray-100' : 'bg-white hover:bg-gray-100'; ?> transition duration-150 ease-in-out">
                                <?php foreach ($row as $cell): ?>
                                    <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
                                        <?php echo htmlspecialchars(trim($cell)); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <p class="mt-6 text-sm text-gray-500 text-right">
                Tổng cộng: <span class="font-bold text-indigo-600"><?php echo count($data); ?></span> bản ghi.
            </p>
        <?php endif; ?>
    </div>

</body>
</html>