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
                        @can('create categories')
                        <a href="{{url('/admin/category/create')}}" class="btn btn-secondary mb-3">Create Category</a>
                        @endcan
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
                                            @can('edit categories')
                                            <a href="{{ url('/admin/category/' . $row->id.'/edit') }}"
                                                class="btn btn-dark btn-sm" title="Edit"><i class="align-middle" data-feather="edit"></i></a>
                                            @endcan
                                            @can('delete categories')
                                            <a href="{{ route('category.destroy', $row->id) }}" class="btn btn-danger btn-sm" title="Delete" data-confirm-delete="true"><i class="align-middle" data-feather="trash-2"></i></a>
                                            @endcan
                                            @can('category status')
                                            @if ($row->status === 1)
                                            <a href="{{ url('/admin/deactivate-category/' . $row->id) }}"
                                                class="btn btn-primary btn-sm" title="Click to Deactivate"><i class="align-middle" data-feather="x-circle"></i></a>
                                            @else
                                            <a href="{{ url('/admin/activate-category/' . $row->id) }}"
                                                class="btn btn-warning btn-sm" title="Click to Activate"><i class="align-middle" data-feather="check-circle"></i></a>
                                            @endif
                                            @endcan
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
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>