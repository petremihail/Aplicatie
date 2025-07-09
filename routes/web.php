<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\TaskAdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\SurveyController as AdminSurveyController;
use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;

app('router')->aliasMiddleware('role', \App\Http\Middleware\RoleMiddleware::class);

Route::get('/', function()
{
    return view('home');
});

// User routes
Route::get('/users', [UserController::class, 'indexUser'])->middleware('role:admin,hr');
Route::get('/users/manage/', [UserController::class,'show'])->middleware('auth');
Route::get('/users/manage/{id}', [UserController::class,'show'])->middleware('role:admin,hr');

// Authentication routes
Route::get('/register', [UserController::class,'create']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/login', [UserController::class,'login'])->name('login');
Route::post('/users/authenticate', [UserController::class,'authenticate']);
Route::post('/logout', [UserController::class,'logout'])->middleware('auth')->name('logout');

// Attendance routes
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'indexAttendance'])->name('attendance.index');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
    Route::post('/chat', [App\Http\Controllers\ChatbotController::class, 'chat'])->middleware('auth');
});

// Course routes
Route::get('/courses', [CourseController::class, 'indexCourses'])->middleware('auth');
Route::post('/courses/take/{id}', [CourseController::class, 'takeCourse'])->middleware('auth');
Route::get('/courses/view/{id}', [CourseController::class, 'viewCourse'])->name('course.viewCourse')->middleware('auth');

Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/courses/{course}/add-content', [CourseContentController::class, 'create'])->name('course_contents.create');
    Route::post('/courses/{course}/add-content', [CourseContentController::class, 'store'])->name('course_contents.store');
});
Route::post('/courses/{course}/{content}/complete', [CourseController::class, 'markCompleted'])->name('courses.markCompleted');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Task routes
Route::get('/my-tasks', [TaskController::class, 'userTasks'])->name('tasks.my')->middleware('auth');
Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete')->middleware('auth');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth');

// Survey routes
Route::middleware(['auth'])->group(function (): void {
    Route::get('/surveys', [SurveyController::class, 'indexSurvey'])->name('surveys.indexSurvey');
    Route::get('/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
    Route::post('/surveys/{survey}', [SurveyController::class, 'submit'])->name('surveys.submit');
});

// Post routes
Route::get('/posts', [PostController::class, 'indexPosts'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->middleware('auth')->name('posts.comments.store');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Performance dashboard
    Route::get('/performance', [App\Http\Controllers\Admin\PerformanceController::class, 'index'])->name('performance.index');
    
    // User management (restricted to admin role only)
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['index', 'show']);

    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
});

// User management (index and show available to admin and hr roles)
Route::middleware(['auth', 'role:admin,hr'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
});

Route::middleware(['auth', 'role:admin,hr'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Course management
    Route::resource('courses', AdminCourseController::class);
    Route::get('/courses/{course}/assign', [AdminCourseController::class, 'assignForm'])->name('courses.assign');
    Route::post('/courses/{course}/assign', [AdminCourseController::class, 'assignUsers'])->name('courses.assignUsers');
    
    // Task management
    Route::resource('tasks', AdminTaskController::class);
    Route::get('/tasks/{task}/assign', [AdminTaskController::class, 'assignForm'])->name('tasks.assign');
    Route::post('/tasks/{task}/assign', [AdminTaskController::class, 'assignUsers'])->name('tasks.assignUsers');
    
    // Survey management
    Route::resource('surveys', AdminSurveyController::class);
    Route::get('/surveys/{survey}/assign', [AdminSurveyController::class, 'assignForm'])->name('surveys.assign');
    Route::post('/surveys/{survey}/assign', [AdminSurveyController::class, 'assignUsers'])->name('surveys.assignUsers');
    Route::get('/surveys/{survey}/results', [AdminSurveyController::class, 'results'])->name('surveys.results');
    
    // Post management
    Route::resource('posts', AdminPostController::class);
    
    // Role management
    Route::resource('roles', AdminRoleController::class)->except(['edit', 'update']);
    Route::get('/roles/{role}/assign', [AdminRoleController::class, 'assignForm'])->name('roles.assignForm');
    Route::post('/roles/{role}/assign', [AdminRoleController::class, 'assignUsers'])->name('roles.assignUsers');
    
    // Contract management
    Route::resource('contracts', AdminContractController::class);
    Route::get('/contracts/{contract}/assign', [AdminContractController::class, 'assignForm'])->name('contracts.assign');
    Route::post('/contracts/{contract}/assign', [AdminContractController::class, 'assignUsers'])->name('contracts.assignUsers');
    
    Route::resource('roles', AdminRoleController::class);

    // Settings
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');

    // Course Content Routes (within the same middleware group)
    Route::delete('/course_contents/{content}', [CourseContentController::class, 'destroy'])->name('course_contents.destroy');

    

});


