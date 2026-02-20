<x-layout>
    <x-slot name="title">News Images</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">News Images
                        {{ '(' . count($data) . ')' }}
                    </h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Image</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/admin/add-image/'.$id) }}" method="post" enctype="multipart/form-data">
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
                                        <div class="col-md-4 mb-3">
                                            <input type="file" id="imageInput" accept="image/*" class="form-control" name="image">
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Add Image</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>