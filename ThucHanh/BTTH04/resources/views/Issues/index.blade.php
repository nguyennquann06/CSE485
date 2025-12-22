<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sự cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tổng quan */
        body {
            background-color: #f4f7fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        h1 {
            color: #343a40;
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Tạo hiệu ứng cho table */
        .table {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background-color: #ffffff;
        }

        .table th, .table td {
            padding: 15px;
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .thead-dark {
            background-color: #6c757d;
            color: white;
        }

        /* Các nút */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            transition: background-color 0.3s ease;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Thông báo thành công */
        .alert-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        /* Nút thêm sự cố */
        .btn-lg {
            padding: 10px 20px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #20c997;
            border-color: #20c997;
        }

        .btn-primary:hover {
            background-color: #1aa085;
            border-color: #1a7a64;
        }

        /* Card */
        .card {
            border: none;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .card-body {
            padding: 30px;
        }

        .pagination {
            justify-content: center;
        }

        /* Màu sắc cho mức độ sự cố */
        .urgency-low, .urgency-medium, .urgency-high {
            display: inline-block; /* Giữ phần nền chỉ áp dụng cho văn bản */
            padding: 2px 6px; /* Thêm một chút padding cho nền */
            border-radius: 4px; /* Cạnh tròn cho nền */
        }

        .urgency-low {
            background-color: #d4edda; /* Màu xanh lá nhẹ */
            color: #155724; /* Màu chữ xanh đậm */
        }

        .urgency-medium {
            background-color: #fff3cd; /* Màu vàng nhẹ */
            color: #856404; /* Màu chữ vàng đậm */
        }

        .urgency-high {
            background-color: #f8d7da; /* Màu đỏ nhạt */
            color: #721c24; /* Màu chữ đỏ đậm */
        }

        /* Màu sắc cho trạng thái */
        .status-open, .status-pending, .status-closed {
            display: inline-block; /* Giữ phần nền chỉ áp dụng cho văn bản */
            padding: 2px 6px; /* Thêm một chút padding cho nền */
            border-radius: 4px; /* Cạnh tròn cho nền */
        }

        .status-open {
            background-color: #cce5ff; /* Màu xanh dương nhẹ */
            color: #004085; /* Màu chữ xanh đậm */
        }

        .status-pending {
            background-color: #fff3cd; /* Màu vàng nhạt */
            color: #856404; /* Màu chữ vàng đậm */
        }

        .status-closed {
            background-color: #d4edda; /* Màu xanh lá */
            color: #155724; /* Màu chữ xanh đậm */
        }

    </style>
</head>
<body>

    <div class="container mt-5">
        <h1>Danh sách sự cố</h1>

        <!-- Hiển thị thông báo khi thành công -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Nút Thêm sự cố -->
        <div class="mb-4 text-center">
            <a href="{{ route('issues.create') }}" class="btn btn-primary btn-lg">Thêm sự cố mới</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã vấn đề</th>
                            <th>Tên máy tính</th>
                            <th>Hệ điều hành</th>
                            <th>Người báo cáo</th>
                            <th>Thời gian báo cáo</th>
                            <th>Mô tả</th>
                            <th>Mức độ sự cố</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Lặp qua tất cả các sự cố -->
                        @foreach($issues as $issue)
                            <tr>
                                <td>{{ $issue->id }}</td>
                                <td>{{ $issue->computer->computer_name }}</td>
                                <td>{{ $issue->computer->operating_system }}</td>
                                <td>{{ $issue->reported_by }}</td>
                                <td>{{ $issue->reported_date }}</td>
                                <td>{{ $issue->description }}</td>
                                <td>
                                    @if($issue->urgency == 'LOW')
                                        <span class="urgency-low">{{ $issue->urgency }}</span>
                                    @elseif($issue->urgency == 'MEDIUM')
                                        <span class="urgency-medium">{{ $issue->urgency }}</span>
                                    @elseif($issue->urgency == 'HIGH')
                                        <span class="urgency-high">{{ $issue->urgency }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($issue->status == 'OPEN')
                                        <span class="status-open">{{ $issue->status }}</span>
                                    @elseif($issue->status == 'IN PROGRESS')
                                        <span class="status-pending">{{ $issue->status }}</span>
                                    @elseif($issue->status == 'RESOLVED')
                                        <span class="status-closed">{{ $issue->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Nút Sửa -->
                                    <a href="{{ route('issues.edit', $issue->id) }}" class="btn btn-warning btn-sm">Sửa</a>

                                    <!-- Form Xóa -->
                                    <form action="{{ route('issues.destroy', $issue->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $issues->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
