<x-layout>
    <x-slot name="title">Category</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Category</h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Category Manually</h5>
                            </div>
                            <div class="card-body">
                                <form action="/admin/category" method="post">
                                    @csrf
                                    @if (session()->has('err_msg'))
                                        <div class="alert alert-danger">
                                            {{ session('err_msg') }}
                                        </div>
                                    @endif
                                    @if (session()->has('success_msg'))
                                        <div class="alert alert-success">
                                            {{ session('success_msg') }}
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Display Name</label>
                                            <input type="text" class="form-control" name="display_name"
                                                value="{{ old('display_name') }}">
                                            @error('display_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Add Category</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Or Import Excel to Add Categories</h5>
                            </div>
                            <div class="card-body">
                                <form action="/admin/category-import" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <input type="file" class="form-control" name="file">
                                            @error('file')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card flex-fill">
                            <table class="table table-hover my-0">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Display Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) > 0)
                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->display_name }}</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>{{ date('d/m/Y h:i A', strtotime($row->created_at)) }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">
                                                <h3 class="mb-0 text-danger text-uppercase text-center"><strong>No Data
                                                        Found...</strong>
                                                </h3>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>
