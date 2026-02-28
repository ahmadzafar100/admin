<x-layout>
    <x-slot name="title">Create Subcategory</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Subcategory</h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        @if (isset($editdata))
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Edit Subcategory</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/admin/subcategory/' . $editdata->id) }}" method="post">
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
                                            <label>Category<span class="text-danger">*</span></label>
                                            <select name="category" class="form-select">
                                                <option value="">Select Category</option>
                                                @foreach ($cat as $cats)
                                                <option value="{{ $cats->id }}"
                                                    {{ old('category', $editdata->category_id) == $cats->id ? 'selected' : '' }}>
                                                    {{ $cats->display_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $editdata->name }}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Display Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="display_name"
                                                value="{{ $editdata->display_name }}">
                                            @error('display_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Update
                                                Subcategory</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                        @if (!isset($editdata))
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Subcategory Manually</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/admin/subcategory') }}" method="post">
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
                                            <label>Category<span class="text-danger">*</span></label>
                                            <select name="category" class="form-select">
                                                <option value="">Select Category</option>
                                                @foreach ($cat as $cats)
                                                <option value="{{ $cats->id }}"
                                                    {{ old('category') == $cats->id ? 'selected' : '' }}>
                                                    {{ $cats->display_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Display Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="display_name"
                                                value="{{ old('display_name') }}">
                                            @error('display_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Add Subcategory</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Or Import Excel to Add Subcategories</h5>
                            </div>
                            <div class="card-body">
                                <form action="/admin/subcategory-import" method="post"
                                    enctype="multipart/form-data">
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
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout><div>
    <!-- An unexamined life is not worth living. - Socrates -->
</div>
