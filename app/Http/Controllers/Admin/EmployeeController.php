<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employee::join('users', 'users.id', '=', 'employees.user_id')
        ->select('employees.id', 'employees.user_id', 'employees.firstnames', 'employees.surname', 'employees.gender', 'employees.phone', 'users.email', 'users.name as username')
        ->paginate(10);
        $search = $request->search;
        if(isset($search) && $search != "") {
            $employees = Employee::join('users', 'users.id', '=', 'employees.user_id')
            ->select('employees.id', 'employees.firstnames', 'employees.surname', 'employees.gender', 'employees.phone', 'users.email', 'users.name as username', 'employees.user_id')
            ->where("employees.firstnames","LIKE","%". $search ."%")
            ->orWhere("employees.surname","LIKE","%". $search ."%")
            ->orWhere("users.name","LIKE","%". $search ."%")
            ->orWhere("users.email","LIKE","%". $search ."%")
            ->paginate(10);
        }

        return view('admin.employee', [
            'employees'=> $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'firstname' => ['required', 'alpha', 'min:3'],
                'surname' => ['required', 'alpha', 'min:3'],
                'gender' => ['required', 'alpha', 'min:4', 'max:6'],
                'phone' => ['required', 'starts_with:07', 'digits:10', 'unique:employees'],
                'address' => ['required', 'string'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => ['required', 'alpha']
            ]);

            $user = User::create([
                'name' => $request->surname.$request->firstname[0],
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->addRole($request->role);

            Employee::create([
                'user_id' => $user->id,
                'firstnames' => $request->firstname,
                'surname'=> $request->surname,
                'gender' => $request->gender,
                'phone'=> $request->phone,
                'address'=> $request->address,
            ]);

            return redirect()->back()->with('success','Successfully added a new employee');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                'firstname' => ['required', 'alpha', 'min:3'],
                'surname' => ['required', 'alpha', 'min:3'],
                'gender' => ['required', 'alpha', 'min:4', 'max:6'],
                'phone' => ['required', 'starts_with:07', 'digits:10', 'unique:employees'],
            ]);

            Employee::find($id)->update([
                'firstnames' => $request->firstname,
                'surname'=> $request->surname,
                'gender' => $request->gender,
                'phone'=> $request->phone,
            ]);

            return redirect()->back()->with('success','Successfully updated employee');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            Employee::find($id)->delete();

            return redirect()->back()->with('success','Successfully deleted employee');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
