<x-layout>
    <x-slot name="title">News Detail</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">
                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">News Detail</h1>
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
                                <table class="table table-hover my-0">
                                    <tr>
                                        <th style="width: 20%;">Category</th>
                                        <td>:</td>
                                        <td>{{$data->category->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Subcategory</th>
                                        <td>:</td>
                                        <td>{{$data->subcategory->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td>:</td>
                                        <td>{{$data->title}}</td>
                                    </tr>
                                    <tr>
                                        <th>Summary</th>
                                        <td>:</td>
                                        <td>{{$data->summary}}</td>
                                    </tr>
                                    <tr>
                                        <th>Content</th>
                                        <td>:</td>
                                        <td>{{$data->content}}</td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: middle;">Featured Image</th>
                                        <td>:</td>
                                        <td>
                                            <img src="{{ asset('uploads/'.$data->featured_image) }}" width="300">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:</td>
                                        <td>
                                            @if ($data->status === 'draft')
                                            <span class="badge bg-primary">{{strtoupper($data->status)}}</span>
                                            @elseif ($data->status === 'published')
                                            <span class="badge bg-success">{{strtoupper($data->status)}}</span>
                                            @else
                                            <span class="badge bg-danger">{{strtoupper($data->status)}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Publish At</th>
                                        <td>:</td>
                                        <td>{{date('d/m/Y', strtotime($data->published_at))}}</td>
                                    </tr>
                                    <tr>
                                        <th>Is Featured News</th>
                                        <td>:</td>
                                        <td>{{($data->is_featured === 1) ? 'Yes' : 'No'}}</td>
                                    </tr>
                                    <tr>
                                        <th>Is Breaking News</th>
                                        <td>:</td>
                                        <td>{{($data->is_breaking_news === 1) ? 'Yes' : 'No'}}</td>
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