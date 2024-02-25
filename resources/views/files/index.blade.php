@extends('layouts.app')

@section('content')
    <br><br>
    <div class="container">
        {{-- <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active tab-link" data-bs-toggle="tab" href="#newBook">Add Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-link" data-bs-toggle="tab" href="#newCategory">Add Category</a>
                </li>
            </ul> --}}
        @if (session('success'))
            <div class="alert alert-success text-center mb-3">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center mb-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <br>
            <div class="col-md-6">
                <div class="card text-center shadow-lg" style="height: 280px;">
                    <h2 class="card-header"><i class="fa-solid fa-lock"></i> Encryption</h2>
                    <br>
                    <div class="card-body">
                        <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="file" class="form-label"><b>Choose a File to Encrypt</b></label>
                                <br><br>
                                <input class="form-control-file" type="file" id="file" name="file">
                            </div>
                            <div class="mt-auto mb-3">
                                <button type="submit" class="btn btn-primary">Encrypt</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center shadow-lg" style="height: 280px;">
                    <h2 class="card-header"><i class="fa-solid fa-unlock"></i> Decryption</h2>
                    <div class="card-body">
                        {{-- @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif --}}

                        <form action="{{ route('file.decrypt') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3 mx-3 mt-3">
                                <label for="decrypt_data"><b>Select Encrypted File</b></label>
                                <br><br>
                                <select name="decrypt_data" id="decrypt_data" class="form-control">
                                    <option value="">Select a file</option>
                                    @foreach ($files as $file)
                                        <option value="{{ $file->id }}">{{ $file->filename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-auto mb-3">
                                <button type="submit" class="btn btn-primary">Decrypt and Download</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <br><br>

        <div class="card shadow-lg">
            <h2 class="card-header">List of Encrypted home</h2>
            <div class="card-body">
                <table class="table mt-3 table-bordered text-center">
                    <thead>
                        <tr>
                            <th>File ID</th>
                            <th>Filename</th>
                            <th>Encryption Date & Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>{{ $file->id }}</td>
                                <td>{{ $file->filename }}</td>
                                <td>{{ $file->created_at }}</td>
                                <td>
                                    <a href="{{ route('file.download', $file->id) }}" class="btn btn-sm btn-primary"><i
                                            class="fa-solid fa-download"></i></a>
                                    <form action="{{ route('file.delete', $file->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-button">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Add an event listener for the click event on the delete button
        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this file!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user confirms, submit the form
                        button.closest('form').submit();
                    }
                });
            });
        });

        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000); // 5000 milliseconds = 5 seconds
        }

        const errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.style.display = 'none';
            }, 3000); // 5000 milliseconds = 5 seconds
        }
    </script>
@endsection



<!-- @section('navbar')
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-shield-halved fa-beat"></i> <b>EncryptoDoc</b>
            </a>
            @auth
            {{auth()->user()->name}}
                <div class="text-end">
                <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
                </div>
            @endauth
        </div>
    </nav>
@endsection -->
