<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function indexUser()
    {   
        return view('users.user', ['users'=> User::orderBy('id')->paginate(4)]);

    }

    public function show(int $id=null){
        if ($id==null){
            $id = auth()->user()->id;
            // dd($id);

            $user = User::find($id);
            $contracts = $user->contracts;
            return view('users.details', ['contracts' => $contracts, 'details' => $user]);
        }else{
            $user = User::find($id);
            $contracts = $user->contracts;
            return view('users.details', ['contracts' => $contracts, 'details' => $user]);
        }
    }

    // public function showContracts($id)
    // {   
    //     $user = User::find($id);

    //     $contracts = $user->contracts;
    //     return view('users.user_contract', ['contracts' => $contracts]);
    // }

    // Show register form
    public function create(Request $request){
        return view('users.register');
    }

    public function store(Request $request){
        $messages = [
            'phone.unique' => 'This phone number is already registered. Please use a different number.',
        ];
        $formFields = $request->validate([
            'first_name' => ['required', 'min:3'],
            'last_name' => ['required', 'min:3'],
            'username' => ['required', 'min:3', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'phone' => ['required', 'min:10', 'max:10', Rule::unique('users', 'phone')],
            'password' => 'required|confirmed|min:6'
        ], $messages);
        
        $formFields['password'] = bcrypt($formFields['password']);
        $user = User::create($formFields);
        $user->roles()->attach(1);

        
        return redirect('/')->with('message', 'User created successfully');
    }

    // Show Login Form
    public function login() {
        return view('users.login');
    }

    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message', 'User logged in');
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','Loged out');
    }
    

}
 