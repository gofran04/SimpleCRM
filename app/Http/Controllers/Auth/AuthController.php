<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){
        $validated = $request->validated();
        if (! $token = auth()->attempt($validated))
        {
            return response()->json(['error' => __('credentials that you entered do not match any of our records')], 401);
        }
      
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegistrationRequest $request) {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);        
        $user = User::create($input);
        event(new Registered($user));
       // $user->assignRole($validated['role']);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        $this->authorize('view-profile');
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }


   /*  public function register(RegistrationRequest $request)
    {
       
   
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password
        ];
      
        if(Auth::guard('api')->attempt($credentials)){ 
       // if(Auth::attempt($credentials)){ 

           // $user = Auth::user(); 
           $user = Auth::guard('api')->user();
           
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    } */
}
