<x-layout>
    <x-slot name="title">News Detail</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">
                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">News Detail</h1>
                    <span class="badge bg-primary text-white ms-2" title="Total Likes">
                        <i class="align-middle" data-feather="thumbs-up"></i> {{ $data->likes }}
                    </span>
                    <span class="badge bg-success text-white ms-0" title="Total Views">
                        <i class="align-middle" data-feather="eye"></i> {{ $data->views }}
                    </span>
                    @can('edit news')
                        <a href="{{ url('/admin/news/' . $data->id . '/edit') }}" class="btn btn-dark btn-sm"
                            title="Edit"><i class="align-middle" data-feather="edit"></i></a>
                    @endcan
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card flex-fill">
                            @if (session()->has('action_msg'))
                                <div class="alert alert-info">
                                    {{ session('action_msg') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table my-0">
                                    <tr>
                                        <th style="width: 20%;">Country</th>
                                        <td>:</td>
                                        <td>{!! $data->country->name ?? '<span class="badge bg-danger">Not Mentioned</span>' !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 20%;">State</th>
                                        <td>:</td>
                                        <td>{!! $data->state->name ?? '<span class="badge bg-danger">Not Mentioned</span>' !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 20%;">City</th>
                                        <td>:</td>
                                        <td>{!! $data->city->name ?? '<span class="badge bg-danger">Not Mentioned</span>' !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 20%;">Category</th>
                                        <td>:</td>
                                        <td>{{ $data->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Subcategory</th>
                                        <td>:</td>
                                        <td>{{ $data->subcategory->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td>:</td>
                                        <td>{{ $data->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td>:</td>
                                        <td>{{ $data->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th>Summary</th>
                                        <td>:</td>
                                        <td>{{ $data->summary }}</td>
                                    </tr>
                                    <tr>
                                        <th>Content</th>
                                        <td>:</td>
                                        <td>{!! $data->content !!}</td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: middle;">Featured Image</th>
                                        <td>:</td>
                                        <td>
                                            @if (!empty($data->featured_image))
                                                <a href="{{ asset('uploads/' . $data->featured_image) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('uploads/' . $data->featured_image) }}"
                                                        width="300">
                                                </a>
                                            @else
                                                <span class="badge bg-danger">Not Uploaded</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:</td>
                                        <td>
                                            @if ($data->status === 'draft')
                                                <span class="badge bg-primary">{{ strtoupper($data->status) }}</span>
                                            @elseif ($data->status === 'published')
                                                <span class="badge bg-success">{{ strtoupper($data->status) }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ strtoupper($data->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Publish At</th>
                                        <td>:</td>
                                        <td>{{ date('d/m/Y', strtotime($data->published_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Is Featured News</th>
                                        <td>:</td>
                                        <td>{{ $data->is_featured === 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Is Breaking News</th>
                                        <td>:</td>
                                        <td>{{ $data->is_breaking_news === 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>:</td>
                                        <td>{{ date('d/m/Y h:i A', strtotime($data->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>:</td>
                                        <td>{{ date('d/m/Y h:i A', strtotime($data->updated_at)) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>
