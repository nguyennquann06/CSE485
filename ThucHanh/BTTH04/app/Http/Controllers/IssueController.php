<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Computer;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    // Hiển thị danh sách sự cố với phân trang
    public function index()
    {
        $issues = Issue::with('computer') // Lấy thông tin máy tính kèm theo sự cố
                       ->paginate(10); // Phân trang 10 bản ghi/trang

        return view('issues.index', compact('issues'));
    }

    // Form thêm sự cố mới
    public function create()
    {
        $computers = Computer::all(); // Lấy danh sách máy tính
        return view('issues.create', compact('computers'));
    }

    // Thêm sự cố mới
    public function store(Request $request)
    {
        $request->validate([
            'computer_id' => 'required|exists:computers,id',
            'reported_by' => 'required|string|max:255',
            'reported_date' => 'required|date',
            'description' => 'required|string',
            'urgency' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        Issue::create($request->all());

        return redirect()->route('issues.index')->with('success', 'Sự cố đã được thêm thành công!');
    }

    // Form chỉnh sửa sự cố
    public function edit($id)
    {
        $issue = Issue::findOrFail($id);
        $computers = Computer::all();
        return view('issues.edit', compact('issue', 'computers'));
    }

    // Cập nhật thông tin sự cố
    public function update(Request $request, $id)
    {
        $request->validate([
            'computer_id' => 'required|exists:computers,id',
            'reported_by' => 'required|string|max:255',
            'reported_date' => 'required|date',
            'description' => 'required|string',
            'urgency' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $issue = Issue::findOrFail($id);
        $issue->update($request->all());

        return redirect()->route('issues.index')->with('success', 'Sự cố đã được cập nhật thành công!');
    }

    // Xóa sự cố với xác nhận
    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();

        return redirect()->route('issues.index')->with('success', 'Sự cố đã được xóa thành công!');
    }
}
