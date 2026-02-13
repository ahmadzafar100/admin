<x-layout>
    <x-slot name="title">Profile</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Profile</h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="/admin/profile-update" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="{{$data->name}}">
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email" value="{{$data->email}}">
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Mobile</label>
                                            <input type="text" class="form-control" name="mobile" value="{{$data->mobile}}">
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Username</label>
                                            <input type="text" class="form-control" value="{{$data->username}}" disabled>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Role</label>
                                            <input type="text" class="form-control" value="{{$data->role}}" disabled>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>