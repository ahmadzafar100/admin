<x-layout>
    <x-slot name="title">Change Password</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Change Password</h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="/admin/update-pass" method="post">
                                    @csrf
                                    @if(session()->has('err_msg'))
                                    <div class="alert alert-danger">
                                        {{session('err_msg')}}
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Current Password</label>
                                            <input type="password" class="form-control" name="current_pass" value="{{old('current_pass')}}">
                                            @error('current_pass')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" name="new_pass" value="{{old('new_pass')}}">
                                            @error('new_pass')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_pass" value="{{old('confirm_pass')}}">
                                            @error('confirm_pass')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
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