<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Traits\CustomAuthorizationsTrait;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use CustomAuthorizationsTrait;

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
        return UserResource::collection(User::paginate(5));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateRequest $request, User $user)
    {
        $this->canEditUser($user);

        $user->update($request->all());

        return response()->json(new UserResource($user),  Response::HTTP_OK);//200
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->canRemoveUser($user);

        // $user->associated_model->each()->delete();
        $user->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);//204
    }
}
