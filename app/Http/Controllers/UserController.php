<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UsersRequest;
use App\Http\Requests\Users\UsersUpdateRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(25);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
//        dd($roles);
        return view('users.create', compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsersRequest $request)
    {
        $validateData = $request->validated();
        User::create($validateData);
        return redirect()->route('users.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles =  Role::pluck('name', 'id');

        return view('users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersUpdateRequest $request, User $user)
    {
        $validateData = $request->validated();
        $user->update($validateData);
        return redirect()->route('users.index')->with('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index',$user)->with('success');

    }
}
