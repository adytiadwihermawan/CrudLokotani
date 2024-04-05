@extends('layouts.app')

@section('title', 'List of Users')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>List of Users</h1>
    </div>
    <div class="card-body">
        <!-- Search form -->
        <form action="{{ route('users.index') }}" method="GET" class="mb-3" id="searchForm">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search by name or email" value="{{ request()->input('search') }}">
                </div>
            </div>
        </form>

        <!-- Button to add new user -->
        <div class="mb-3">
            <a href="{{ route('users.create') }}" class="btn btn-success">Add New User</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Users table -->
        @if ($users->isEmpty())
            <div class="alert alert-info" role="alert">
                No users found.
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <a href="{{ route('users.index', ['sort_column' => 'id', 'sort_order' => ($sortColumn == 'id' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">ID</a>
                        </th>
                        <th>
                            <a href="{{ route('users.index', ['sort_column' => 'name', 'sort_order' => ($sortColumn == 'name' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">Name</a>
                        </th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <a href="{{ route('users.detail', $user->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="d-flex justify-content-center">
                {{ $users->appends(['sort_column' => $sortColumn, 'sort_order' => $sortOrder])->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    // Attach keyup event listener to search input field
    document.getElementById('searchInput').addEventListener('keyup', function() {
        // Submit the search form when the user types in the search input field
        document.getElementById('searchForm').submit();
    });
</script>

@endsection
