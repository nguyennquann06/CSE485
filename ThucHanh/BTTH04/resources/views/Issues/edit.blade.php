<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sự cố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1>Sửa sự cố</h1>

        <!-- Hiển thị thông báo khi thành công -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('issues.update', $issue->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="computer_id">Máy tính</label>
                <select class="form-control" id="computer_id" name="computer_id" required>
                    <option value="">Chọn máy tính</option>
                    @foreach($computers as $computer)
                        <option value="{{ $computer->id }}" @if($computer->id == $issue->computer_id) selected @endif>
                            {{ $computer->computer_name }} - {{ $computer->model }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="reported_by">Người báo cáo</label>
                <input type="text" class="form-control" id="reported_by" name="reported_by" value="{{ $issue->reported_by }}" required>
            </div>

            <div class="form-group">
                <label for="reported_date">Thời gian báo cáo</label>
                <input type="datetime-local" class="form-control" id="reported_date" name="reported_date" value="{{ $issue->reported_date }}" required>
            </div>

            <div class="form-group">
                <label for="description">Mô tả sự cố</label>
                <textarea class="form-control" id="description" name="description" required>{{ $issue->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="urgency">Mức độ sự cố</label>
                <select class="form-control" id="urgency" name="urgency" required>
                    <option value="LOW" @if($issue->urgency == 'LOW') selected @endif>LOW</option>
                    <option value="MEDIUM" @if($issue->urgency == 'MEDIUM') selected @endif>MEDIUM</option>
                    <option value="HIGH" @if($issue->urgency == 'HIGH') selected @endif>HIGH</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="OPEN" @if($issue->status == 'OPEN') selected @endif>OPEN</option>
                    <option value="IN PROGRESS" @if($issue->status == 'IN PROGRESS') selected @endif>IN PROGRESS</option>
                    <option value="RESOLVED" @if($issue->status == 'RESOLVED') selected @endif>SOLVED</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật sự cố</button>
            <a href="{{ route('issues.index') }}" class="btn btn-secondary">Trở lại</a>
        </form>
    </div>

</body>
</html>
