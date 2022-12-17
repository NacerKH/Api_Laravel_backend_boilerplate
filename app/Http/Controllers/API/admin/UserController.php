<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends  BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return $this->sendResponse(
            UserResource::collection(User::with(['roles','permissions'])->paginate(3))->response()->getData(true)
            ,"Getting  Your Users Successfully  !");


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $validatedUser = $request->validated();
        $validatedUser['password'] = bcrypt($validatedUser['password']);
        $user_role = Role::where('slug',$validatedUser['role'])->first();
        unset($validatedUser['role']) ;
        $user = User::create($validatedUser);
        $user->roles()->attach($user_role);


        return $this->sendResponse(UserResource::make($user) ,'User Added successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::with(['roles'])->find($id);
        return $this->sendResponse(UserResource::make($user) ,"user retrieved successfully");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {

     abort_unless(auth()->user->hasRole('admin'),Response::HTTP_UNAUTHORIZED,'You are Not Allowed to destroy this User');
        $validatedUser = $request->validated();
        $user=User::findOrfail($id);
        $user->update($validatedUser);
        return $this->sendResponse(UserResource::make($user) ,'User showed successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless(auth()->user->hasRole('admin'),Response::HTTP_UNAUTHORIZED,'You are Not Allowed to destroy this User');
        $user=User::findOrfail($id);
        $user->deleteProfilePhoto();
        $user->delete();
        return response()->noContent();
    }
}
