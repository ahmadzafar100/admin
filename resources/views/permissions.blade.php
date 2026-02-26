<x-layout>
    <x-slot name="title">Permissions</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Permissions</h1>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Give Permissions</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/admin/give-permit') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="mb-3">
                                        <label>Role<span class="text-danger">*</span></label>
                                        <select name="role" id="role" class="form-control">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ old('role') == $role->name ? 'selected' : '' }}>
                                                {{ ucwords($role->name) }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Permissions<span class="text-danger">*</span></label>
                                        <select name="permission[]" id="permission" class="form-control" style="height: 200px;" multiple>
                                            <option value="">Select Permissions</option>
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}"
                                                {{ old('permission') == $permission->name ? 'selected' : '' }}>
                                                {{ ucwords($permission->name) }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('permission')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Give Permit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card flex-fill">
                            <div class="table-responsive">
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>User</th>
                                            <th>Roles</th>
                                            <th>Permissions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($users) > 0)
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{ucwords($user->getRoleNames()->implode(', '))}}</td>
                                            <td>
                                                @foreach(($user->getAllPermissions()->pluck('name')) as $permits)
                                                <span class="badge bg-primary mb-1">{{ucwords($permits)}}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4">
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
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>

<script>
    $('#role').on('change', function() {

        let roleId = $(this).val();

        if (!roleId) {
            $('#permission').val([]).trigger('change');
            return;
        }

        $.ajax({
            url: '/get-role-permissions/' + roleId,
            type: 'GET',
            success: function(permissions) {

                // Set selected values
                $('#permission')
                    .val(permissions)
                    .trigger('change'); // important if using Select2

            }
        });

    });
</script>