<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login() {
        return view('auth.login');
    }

    public function register() {
        return view('auth.register');
    }

    public function loginLawyer()
    {
        return view('auth.login-lawyer');
    }

    public function registerLawyer()
    {
        $expertiseOptions = Expertise::all();
        return view('auth.register-lawyer', compact('expertiseOptions'));
    }

    public function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'phoneNumber' => $data['phoneNumber'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'password' => Hash::make($data['password']),
            'profileLink' => $data['profile'],
          ]);
    }

    public function registerProcess(Request $request) {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'phoneNumber' => 'required',
            'gender' => 'required|in:male,female',
            'dob' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'profile' => 'required|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $data = $request->all();
        // if($request->hasFile('profile')) {
        //     $data['profile'] = $request->file('profile')->store('user_profiles', 'public');
        // }
        if ($request->hasFile('profile')) {
            $data['profile'] = file_get_contents($request->file('profile')->getRealPath());
        }

        $user = $this->create($data);

        Auth::login($user);

        return redirect('/')->withSuccess('Register Successful!');
    }

    public function createLawyer(array $data) {
        return Lawyer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phoneNumber' => $data['phoneNumber'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'password' => Hash::make($data['password']),
            'education' => $data['education'],
            'address' => $data['address'],
            'experience' => $data['experience'],
            'rate' => $data['rate'],
            'profileLink' => $data['profile'],
        ]);
    }

    public function registerProcessLawyer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:lawyers,email',
            'phoneNumber' => 'required',
            'gender' => 'required|in:male,female',
            'dob' => 'required',
            'password' => 'required|min:6',
            'education' => 'required',
            'address' => 'required',
            'experience' => 'required',
            'rate' => 'required',
            'profile' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'expertise' => 'required|array',
            'expertise.*' => 'exists:expertises,id'
        ]);

        $data = $request->all();
        // if($request->hasFile('profile')) {
        //     $data['profile'] = $request->file('profile')->store('lawyer_profiles', 'public');
        // }
        if ($request->hasFile('profile')) {
            $data['profile'] = file_get_contents($request->file('profile')->getRealPath());
        }

        $lawyer = $this->createLawyer($data);
        $lawyer->expertises()->attach($validated['expertise']);
        Auth::guard('lawyer')->login($lawyer);

        return redirect('/')->with('success', 'Registration Successful!');
    }

    public function loginProcess(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')->with('success', 'Login Successful!');
        }

        return redirect('login')->with('error', 'Invalid Credentials!');
    }

    public function loginProcessLawyer(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::guard('lawyer')->attempt($credentials)) {
            return redirect()->intended('/')->with('success', 'Login Successful!');
        }

        return redirect()->route('lawyer.login')->with('error', 'Invalid Credentials!');
    }

    public function logout(): RedirectResponse {
        if (Auth::guard('lawyer')->check()) {
            Auth::guard('lawyer')->logout();
            Session::flush();

            return redirect()->route('lawyer.login')->with('success', 'Logged out successfully!');
        }

        Auth::guard('web')->logout();
        Session::flush();

        return redirect('login')->with('success', 'Logged out successfully!');
    }

    public function profile() {
        $role = 'User';
        if (Auth::guard('lawyer')->check()) {
            $role = 'Lawyer';
        }

        return view('profile', compact('role'));
    }

    public function deleteLawyer(Request $request) {
        $lawyer = Auth::guard('lawyer')->user();
        $lawyer->delete();

        Auth::guard('lawyer')->logout();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }

    public function deleteUser(Request $request) {
        $user = Auth::user();
        $user->delete();
        Session::flush();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }

    public function changePasswordUser(Request $request) {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }

    public function changePasswordLawyer(Request $request) {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        $lawyer = Auth::guard('lawyer')->user();

        if (!Hash::check($request->current_password, $lawyer->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $lawyer->password = Hash::make($request->new_password);
        $lawyer->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
