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
                        <h5 class="card-title mb-0">Add Permission</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/admin/add-permission') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <label>Permission Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permission_name"
                                        value="{{ old('permission_name') }}">
                                    @error('permission_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Add Permisison</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Give Permissions</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/admin/give-permit') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <label>Role<span class="text-danger">*</span></label>
                                    <select name="role" id="role" class="form-select">
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
                                <div class="col-md-12 mb-3">
                                    <!-- <label class="mb-3">Permissions<span class="text-danger">*</span></label><br> -->
                                    <!-- <select name="permission[]" id="permission" class="form-control" style="height: 200px;" multiple>
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}"
                                                {{ old('permission') == $permission->name ? 'selected' : '' }}>
                                                {{ ucwords($permission->name) }}
                                            </option>
                                            @endforeach
                                        </select> -->
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" name="permission[]" id="checkbox-transformation-{{$permission->id}}" value="{{$permission->name}}" class="input permission-checkbox">
                                                <label for="checkbox-transformation-{{$permission->id}}" class="checkbox">
                                                    <svg viewBox="0 0 18 18">
                                                        <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                                                        <polyline points="1 9 7 14 15 4"></polyline>
                                                    </svg>
                                                </label>
                                                <label for="checkbox-transformation-{{$permission->id}}" class="label">{{ucwords($permission->name)}}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('permission')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update Permission</button>
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
    /* $('#role').on('change', function() {

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

    }); */

    $('#role').on('change', function() {

        let role = $(this).val();

        if (!role) return;

        $.ajax({
            url: '/get-role-permissions/' + role,
            type: 'GET',
            success: function(permissions) {

                // Uncheck all first
                $('.permission-checkbox').prop('checked', false);

                // Check assigned permissions
                permissions.forEach(function(permission) {
                    $('.permission-checkbox[value="' + permission + '"]')
                        .prop('checked', true);
                });

            }
        });

    });
</script>