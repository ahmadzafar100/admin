<x-layout>
    <x-slot name="title">News</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">News
                        @if (!isset($editdata))
                        {{ '(' . count($data) . ')' }}
                        @endif
                    </h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        @can('create news')
                        <a href="{{url('/admin/news/create')}}" class="btn btn-secondary mb-3">Post News</a>
                        @endcan
                        <a href="{{url('/admin/news-export')}}" class="btn btn-dark mb-3">Export Excel</a>
                        <div class="card flex-fill">
                            @if (session()->has('action_msg'))
                            <div class="alert alert-info">
                                {{ session('action_msg') }}
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Cateory-Subcategory</th>
                                            <th>Title</th>
                                            <th>Published At</th>
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
                                            <td>{{ $row->category->name }}-{{ $row->subcategory->name }}</td>
                                            <td>{{ $row->title }}</td>
                                            <td>{{ date('d/m/Y', strtotime($row->published_at)) }}</td>
                                            <td>
                                                @can('news status')
                                                <select data-id="{{$row->id}}" class="form-select form-select-sm status-dropdown">
                                                    <option value="draft" {{$row->status === 'draft' ? 'selected':''}}>Draft</option>
                                                    <option value="published" {{$row->status === 'published' ? 'selected':''}}>Published</option>
                                                    <option value="archived" {{$row->status === 'archived' ? 'selected':''}}>Archived</option>
                                                </select>
                                                @else
                                                <span class="badge bg-{{
                                                match($row->status) {
                                                    'published' => 'success',
                                                    'draft' => 'warning',
                                                    'archived' => 'danger',
                                                    default => 'secondary'
                                                };
                                                }}">{{ucwords($row->status)}}</span>
                                                @endcan
                                            </td>
                                            <td>{{ date('d/m/Y h:i A', strtotime($row->created_at)) }}</td>
                                            <td>
                                                <a href="{{ url('/admin/news/' . $row->id) }}"
                                                    class="btn btn-primary btn-sm" target="_blank" title="View Detail"><i class="align-middle" data-feather="eye"></i></a>
                                                @can('add image')
                                                <a href="{{ url('/admin/news-images/' . $row->id) }}"
                                                    class="btn btn-info btn-sm" target="_blank" title="Add Image"><i class="align-middle" data-feather="image"></i></a>
                                                @endcan
                                                @can('edit news')
                                                <a href="{{ url('/admin/news/' . $row->id.'/edit') }}"
                                                    class="btn btn-dark btn-sm" title="Edit"><i class="align-middle" data-feather="edit"></i></a>
                                                @endcan
                                                @can('delete news')
                                                <a href="{{ route('news.destroy', $row->id) }}" class="btn btn-danger btn-sm" title="Delete" data-confirm-delete="true"><i class="align-middle" data-feather="trash-2"></i></a>
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
            </div>
        </main>
    </x-slot>
</x-layout>

<script>
    $(document).on('change', '.status-dropdown', function() {

        var status = $(this).val();
        var news_id = $(this).data('id');

        $.ajax({
            url: "{{ route('news.updateStatus') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                news_id: news_id,
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

            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                });
            }
        });
    });
</script>