<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\AddAvatarRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-all-users');
        $users = User::active()->get();
        return USerResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create-user');
        $validated = $request->validated();
        $attributes = [
            'name'      => $validated['name'],
            'phone'     => $validated['phone'],
            'address'   => $validated['address'],
            'email'     => $validated['email'],
            'password'  => \bcrypt($validated['password']),
        ];

        $user = User::create($attributes);
        event(new Registered($user));
        $user->assignRole($validated['role']);
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view-user');
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('edit-user');
        $user->update($request->validated());
/* 
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
 */
        return (new UserResource($user->refresh()))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete-user');
        $user->delete();
        return response()->json([
            'message' => __('User successfully deleted')
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request, User $user)
    {
        $user = auth()->user();
        $credentials = [
            'email'     => $user->email,
            'password'  => $request->current_password
        ];
    
        try
        {
            if (! auth()->attempt($credentials))
            {
                return response()->json(['error' => 'Wronge current password!']);
            }
            else
            {
                $user->update([
                    'password' =>  bcrypt($request->password),
                ]);
                return response()->json([
                    'message' => __('Password Changed Successfully'),
                ]);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
    }
    
    public function Addavatar(AddAvatarRequest $request, User $user) 
    {
    
        $user = Auth()->user();

        if ($request->has('avatar')) 
        {
            if ($user->avatar && $request->input('avatar') !== $user->avatar->file_name) 
            {
                $user->avatar->delete();
            }
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        return response()->json([
            'message'   => __('certificate successfully updated'),
            'data'      => new UserResource($user->refresh())
        ]);

        return response()->json([
            'message' => __('Avatar successfully updated')
        ]);   

    }
}
