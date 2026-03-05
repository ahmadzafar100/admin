<x-front>
    <x-slot name="title">News</x-slot>
    <x-slot name="main">
        <!-- News With Sidebar Start -->
        <div class="container-fluid mt-5 pt-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-title">
                                    @if(isset($categoryName))
                                    <h4 class="m-0 text-uppercase font-weight-bold">{{$categoryName}} {!! (isset($subcategoryName)) ? '<i class="fas fa-arrow-right"></i> '.$subcategoryName : '' !!}</h4>
                                    @elseif(isset($keyword))
                                    <h4 class="m-0 text-uppercase font-weight-bold">Result for: "<strong>{{$keyword}}</strong>" ({{ $news->count() }} results)</h4>
                                    @endif
                                    <!-- <a class="text-secondary font-weight-medium text-decoration-none" href="">View All</a> -->
                                </div>
                            </div>
                            @if ($news->count())
                            @foreach ($news as $row)
                            <div class="col-lg-4">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="{{ asset('uploads/' . $row->featured_image) }}" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                                href="">{{$row->category->name}}</a>
                                            <a class="text-body" href=""><small>{{ date('M d, Y', strtotime($row->published_at)) }}</small></a>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="{{ url('/news/'.$row->category->slug.'/'.$row->subcategory->slug.'/'.$row->slug) }}">{{ $row->title }}</a>
                                        <p class="m-0">{{ $row->summary }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle mr-2" src="img/user.jpg" width="25" height="25" alt="">
                                            <small>John Doe</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <small class="ml-3"><i class="far fa-eye mr-2"></i>12345</small>
                                            <small class="ml-3"><i class="far fa-comment mr-2"></i>123</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- <div class="col-lg-4">

                    </div> -->
                </div>
            </div>
        </div>
        <!-- News With Sidebar End -->
    </x-slot>
</x-front>