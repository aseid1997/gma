<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');

        // $this->middleware('permission:member-list|member-create|member-edit|member-delete', ['only' => ['index', 'store']]);

        // $this->middleware('permission:member-create', ['only' => ['create', 'store']]);

        // $this->middleware('permission:member-edit', ['only' => ['edit', 'update']]);

        // $this->middleware('permission:member-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = Member::latest()->get();

        return response()->json([
            'data' => $data
        ], 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => 'required',
            'address' => 'nullable',  

        ]);

        $member = Member::create($validated);

        return response()->json([
            'member' => $member,
            'message' => 'Successfully created member!'
        ], 200);

    }

    public function show($id)
    {
        $member = Member::findOrFail($id);

        return response()->json([
            'member' => $member
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        //for update
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable',  
            'phone_number' => 'required',  
        ]);


        $member->update($validated);

        return response()->json([
            'member' => $member,
            'message' => 'Successfully updated member!'
        ], 200);
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json([
            'message' => 'Successfully deleted member!'
        ], 200);

    }
}
