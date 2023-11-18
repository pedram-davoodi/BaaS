<?php

namespace Modules\User\app\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\User\app\Events\AdminLoggedIn;
use Modules\User\app\Events\AdminRegistered;
use Modules\User\app\Models\Admin;

class AdminController extends Controller
{
    /**
     * Handles user logins
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        $admin = Admin::firstWhere('email' , $credentials['email']);

        if (!Hash::check($credentials['password' ] , $admin->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $tokenResult = $admin->createToken('Personal Access Token');

        // Dispatch logged in event
        AdminLoggedIn::dispatch($admin);

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at,
        ]);
    }

    /**
     * Register API
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'unique:admins,email|required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // Create a new user
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $admin = Admin::create($input);

        // Dispatch logged in event
        AdminRegistered::dispatch($admin);

        // Create and return an access token along with user details
        $success['token'] = $admin->createToken('MyApp')->accessToken;
        $success['name'] = $admin->name;
        return response()->json(['success' => $success]);
    }
}
