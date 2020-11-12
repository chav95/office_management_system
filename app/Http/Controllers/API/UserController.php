<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::select('id', 'name', 'email', 'privilege', 'created_at')
            ->with('division')
            ->where('status', '=', '1')->orderBy('name', 'asc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->act){ //return $request;
            if($request->act == 'new_user'){
                $this->validate($request, [
                    'name' => 'required|string|max:191',
                    'email' => 'required|string|email|max:191|unique:users',
                    'division' => 'required|integer',
                    'privilege' => 'required|string',
                ]);
                // return $request['privilege'];
                return User::create([
                    'name' => $request['name'],
                    'username' => $request['email'],
                    'email' => $request['email'],
                    'division_id' => $request['division'],
                    'password' => Hash::make('password123'),
                    'privilege' => $request['privilege'],
                    'api_token' => Str::random(60),
                ]);
                // return response()->json(array(
                //     'success' => true,
                // ), 200);
            }else if($request->act == 'edit_user'){
                $this->validate($request, [
                    'name' => 'required|string|max:191',
                    'email' => 'required|string|email|max:191|unique:users,email,'.$request->id,
                    'division' => 'required|integer',
                    'privilege' => 'required|string',
                ]);
                
                return User::where('id', $request->id)
                    ->update([
                        'name' => $request->name,
                        'username' => $request->email,
                        'email' => $request->email,
                        'division_id' => $request->division,
                        'privilege' => $request->privilege,
                    ]);
            }else if($request->act == 'deactivate_user'){
                return User::where('id', $id)->update(['status' => 0]);
            }else if($request->act == 'change_password'){
                $this->validate($request, [
                    'current_password' => 'required|string',
                    'new_password' => 'required|string|min:6',
                    'confirm_new_password' => 'required|string|same:new_password',
                ]);

                $user = User::find($request->id);
                // return response()->json(array(
                //     'result' => Hash::check($request->current_pass, $user->password),
                // ), 200);
                if(Hash::check($request->current_password, $user->password)){
                    return response()->json(array(
                        'success' => true,
                        'result' => 
                            User::where('id', $request->id)->update([
                                'password' => Hash::make($request->new_password),
                            ]),
                    ), 200);
                }else{
                    return response()->json(array(
                        'success' => false,
                        'message' => 'Wrong Current Password',
                    ), 200);
                }
            }else if($request->act == 'reset_password'){
                return User::where('id', $request->id)
                    ->update(['password' => Hash::make('password123')]);
            }
        }else{
            return $request['action'];

            // $this->validate($request, [
            //     'name' => 'required|string|max:191',
            //     'email' => 'required|string|email|max:191|unique:users',
            //     'password' => 'required|string|min:6|confirmed',
            //     'privilege' => 'required|string|'
            // ]);

            // return User::create([
            //     'name' => $request['name'],
            //     'email' => $request['email'],
            //     'password' => Hash::make($request['password']),
            //     'privilege' => $request['privilege'],
            //     'api_token' => Str::random(60),
            // ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id == 'getUserData'){
            return User::with('division')
                ->where('status', '=', '1')
                ->where('privilege', '!=', 'salary')
                ->orderBy('name', 'asc')
                ->get();
        }else if($id == 'getUserList'){
            return User::with('division')
                ->where('status', '=', '1')
                ->where('privilege', '!=', 'salary')
                ->orderBy('name', 'asc')
                ->paginate(10);
        }else if($id == 'getUserLogin'){
            // return auth('api')->user();
            return User::with('division')
                ->with('division')
                ->find(auth('api')->user()->id);
        }else if($id == 'getLoggedUserAccess'){
             
        }
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(array(
            'success' => true, 
            'result' => User::where('id', $id)->delete()
        ), 200);
    }
}