<?php

namespace App\Http\Controllers;

use App\Http\Requests\UersRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function init() {
        $id = Auth::id();
        $user = User::with("roles")->where("id", $id)->first();
        return ["user" => $user];
    }
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login','signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validateData=$request->validate([
            'password'=>'required',
            'name'=>'required',

        ]);
        $serial =  shell_exec('wmic DISKDRIVE GET SerialNumber 2>&1');
        $mixins= DB::table('mixins_info')->where('id',1)->first();

        $contains = Str::contains($serial, $mixins->mixins_mac_serial);
        if ($contains &&strlen($mixins->mixins_mac_serial)>5) {
            $credentials = request(['name', 'password']);
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'تأكد من اسم المستخدم وكلمة السر !'], 401);
            }

            return $this->respondWithToken($token);
        }else{
            return response()->json(['error' => 'نسخة غير موثقة'], 401);

        }

    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function signup(UersRequest $request)
    {
        $data = array();
        $data['name'] = $request->name;
//        $data['email'] = $request->email;
        $data['password'] =Hash::make($request->password);
        DB::table('users')->insert($data);
        return $this->login();

    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'username'=>auth()->user()->name,
            'user_id'=>auth()->user()->id,
//            'email'=>auth()->user()->email,
            'roles'=>auth()->user()->roles,
        ]);
    }
}
