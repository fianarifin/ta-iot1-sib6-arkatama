@extends('layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class= "card-title">Data Pengguna</h4>

            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addModal">
                <i class="las la-user-plus"></i>Tambah
            </button>
        </div>

        <div class="card-body">
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        {{-- <th scope="col">#</th> --}}
                        <th scope="col">UserName</th>
                        <th scope="col">Email</th>
                        <th scope="col">Datetime</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y, H:i') }}</td>

                            <td>
                                <div class="flex align-items-center list-user-action">
                                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"
                                        href="#"><i class="ri-pencil-line"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Delete" href="#"><i class="ri-delete-bin-line"></i></a>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="addName">UserName</label>
                            <input required type="text" class="form-control is-invalid" id="addName" name="name">

                        </div>

                        <div class="form-group">
                            <label for="addEmail">Email</label>
                            <input required type="email" class="form-control" id="addEmail" name="email">
                        </div>

                        <div class="form-group">
                            <label for="addPassword">Password</label>
                            <input required type="password" class="form-control" id="addPassword" name="password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="createUser()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // toastr.success('Have fun storming the castle!', 'Miracle Max Says')
        function createUser() {
            const url = "{{ route('api.users.store') }}";
            // ambil form data
            let data = {
                name: $('#addName').val(),
                email: $('#addEmail').val(),
                password: $('#addPassword').val(),
            }
            // kirim data ke server POST /users
            $.post(url, data)
                .done((response) => {
                    // tampilkan pesan sukses
                    toastr.success(response.message, 'Sukses')
                    // reload halaman setelah 3 detik
                    setTimeout(() => {
                        location.reload()
                    }, 3000);
                })
                .fail((error) => {
                    // ambil response error
                    let response = error.responseJSON
                    // tampilkan pesan error
                    toastr.error(response.message, 'Error')
                })
        }

        function editUser() {

        }

        function deleteUser() {

        }
    </script>
@endpush
