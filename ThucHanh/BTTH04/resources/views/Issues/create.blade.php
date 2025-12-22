<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sự cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1>Thêm sự cố mới</h1>

        <!-- Hiển thị thông báo khi thành công -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('issues.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="computer_id">Máy tính</label>
                <select class="form-control" id="computer_id" name="computer_id" required>
                    <option value="">Chọn máy tính</option>
                    @foreach($computers as $computer)
                        <option value="{{ $computer->id }}">{{ $computer->computer_name }} - {{ $computer->model }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="reported_by">Người báo cáo</label>
                <input type="text" class="form-control" id="reported_by" name="reported_by" required>
            </div>

            <div class="form-group">
                <label for="reported_date">Thời gian báo cáo</label>
                <input type="datetime-local" class="form-control" id="reported_date" name="reported_date" required>
            </div>

            <div class="form-group">
                <label for="description">Mô tả sự cố</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="urgency">Mức độ sự cố</label>
                <select class="form-control" id="urgency" name="urgency" required>
                    <option value="LOW">LOW</option>
                    <option value="MEDIUM">MEDIUM</option>
                    <option value="HIGH">HIGH</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="OPEN">OPEN</option>
                    <option value="IN PROGRESS">IN PROGRESS</option>
                    <option value="RESOLVED">RESOLVED</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Thêm sự cố</button>
            <a href="{{ route('issues.index') }}" class="btn btn-secondary">Trở lại</a>
        </form>
    </div>

</body>
</html>
