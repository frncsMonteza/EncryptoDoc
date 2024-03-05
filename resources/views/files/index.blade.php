@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-glass text-center shadow">
                    <h2 class="card-header"><i class="fa-solid fa-lock"></i> Encryption</h2>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success mb-3" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Choose a File to Encrypt</label>
                                <input class="form-control" type="file" id="file" name="file">
                            </div>
                            <button type="submit" class="btn btn-primary">Encrypt</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-glass text-center shadow">
                    <h2 class="card-header"><i class="fa-solid fa-unlock"></i> Decryption</h2>
                    <div class="card-body">
                        <form action="{{ route('file.decrypt') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="decrypt_data" class="form-label">Select Encrypted File</label>
                                <select name="decrypt_data" id="decrypt_data" class="form-select">
                                    <option value="">Select a file</option>
                                    @foreach ($files as $file)
                                        <option value="{{ $file->id }}">{{ $file->filename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Decrypt and Download</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-glass shadow mt-5">
            <h2 class="card-header p-5 text-center"><b>List of Encrypted Files</b></h2>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
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
                                        <a href="{{ route('file.download', $file->id) }}" class="btn btn-primary"><i class="fa-solid fa-download"></i></a>
                                        <form action="{{ route('file.delete', $file->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger delete-button"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                        button.closest('form').submit();
                    }
                });
            });
        });

        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 3000);
        }

        const errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.style.display = 'none';
            }, 3000);
        }
    </script>
@endsection
