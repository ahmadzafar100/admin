<x-layout>
    <x-slot name="title">Category</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Category
                        @if (!isset($editdata))
                            {{ '(' . count($data) . ')' }}
                        @endif
                    </h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        @if (isset($editdata))
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Edit Category</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/admin/category/' . $editdata->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
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
                                                    value="{{ $editdata->name }}">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-sm-6 mb-3">
                                                <label>Display Name</label>
                                                <input type="text" class="form-control" name="display_name"
                                                    value="{{ $editdata->display_name }}">
                                                @error('display_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Update Category</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if (!isset($editdata))
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Add Category Manually</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('/admin/category') }}" method="post">
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
                                @if (session()->has('action_msg'))
                                    <div class="alert alert-info">
                                        {{ session('action_msg') }}
                                    </div>
                                @endif
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
                                                    <td>
                                                        @if ($row->status === 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d/m/Y h:i A', strtotime($row->created_at)) }}</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group"
                                                            aria-label="Small button group">
                                                            <a href="{{ url('/admin/category/' . $row->id.'/edit') }}"
                                                                class="btn btn-dark btn-sm">Edit</a>
                                                            <a href="{{ route('category.destroy', $row->id) }}" class="btn btn-danger" data-confirm-delete="true">Delete</a>
                                                            {{-- <form action="{{ url('admin/category/' . $row->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    data-confirm-delete="true">Delete</button>
                                                            </form> --}}
                                                            @if ($row->status === 1)
                                                                <a href="{{ url('/admin/deactivate-category/' . $row->id) }}"
                                                                    class="btn btn-primary btn-sm">Deactivate</a>
                                                            @else
                                                                <a href="{{ url('/admin/activate-category/' . $row->id) }}"
                                                                    class="btn btn-warning btn-sm">Activate</a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">
                                                    <h3 class="mb-0 text-danger text-uppercase text-center"><strong>No
                                                            Data
                                                            Found...</strong>
                                                    </h3>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>
