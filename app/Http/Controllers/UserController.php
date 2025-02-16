<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::query();
            // before we give our table data to datatable , it must be in query format 
            //then datatable will draw our given query in front page 
            return DataTables::eloquent($users)

                #adding index column
                ->addIndexColumn()
                ->addColumn('created_at', function ($user) {
                    return Carbon::parse($user->created_at)->format('Y-m-d');
                })
                #adding action column
                ->addColumn('action', function ($user) {
                    return "
                    <a href='" . route('user.edit', ['id' => $user->id]) . "' class='btn btn-success'>Edit</a>
                    <button data-id='" . $user->id . "' class='btn btn-danger delete-user'>delete</a>
                ";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('welcome');
    }


    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        dd($user);
    }


    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['status' => "success", 'message' => 'user deleted']);
    }
}
