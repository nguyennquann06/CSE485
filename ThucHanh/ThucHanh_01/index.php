<?php
    // Nạp mảng dữ liệu $flowers và logic phân quyền $is_admin
    include 'data.php';

    // Điều hướng nếu là admin (dựa trên logic $is_admin)
    if ($is_admin) {
        header('Location: admin.php?user=admin');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>14 Loại Hoa Tuyệt Đẹp Dịp Xuân Hè</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>14 Loại Hoa Tuyệt Đẹp Thích Hợp Trồng Để Khoe Hương Sắc Dịp Xuân Hè</h1>
        <p>Chào mừng bạn đến với danh sách các loài hoa rực rỡ và ý nghĩa nhất cho mùa xuân và mùa hè.</p>
        <p style="text-align: right; margin-bottom: 30px;">
            <!-- Link mô phỏng chuyển đổi sang chế độ quản trị -->
            <a href="?user=admin" style="color: #1a5a40; text-decoration: underline;">Chuyển sang chế độ Quản trị</a>
        </p>
        
        <?php foreach ($flowers as $flower): ?>
            <div class="flower-card">
                <!-- Tải ảnh, nếu không tìm thấy sẽ hiển thị placeholder -->
                <img src="Img/<?php echo htmlspecialchars($flower['image']); ?>" 
                     alt="Ảnh <?php echo htmlspecialchars($flower['name']); ?>" 
                     class="flower-image" 
                     onerror="this.onerror=null; this.src='https://placehold.co/200x150/1a5a40/ffffff?text=<?php echo substr(htmlspecialchars($flower['name']), 0, 10); ?>'">
                <div class="flower-content">
                    <h2><?php echo htmlspecialchars($flower['name']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($flower['description'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        
    </div>
</body>
</html>