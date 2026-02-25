<x-layout>
    <x-slot name="title">Permissions</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Permissions</h1>
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