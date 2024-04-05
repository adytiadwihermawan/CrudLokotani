@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>User Details</h1>
        </div>
        <div class="card-body">
            <p>ID: {{ $user->id }}</p>
            <p>Name: {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>Created At: {{ $user->created_at_formatted }}</p>
            <p>Updated At: {{ $user->updated_at_formatted }}</p>

            <!-- Delete button -->
            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
            </form>
        </div>
    </div>
@endsection
