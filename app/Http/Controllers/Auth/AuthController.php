<?php namespace App\Http\Controllers\Auth;
use App\EndUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            //'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        if($user->email_verified_at== NULL){
            return response()->json(['error'=>'Please Verify Email'], 403);
            }
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user'=>$user
        ]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:end_users,phone',
            'gender'=>'required',
            'email' => 'required|string|email:rfc,dns|max:255|unique:end_users,email',
            'password' => 'required|string|min:8',
          ]);
          if($validator->fails()){
            $errors = $validator->errors();
            return response()->json($errors, 422);
        }
        $request['id']=uniqid('User-');
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = EndUser::create($input);
        $user->sendApiEmailVerificationNotification();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json(Auth::user()->load(['avatar','customerOrders','vehicles','identityCardPicture']));
    }
}
