<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve search query from request
        $search = $request->input('search');
        $sortColumn = $request->input('sort_column', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        // Query to retrieve users based on search criteria
        $users = UserData::query();

        // If search query is provided, filter users by name or email
        if ($search) {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            });
        }

        // Apply sorting and ordering
        $users->orderBy($sortColumn, $sortOrder);

        // Get the filtered users
        $users = $users->paginate(3);

        // Check if any users were found
        if ($users->isEmpty()) {
            // No users found, return a message
            return view('layouts.index', ['message' => 'No users found.', 
            'users' => $users,
            'sortColumn' => $sortColumn,
            'sortOrder' => $sortOrder]);
        } else {
            // Users found, return the view with users data
            return view('layouts.index', [
                'users' => $users,
                'sortColumn' => $sortColumn,
                'sortOrder' => $sortOrder
            ]);
        }
    }

    public function create()
    {
        return view('layouts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|alpha_spaces',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|alpha_num',
            'address' => 'nullable',
        ]);

        try {
            // Create a new user with validated data
            $user = UserData::create($validatedData);
    
            // Redirect to the index page with success message
            return redirect()->route('users.index')->with('success', 'User successfully created');
        } catch (\Exception $e) {
            // Redirect back with error message if something goes wrong
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the user data by ID
        $user = UserData::findOrFail($id);

        // Format the timestamps
        $user->created_at_formatted = $user->created_at->format('d F Y H:i:s');
        $user->updated_at_formatted = $user->updated_at ? $user->updated_at->format('d F Y H:i:s') : null;

        // Pass the user data to the view
        return view('layouts.detail', compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the user data by ID
        $user = UserData::findOrFail($id);

        // Pass the user data to the view
        return view('layouts.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|alpha_spaces',
            'phone' => 'nullable|alpha_num',
            'address' => 'nullable',
        ]);

        // Find the user data by ID
        $user = UserData::findOrFail($id);

        // Update the user data with validated input
        $user->update([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);

        // Return a response indicating success
        return redirect()->route('users.index')->with('success', 'User Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Retrieve the user by ID
        $user = UserData::find($id);

        // Check if the user exists
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Perform soft delete
        $user->delete();

        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
