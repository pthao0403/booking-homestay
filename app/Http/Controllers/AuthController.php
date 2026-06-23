<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');
    }
    public function handleForm(Request $request) {
    // Gửi request kiểm tra lên Google
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => '6LeYGy4tAAAAAO0wIg8dQthlvEqxtNXl6S7c1v6f',
        'response' => $request->input('g-recaptcha-response'),
    ]);

    if (!$response->json()['success']) {
        return back()->withErrors(['captcha' => 'Vui lòng xác minh bạn không phải là người máy!']);
    }
    
    // Tiếp tục xử lý logic đăng nhập/đăng ký...
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký tài khoản thành công!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Đăng xuất thành công!');
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        if (empty($clientId) || $clientId === 'YOUR_GOOGLE_CLIENT_ID') {
            // Mock Mode!
            return redirect()->route('auth.google.mock');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            return redirect()->route('auth.google.mock');
        }
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Đăng nhập bằng Google thất bại hoặc bị hủy.',
            ]);
        }

        $user = User::updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            // Password remains null or unchanged
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng nhập bằng Google thành công!');
    }

    /**
     * Show the Mock Google login page.
     */
    public function showGoogleMock()
    {
        return view('auth.google_mock');
    }

    /**
     * Handle Mock Google login submission.
     */
    public function handleGoogleMock(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = User::updateOrCreate([
            'email' => $request->email,
        ], [
            'name' => $request->name,
            'google_id' => 'mock_google_id_' . md5($request->email),
            'role' => $request->email === 'admin@example.com' || str_contains($request->email, 'admin') ? 'admin' : 'customer',
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng nhập giả lập Google thành công!');
    }
}
