<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Admin;
use App\Http\Requests\LoginRequest;
use App\Http\Services\UtilityService;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
     protected $admin;
     protected $utilityService;

    public function __construct()
    {
        $this->middleware("auth:admin",['except'=>['login','register']]);
        $this->admin = new Admin;
        $this->utilityService = new UtilityService;
    }




   public function register(AdminRegisterRequest $request)
   {
       $password_hash = $this->utilityService->hash_password($request->password);
       $this->admin->createUser($request,$password_hash);
       $success_message = "admin registration completed successfully";
    return  $this->utilityService->is200Response($success_message);
   }


    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::guard('admin')->attempt($credentials)) {
            $responseMessage = "invalid admin username or password";
            return $this->utilityService->is422Response($responseMessage);
         }
         

        return $this->respondWithToken($token);
    }


    public function viewProfile()
    {

        $responseMessage="admin Profil";
        $data=Auth::guard("admin")->user();

  return $this->utilityService->is200ResponseWithData($responseMessage,$data);
        /* return response()->json([
            'success'=>true,
            'user' => Auth::guard('user')->user()
            ]
            , 200); */
    }

    
   /**
     * Log the application out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
           
             $this->logUserOut();

        } catch (TokenExpiredException $e) {
            
            $responseMessage = "token has already been invalidated";
            $this->tokenExpirationException($responseMessage);
        } 
    }

    
    public function logUserOut()
    {
        Auth::guard('admin')->logout();
        $responseMessage = "admin successfully logged out";
      return  $this->utilityService->is200Response($responseMessage);
    }

    public function refreshTokenAction()
    {
        return $this->respondWithToken(Auth::guard('admin')->refresh());
    }

    public function tokenExpirationException($responseMessage)
    {
        return $this->utilityService->is422Response($responseMessage);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */




    public function refreshToken()
    {
        try
         {
            return $this->respondWithToken(Auth::guard('admin')->refresh());
        }
         catch (TokenExpiredException $e)
         {
            $responseMessage = "Token has expired and can no longer be refreshed";
            return $this->tokenExpirationException($responseMessage);
        } 
    }

    

}