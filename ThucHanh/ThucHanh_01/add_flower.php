<?php
    // Nạp logic phân quyền (từ data.php)
    // Lưu ý: data.php cần được include để có biến $is_admin
    include 'data.php'; 

    // Kiểm tra phân quyền: Nếu không phải Admin thì chuyển về trang Khách
    if (!$is_admin) {
        header('Location: index.php');
        exit;
    }

    $message = '';
    
    // --- Xử lý Form Thêm Mới (Mô phỏng) ---
    // Form này POST dữ liệu về chính nó (add_flower.php)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_action']) && $_POST['form_action'] === 'add_submit') {
        $newName = htmlspecialchars(trim($_POST['name']));
        $newDescription = htmlspecialchars(trim($_POST['description']));
        $newImage = htmlspecialchars(trim($_POST['image']));
        
        if (!empty($newName) && !empty($newDescription) && !empty($newImage)) {
            // Đây là bước mô phỏng việc thêm dữ liệu vào database
            $successMessage = "Đã mô phỏng thêm thành công hoa **" . $newName . "**! (ID: 999 - Dữ liệu không được lưu trữ vĩnh viễn)";
            
            // Chuyển hướng về trang danh sách (admin.php) kèm thông báo
            header('Location: admin.php?user=admin&msg=' . urlencode($successMessage));
            exit;
        } else {
            $message = "Lỗi: Vui lòng điền đầy đủ Tên hoa, Mô tả và Tên file ảnh.";
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Hoa Mới</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Sử dụng lại các style cho form đã được định nghĩa trong admin.php -->
</head>
<body>
    <div class="container">
        <h1>Thêm Thông Tin Hoa Mới</h1>
        
        <?php if ($message): ?>
            <div style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Form sẽ POST về chính file add_flower.php -->
        <form action="add_flower.php?user=admin" method="POST">
            <input type="hidden" name="form_action" value="add_submit">

            <div class="form-group">
                <label for="name">Tên Hoa:</label>
                <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="description">Mô Tả:</label>
                <textarea id="description" name="description" rows="5" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Tên File Ảnh (Ví dụ: ten_hoa.png):</label>
                <input type="text" id="image" name="image" required value="<?php echo isset($_POST['image']) ? htmlspecialchars($_POST['image']) : ''; ?>">
                <small style="color: #666;">Lưu ý: File ảnh phải được tải lên thư mục 'images/' của dự án.</small>
            </div>

            <div class="form-actions">
                <a href="admin.php?user=admin" class="back-link">Hủy</a>
                <button type="submit" class="submit-btn">Lưu Thông Tin</button>
            </div>
        </form>
            
    </div>
</body>
</html>