<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = user::paginate(config('admin.pagination'));
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // $staff = $request['type'];

        // $employee = new Employee();
        // $employee->name = $request->input('name');
        // $employee->phone = $request->input('phone');
        // $employee->type = $request->input('type');
        // $employee->save();

        // if($staff == 0)
        // {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->type_id = $request->input('type_id');
            $user->password = Hash::make($request['password']);
            $user->save();
        // }
        return redirect()->route('admins.index')->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = User::find($id);
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, $id )
    {
        $admin = User::findOrFail($id);

            // قم بتجميع البيانات الأساسية
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'type_id' => $request->type_id,
            ];

            // تحقق مما إذا كانت كلمة المرور قد تم إرسالها وليست فارغة
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $admin->update($data);

        return redirect()->route('admins.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id )
    {
        $client = User::find($id);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Deleted Successfully');
    }
}