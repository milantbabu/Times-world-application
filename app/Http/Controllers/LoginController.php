<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Trait\CommonTrait;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Auth;
use Validator;

class LoginController extends Controller
{
    use CommonTrait;

    protected function index(): View
    {
        if (Auth::check()) {
            return view('product.index');
        } else {
            return view('login.index');
        }
    }

    protected function authenticate(Request $request): RedirectResponse
    {
        if ($this->loginFormValidate($request)->fails()) {
            return redirect()->back()->withInput()
            ->withErrors($this->loginFormValidate($request)->messages());
        } else {
            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                toastr()->success('Welcome to Times World App');
                return redirect()->route('products');
            } else {
                toastr()->error('Invalid user name or password');
                return redirect()->back();
            }
        }
    }

    private function loginFormValidate($request): object
    {
        return Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email is mandatory.',
            'password.required' => 'Password is mandatory.'
        ]);
    }

    protected function profile(): View
    {
        $profile = $this->getUser()->find(Auth::id());
        return view('login.profile')->with(compact('profile'));
    }

    protected function store(Request $request): JsonResponse
    {
        $validatedData = Validator::make($request->all(),[
            'name' => 'required',
            'email'=>'bail|required|unique:users,email,' . Auth::id() . ',id,deleted_at,NULL',
        ]);
        if ($validatedData->fails()) {
            $jsonArray = [
                'status' => 'validationError', 
                'messages' => $validatedData->messages()
            ];
        } else {
            $user = $this->getUser()->find(Auth::id());
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->filled('change_password')){
                $user->password = bcrypt($request->user_password);
            }
            $user->save();
            toastr()->success('Profile Updated Successfully!');
            $jsonArray = [
                'status'=>'success',
                'next'=>route('products')
            ];
        }
        return response()->json($jsonArray);
    }

    protected function logout(): RedirectResponse
    {
        toastr()->success('Successfully Logout.');
        Auth::logout();
        return redirect()->route('login');
    }
    
}
