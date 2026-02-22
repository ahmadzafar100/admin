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
                        <a href="{{url('/admin/news/create')}}" class="btn btn-secondary mb-3">Post News</a>
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
                                                @if ($row->status === 'draft')
                                                <span class="badge bg-primary">{{strtoupper($row->status)}}</span>
                                                @elseif ($row->status === 'published')
                                                <span class="badge bg-success">{{strtoupper($row->status)}}</span>
                                                @else
                                                <span class="badge bg-danger">{{strtoupper($row->status)}}</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d/m/Y h:i A', strtotime($row->created_at)) }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group"
                                                    aria-label="Small button group">
                                                    <a href="{{ url('/admin/news/' . $row->id) }}"
                                                        class="btn btn-primary btn-sm" target="_blank">View Detail</a>
                                                    <a href="{{ url('/admin/news-images/' . $row->id) }}"
                                                        class="btn btn-info btn-sm" target="_blank">Add Images</a>
                                                    <a href="{{ url('/admin/news/' . $row->id.'/edit') }}"
                                                        class="btn btn-dark btn-sm">Edit</a>
                                                    <a href="{{ route('news.destroy', $row->id) }}" class="btn btn-danger" data-confirm-delete="true">Delete</a>
                                                    <!-- @if ($row->status === 1)
                                                    <a href="{{ url('/admin/deactivate-news/' . $row->id) }}"
                                                        class="btn btn-primary btn-sm">Deactivate</a>
                                                    @else
                                                    <a href="{{ url('/admin/activate-news/' . $row->id) }}"
                                                        class="btn btn-warning btn-sm">Activate</a>
                                                    @endif -->
                                                </div>
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