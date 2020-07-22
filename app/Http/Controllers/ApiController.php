<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        $input = $request->only('username', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    /**
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    * @throws \Illuminate\Validation\ValidationException
    */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    /**
     * @param RegistrationFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegistrationFormRequest $request)
    {
        if(!Gate::allows('isAdmin')) {
            return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized.'
                ], 403);
        }
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();
        

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            'success'   =>  true,
            'data'      =>  $user
        ], 200);
    }
    public function index()
    {
        if(!Gate::allows('isAdmin')) {
            return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized.'
                ], 403);
        }            
        $users = User::all();
        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, food intakes cannot be found.'
            ], 400);
        }
        return response()->json([
                'success' => true,
                'data' => $users
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        if(!Gate::allows('isAdmin')) {
            return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized.'
                ], 403);
        }       
        $user = USer::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $id . ' cannot be found.'
            ], 400);
        }
        return response()->json([
             'success' => true,
             'data' => $user
        ]);
    }
    
    public function update(Request $request, $id)
    {
        if(!Gate::allows('isAdmin')) {
            return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized.'
                ], 403);
        }   
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, owner with id ' . $id . ' cannot be found.'
            ], 400);
        }

        // $updated = $user->update($request->all());

        $updated = $user->fill([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id
        ])->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user could not be updated.'
            ], 500);
        }
    }
    public function destroy($id)
    {
        if(!Gate::allows('isAdmin')) {
            return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized.'
                ], 403);
        }   
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $id . ' cannot be found.'
            ], 400);
        }

        if ($user->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'user could not be deleted.'
            ], 500);
        }
    }
    public function checkUser(Request $request)
    {
        if(! Gate::allows('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'Not Authorized.'
            ], 403);
        }

        $this->validate($request, [
            'token' => 'required'
        ]);
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if($user){
                return response()->json([
                    'success'=> true,
                    'data' => $user,
                ]);
            }else {
                return response()->json([
                    'success'=> false,
                    'message' => "Authentication error",
                ]);
            }

        }
        catch(Exception $error){
            return response()->json([
                'success'=> false,
                'message' => "Authentication error",
            ]);
        }
    }
    public function getusersroles()
    {
        if(!Gate::allows('isAdmin')) {
            return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized.'
                ], 403);
        }
        $result = User::join('roles', 'roles.id', '=', 'users.role_id')
            ->select('users.id as user_id', 'users.username as user_username', 'roles.name as role_name')
            ->get()
            ->toArray();
        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, information cannot be found.'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}