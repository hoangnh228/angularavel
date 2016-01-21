<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;

class EmployeeController extends Controller
{
    public function index($id = null) {
        if ($id == null) {
            return Employee::orderBy('id', 'ASC')->get();
        } else {
            return Employee::findOrFail($id);
        }
    }

    public function store(Request $request) {
        return $employee = Employee::create($request::all());
    }

    public function update(Request $request, $id) {
        $employee = Employee::findOrFail($id);
        $employee->update($request::all());
        return $employee;
    }

    public function destroy($id) {
        Employee::destroy($id);
        return 'Employee #' . $id . ' deleted successfully!';
    }
}
