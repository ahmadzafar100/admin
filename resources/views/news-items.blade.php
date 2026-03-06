@foreach ($news as $row)
<div class="col-lg-4">
    <div class="position-relative mb-3">
        <img class="img-fluid w-100"
            src="{{ asset('uploads/' . $row->featured_image) }}"
            style="object-fit: cover;">
        <div class="bg-white border border-top-0 p-4">
            <div class="mb-2">
                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                    href="">{{ $row->category->name }}</a>
                <a class="text-body"
                    href=""><small>{{ date('M d, Y', strtotime($row->published_at)) }}</small></a>
            </div>
            <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold"
                href="{{ url('/news/' . $row->category->slug . '/' . $row->subcategory->slug . '/' . $row->slug) }}">{{ $row->title }}</a>
            <p class="m-0">{{ $row->summary }}</p>
        </div>
        <div
            class="d-flex justify-content-between bg-white border border-top-0 p-4">
            <div class="d-flex align-items-center">
                <img class="rounded-circle mr-2"
                    src="{{ asset('front/img/user.jpg') }}" width="25"
                    height="25" alt="">
                <small>{{ $row->user->name }}</small>
            </div>
            <div class="d-flex align-items-center">
                <small class="ml-3"><i
                        class="far fa-eye mr-2"></i>{{ $row->views }}</small>
                <span class="ml-3"><i
                        class="far fa-thumbs-up mr-2"></i>{{ $row->likes }}</span>
                <small class="ml-3"><i class="far fa-comment mr-2"></i>123</small>
            </div>
        </div>
    </div>
</div>
@endforeach