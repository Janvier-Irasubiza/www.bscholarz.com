<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentsController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(10);
        return view("admin.departments", compact("departments"));
    }

    public function newDpt()
    {
        return view("admin.new-dpt");
    }

    public function createDpt(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string",
            "description" => "required|string",
        ]);

        Department::create($validatedData);

        return redirect()->route("admin.departments")->with("success", "Department created successfully");
    }

    public function editDpt(Request $request)
    {
        $dpt = Department::find($request->dpt);

        if ($dpt) {
            return view("admin.edit-dpt", compact("dpt"));
        } else {
            return back()->with("error", "Department Not Found");
        }
    }

    public function updateDpt(Request $request, $id)
    {
        $validatedData = $request->validate([
            "name" => "required|string",
            "description" => "required|string",
        ]);

        $dpt = Department::find($id);
        $dpt->update($validatedData);

        return redirect()->route("admin.departments")->with("success", "Departments update successfully");
    }

    public function openDpt(Request $request) {
        $dpt = Department::find($request->dpt);
        $dpt->status = 'active';
        $dpt->save();

        return back()->with('success','Department activated successfully');
    }

    public function closeDpt(Request $request) {
        $dpt = Department::find($request->dpt);
        $dpt->status = 'inactive';
        $dpt->save();
        return back()->with('success','Department deactivated successfully');
    }
}
