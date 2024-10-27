<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Designation;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "users/";
    
    public function index()
    {
        access_guard(127);
        $rows = User::withTrashed()->where('id', '>', 1)->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(128);
        $users = User::where('id', '>', 1)->get();
        $designations = Designation::all();
        $status = UserStatus::all();
        return view($this->root.'add', compact('users', 'designations', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        access_guard(128);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_role_id' => $request->user_role_id,
            'designation_id' => $request->designation_id,
            'password' => Hash::make($request->password),
            'report_to' => $request->report_to,
            'status_id' => $request->status_id,
            'remarks' => $request->remarks
        ];
        if ($request->hasFile('image')) {
            $data['image'] = request()->file('image')->store('profile', 'public');
        }
        User::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        access_guard(127);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $User, $id)
    {
        access_guard(129);
        $row = User::find($id);
        if(!$row){
            return redirect()->route('users');
        }

        $users = User::where('id', '>', 1)->get();
        $designations = Designation::all();
        $status = UserStatus::all();
        return view($this->root.'edit', compact('row', 'users', 'designations', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $User, $id)
    {
        access_guard(129);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_role_id' => $request->user_role_id,
            'designation_id' => $request->designation_id,
            'report_to' => $request->report_to,
            'status_id' => $request->status_id,
            'remarks' => $request->remarks
        ];
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }
        User::where('id', $id)->update($data);

        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(130);
        DB::beginTransaction();
         try {
            User::find($id)->delete();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been deleted successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }
    public function restore($id = 0)
    {
        access_guard(131);
        DB::beginTransaction();
         try {
            User::withTrashed()->find($id)->restore();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been restored successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }
    public function destroy($id = 0)
    {
        access_guard(132);
        DB::beginTransaction();
         try {
            User::withTrashed()->find($id)->forceDelete();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been deleted successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function login()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        } else {
            $alert = array(
                'message' => 'Invalid user.',
                'alert-type' => 'error'
            );
            return back()->with($alert);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    



}
