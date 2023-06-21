<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StaffAuthResource;
use App\Http\Requests\StoreNewCustomerRequest;

use App\Repositories\Interfaces\ISuccessCollectionResponse;
use App\Repositories\Interfaces\ISuccessEntityResponse;
use App\Exceptions\CustomException\AuthenticationFailed;
use App\Models\Admin;

use App\Models\Staff;
use App\Models\Customer;
use App\Models\Role;

class AuthAdminController extends Controller
{
   protected $successEntityResponse,$successCollectionResponse;
   public function __construct(ISuccessCollectionResponse $successCollectionResponse,
   ISuccessEntityResponse $successEntityResponse){
       $this->successCollectionResponse = $successCollectionResponse;
       $this->successEntityResponse = $successEntityResponse;
   }

    public function register(Request $request){

        $data = $request->validate([
            'name'=> 'string|max:255|required',
            'email'=> 'email|required|unique:admins,email',
            'password' => 'required|string'
        ]);
        $data['password'] = bcrypt($data['password']);
        $admin = Admin::create($data);
        unset($admin['password']);
        $token = $admin->createToken('admin')->plainTextToken;
        return   $this->successEntityResponse->createResponse([
            'token' => $token,
            'info' => $admin
        ],200);
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => [
                'required'
            ],
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if(!Auth::attempt($credentials, $remember)){
            return throw new AuthenticationFailed("Invalid email or password.");
        }
        $admin = Auth::user();
        // $user_info =  Admin::where('id',$admin['id'])->first();
        $token = $admin->createToken('admin')->plainTextToken;
        return $this->successEntityResponse->createResponse([
            'token' => $token,
            'info' => $admin,
        ]);    
    }

    public function logout(){
        $admin = Auth::user();
        $admin->currentAccessToken()->delete();
        return response()->json(['result' => 'ok']);
    }
}
