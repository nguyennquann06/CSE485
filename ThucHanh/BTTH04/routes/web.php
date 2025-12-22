<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;

// Route cho Issue (Sự cố)
Route::resource('/', IssueController::class);

// Các route CRUD cho sự cố:
// Route để xem danh sách sự cố (tự động tạo từ Route::resource)
Route::get('issues', [IssueController::class, 'index'])->name('issues.index');

// Route để thêm sự cố mới
Route::get('issues/create', [IssueController::class, 'create'])->name('issues.create');

// Route để lưu sự cố mới vào cơ sở dữ liệu
Route::post('issues', [IssueController::class, 'store'])->name('issues.store');

// Route để sửa sự cố
Route::get('issues/{issue}/edit', [IssueController::class, 'edit'])->name('issues.edit');

// Route để cập nhật sự cố đã sửa
Route::put('issues/{issue}', [IssueController::class, 'update'])->name('issues.update');

// Route để xóa sự cố
Route::delete('issues/{issue}', [IssueController::class, 'destroy'])->name('issues.destroy');
