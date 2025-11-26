<?php
    // Nạp mảng dữ liệu $flowers và logic phân quyền $is_admin
    include 'data.php';

    // Kiểm tra phân quyền: Nếu không phải Admin thì chuyển về trang Khách
    if (!$is_admin) {
        header('Location: index.php');
        exit;
    }

    $current_action = isset($_GET['action']) ? $_GET['action'] : '';
    $message = '';

    // --- Xử lý CRUD từ URL (Mô phỏng) ---
    // (Bỏ qua xử lý POST/Thêm mới vì đã được chuyển sang add_flower.php)
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $flowerId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $flowerName = '';
        
        // Tìm tên hoa để hiển thị trong thông báo
        foreach ($flowers as $f) {
            if ($f['id'] === $flowerId) {
                $flowerName = $f['name'];
                break;
            }
        }

        if ($action === 'edit' && $flowerId > 0) {
            $message = "Đã mô phỏng chỉnh sửa hoa: " . htmlspecialchars($flowerName) . ". (Chức năng chỉnh sửa thực tế chưa được lập trình)";
        } elseif ($action === 'delete' && $flowerId > 0) {
            $message = "Đã mô phỏng xóa hoa: " . htmlspecialchars($flowerName) . ". (Chức năng xóa thực tế chưa được lập trình)";
        }
    }
    
    // Hiển thị thông báo sau khi submit thành công từ trang add_flower.php
    if (isset($_GET['msg'])) {
        $message = htmlspecialchars($_GET['msg']);
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Danh Sách Hoa</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-controls {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 30px;
        }
        .add-btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            text-decoration: none;
            color: white;
            background-color: #28a745; /* Màu xanh lá cây */
            transition: background-color 0.2s;
        }
        .add-btn:hover {
            background-color: #218838;
        }
        /* Style cho Form Thêm Mới (GIỮ LẠI CHO CSS CHUNG) */
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1a5a40;
        }
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
        }
        .form-actions {
            margin-top: 20px;
            text-align: right;
        }
        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.2s;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .back-link {
            margin-right: 15px;
            color: #6c757d;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bảng Quản Trị: Danh Sách Các Loài Hoa</h1>
        
        <?php if ($message): ?>
            <div style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="admin-controls">
            <!-- Cập nhật link để trỏ đến file mới -->
            <a href="add_flower.php?user=admin" class="add-btn">Thêm Hoa Mới</a>

            <!-- Nút Chuyển sang chế độ Khách -->
            <a href="index.php" style="color: #d9534f; text-decoration: underline; align-self: center;">Chuyển sang chế độ Khách</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên Hoa</th>
                    <th>Mô Tả (Ngắn)</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flowers as $flower): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($flower['id']); ?></td>
                        <td>
                            <!-- Sử dụng đường dẫn tương đối 'images/ten_file.png' -->
                            <img src="Img/<?php echo htmlspecialchars($flower['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($flower['name']); ?>" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                 onerror="this.onerror=null; this.src='https://placehold.co/50x50/1a5a40/ffffff?text=<?php echo substr(htmlspecialchars($flower['name']), 0, 1); ?>'">
                        </td>
                        <td><?php echo htmlspecialchars($flower['name']); ?></td>
                        <td><?php echo htmlspecialchars(substr($flower['description'], 0, 70)) . '...'; ?></td>
                        <td>
                                <!-- Nút Edit (Mô phỏng) -->
                                <a href="?user=admin&action=edit&id=<?php echo $flower['id']; ?>" class="action-btn edit-btn">Sửa</a>
                                <!-- Nút Delete (Mô phỏng) -->
                                <a href="?user=admin&action=delete&id=<?php echo $flower['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa hoa <?php echo htmlspecialchars($flower['name']); ?>?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            
    </div>
</body>
</html>