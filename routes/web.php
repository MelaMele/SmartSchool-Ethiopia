<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\MarklistController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\CommunicationBookController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\ScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/* =========================================================================
   1. አስተዳዳሪ (ADMIN) ROUTES
========================================================================= */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');

    Route::resource('classes', ClassController::class);
    Route::resource('subjects', SubjectController::class);

    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::post('/sections/auto-assign', [SectionController::class, 'autoAssignStudents'])->name('sections.auto_assign');

    Route::resource('students', StudentController::class);

    Route::get('/export/single-id/{id}', [ExportController::class, 'generateSingleIdCard'])->name('export.single_id');
    Route::get('/export/class-ids/{class_id}/{section_id}', [ExportController::class, 'generateClassIdCards'])->name('export.class_ids');
    Route::get('/marklist/report-card/{student_id}/{semister_id}', [MarklistController::class, 'generateReportCard'])->name('marklist.report_card');

    // SMS መልዕክት መላኪያ
    Route::get('/sms', [SmsController::class, 'index'])->name('sms.index');
    Route::post('/sms/send-bulk', [SmsController::class, 'sendBulk'])->name('sms.send_bulk');

    // የክፍለ-ጊዜ መርሃ-ግብር (Timetable)
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
});

/* =========================================================================
   2. መምህራን እና አድሚን ROUTES
========================================================================= */
Route::middleware(['auth', 'role:admin,teacher'])->group(function () {
    Route::get('/teacher/dashboard', function () { return view('teacher.dashboard'); })->name('teacher.dashboard');

    Route::get('/marklist', [MarklistController::class, 'index'])->name('marklist.index');
    Route::post('/marklist', [MarklistController::class, 'store'])->name('marklist.store');

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/get-students', [AttendanceController::class, 'getStudents'])->name('attendance.get_students');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

    // የግንኙነት ደብተር (Communication Book)
    Route::get('/communication/{student_id}', [CommunicationBookController::class, 'index'])->name('communication.index');
    Route::post('/communication/{student_id}', [CommunicationBookController::class, 'store'])->name('communication.store');
});

/* =========================================================================
   3. ፋይናንስ ROUTES
========================================================================= */
Route::middleware(['auth', 'role:admin,finance'])->prefix('finance')->group(function () {
    Route::get('/dashboard', [FinanceController::class, 'dashboard'])->name('finance.dashboard');
    Route::post('/payments', [FinanceController::class, 'storePayment'])->name('finance.payments.store');
    Route::get('/check-fs/{fs_number}', [FinanceController::class, 'checkFsNumberExists'])->name('finance.check_fs');
});

/* =========================================================================
   4. ወላጆች ROUTES
========================================================================= */
Route::middleware(['auth', 'role:parent'])->prefix('parent')->group(function () {
    Route::get('/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');
    Route::get('/student/{student_id}', [ParentController::class, 'viewStudentDetails'])->name('parent.student_details');
    // ወላጁ የግንኙነት ደብተሩን ሲያረጋግጥ
    Route::post('/communication/acknowledge/{id}', [CommunicationBookController::class, 'acknowledge'])->name('communication.acknowledge');
});

require __DIR__.'/auth.php';
