<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\SocialAccount;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB; 
use App\Repositories\Interfaces\ISuccessEntityResponse;
use Illuminate\Support\Facades\Auth;
class GoogleController extends Controller
{
    protected $successEntityResponse;
    public function __construct(ISuccessEntityResponse $successEntityResponse){
        $this->successEntityResponse = $successEntityResponse;
    }
    public function googleLoginUrl()
    {

        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return $this->successEntityResponse->createResponse([
           'url' => $url 
        ]);
    }
    public function loginCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = null;
        $socialAccounts= null;
        DB::transaction(function () use ($googleUser, &$user, &$socialAccounts) {
            $user = User::firstOrCreate(
                [
                    'social_id' => $googleUser->id, 
                ],
                [
                    'avatar' => $googleUser->avatar, 
                    'social_provider' => 'google',
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,   
                ]
            );
            $socialAccounts = SocialAccount::create([
                'user_id' => $user->id,
                'access_token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken,
                'expires_at' => date( 'Y-m-d H:i:s',strtotime(now()) + $googleUser->expiresIn)
                
            ]);
        });
        $token = $user->createToken('user')->plainTextToken;
        return $this->successEntityResponse->createResponse([
                'user' => $user,
                'google_user' => $googleUser,
                'token' =>  $token
        ]);
    }
    public function getUser(Request $request){
        $user = Socialite::driver('google')->userFromToken('ya29.a0AWY7CknH_ZYDwHm02CkDR4YHpRprhmkGbKQTr6JlmYsEYHAEAXjFm982OTxk9Sxe06SqRhIMbHQKV9LkplNxvJMOUSrEBzBrudLouwwJ9RfZagzbbGKDwvGtq3Wj2nnq2RM3_aEvquQmcMSgci9qwsbagHnHaCgYKAZgSARASFQG1tDrpQSdkPsSC6oV1l9CXTMcjBw0163');
        return $this->successEntityResponse->createResponse([
            'user' => $user,
        ]);
    }
}
