<x-layout>
    <x-slot name="title">Subcategory</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">Subcategory
                        @if (!isset($editdata))
                        {{ '(' . count($data) . ')' }}
                        @endif
                    </h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        @can('create subcategories')
                        <a href="{{url('/admin/subcategory/create')}}" class="btn btn-secondary mb-3">Create Subcategory</a>
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
                                        <th>Category</th>
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
                                        <td>{{ $row->category->name }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->display_name }}</td>
                                        <td>
                                            @can('subcategory status')
                                            <div class="switch-wrapper">
                                                <input type="checkbox" id="switch-material-{{ $row->id }}" class="input status-toggle" data-id="{{ $row->id }}" {{($row->status === 1) ? 'checked' : ''}} />
                                                <label for="switch-material-{{ $row->id }}" class="toggle"><span></span></label>
                                            </div>
                                            @else
                                            <span class="badge bg-{{($row->status === 1) ? 'success' : 'danger'}}">{{$row->status}}</span>
                                            @endcan
                                        </td>
                                        <td>{{ date('d/m/Y h:i A', strtotime($row->created_at)) }}</td>
                                        <td>
                                            @can('edit subcategories')
                                            <a href="{{ url('/admin/subcategory/' . $row->id.'/edit') }}"
                                                class="btn btn-dark btn-sm" title="Edit"><i class="align-middle" data-feather="edit"></i></a>
                                            @endcan
                                            @can('delete subcategories')
                                            <a href="{{ route('subcategory.destroy', $row->id) }}" class="btn btn-danger btn-sm" title="Delete" data-confirm-delete="true"><i class="align-middle" data-feather="trash-2"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7">
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

<script>
$(document).on('change', '.status-toggle', function() {

    let id = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: '/admin/subcategory/status/' + id,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },
        success: function(response) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 3000
            });
        }
    });

});
</script>