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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// መነሻ ገጽ - ወደ Login መምራት
Route::get('/', function () {
    return redirect()->route('login');
});

/* =========================================================================
   1. አስተዳዳሪ (ADMIN) ROUTES - ሙሉ ቁጥጥር
========================================================================= */
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // የክፍል ደረጃዎች (Classes)
    Route::resource('classes', ClassController::class);

    // የትምህርት አይነቶች (Subjects)
    Route::resource('subjects', SubjectController::class);

    // ሴክሽኖች እና ተማሪዎችን በራስ-ሰር መመደቢያ (Sections & Auto-assign)
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::post('/sections/auto-assign', [SectionController::class, 'autoAssignStudents'])->name('sections.auto_assign');

    // የተማሪዎች ሙሉ አስተዳደር (Students CRUD)
    Route::resource('students', StudentController::class);

    // የተማሪ መታወቂያ ካርድ ማመንጫ (ID Cards with QR Code)
    Route::get('/export/single-id/{id}', [ExportController::class, 'generateSingleIdCard'])->name('export.single_id');
    Route::get('/export/class-ids/{class_id}/{section_id}', [ExportController::class, 'generateClassIdCards'])->name('export.class_ids');

    // የውጤት ካርድ ማመንጫ (Report Card)
    Route::get('/marklist/report-card/{student_id}/{semister_id}', [MarklistController::class, 'generateReportCard'])->name('marklist.report_card');
});

/* =========================================================================
   2. መምህራን (TEACHERS) & አድሚን ROUTES - ውጤት እና አቴንዳንስ
========================================================================= */
Route::middleware(['auth', 'role:admin,teacher'])->group(function () {
    
    // የመምህር ዳሽቦርድ
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');

    // ውጤት መመዝገቢያ (Marklist)
    Route::get('/marklist', [MarklistController::class, 'index'])->name('marklist.index');
    Route::post('/marklist', [MarklistController::class, 'store'])->name('marklist.store');

    // አቴንዳንስ መመዝገቢያ (Attendance)
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/get-students', [AttendanceController::class, 'getStudents'])->name('attendance.get_students');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
});

/* =========================================================================
   3. ፋይናንስ (FINANCE) ROUTES - ክፍያ እና ደረሰኝ
========================================================================= */
Route::middleware(['auth', 'role:admin,finance'])->prefix('finance')->group(function () {
    
    // የፋይናንስ ዳሽቦርድ
    Route::get('/dashboard', [FinanceController::class, 'dashboard'])->name('finance.dashboard');
    
    // ክፍያ መመዝገብ
    Route::post('/payments', [FinanceController::class, 'storePayment'])->name('finance.payments.store');

    // የ FS ደረሰኝ ቁጥር መፈተሻ
    Route::get('/check-fs/{fs_number}', [FinanceController::class, 'checkFsNumberExists'])->name('finance.check_fs');
});

/* =========================================================================
   4. ወላጆች (PARENTS) ROUTES - የተማሪ ውጤት እና ክፍያ መከታተያ
========================================================================= */
Route::middleware(['auth', 'role:parent'])->prefix('parent')->group(function () {
    
    // የወላጅ ዳሽቦርድ
    Route::get('/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');

    // የልጁን ውጤት እና አቴንዳንስ መመልከቻ
    Route::get('/student/{student_id}', [ParentController::class, 'viewStudentDetails'])->name('parent.student_details');
});

/* =========================================================================
   የመግቢያ እና የማረጋገጫ መንገዶች (Breeze Auth)
========================================================================= */
require __DIR__.'/auth.php';
