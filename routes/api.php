use App\Http\Controllers\Api\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'statistics']);