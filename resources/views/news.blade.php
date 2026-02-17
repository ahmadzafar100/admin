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
                        @if (isset($editdata))
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Edit News</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/admin/news/' . $editdata->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    @if (session()->has('err_msg'))
                                    <div class="alert alert-danger">
                                        {{ session('err_msg') }}
                                    </div>
                                    @endif
                                    @if (session()->has('success_msg'))
                                    <div class="alert alert-success">
                                        {{ session('success_msg') }}
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Category</label>
                                            <select name="category" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach ($cat as $cats)
                                                <option value="{{ $cats->id }}"
                                                    {{ old('category', $editdata->category_id) == $cats->id ? 'selected' : '' }}>
                                                    {{ $cats->display_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $editdata->name }}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Display Name</label>
                                            <input type="text" class="form-control" name="display_name"
                                                value="{{ $editdata->display_name }}">
                                            @error('display_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Update
                                                News</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                        @if (!isset($editdata))
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add News Manually</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/admin/news') }}" method="post">
                                    @csrf
                                    @if (session()->has('err_msg'))
                                    <div class="alert alert-danger">
                                        {{ session('err_msg') }}
                                    </div>
                                    @endif
                                    @if (session()->has('success_msg'))
                                    <div class="alert alert-success">
                                        {{ session('success_msg') }}
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Category</label>
                                            <select name="category" id="category" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach ($cat as $cats)
                                                <option value="{{ $cats->id }}"
                                                    {{ old('category') == $cats->id ? 'selected' : '' }}>
                                                    {{ $cats->display_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Subcategory</label>
                                            <select name="subcategory" id="subcategory" class="form-control">
                                                <option value="">Select Subcategory</option>
                                                @foreach ($subcat as $subcats)
                                                <option value="{{ $cats->id }}"
                                                    {{ old('subcategory') == $subcats->id ? 'selected' : '' }}>
                                                    {{ $subcats->display_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('subcategory')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ old('title') }}">
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>Summary</label>
                                            <textarea class="form-control" name="summary">{{ old('summary') }}</textarea>
                                            @error('summary')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>Content</label>
                                            <textarea class="form-control" name="content" id="content">{{ old('content') }}</textarea>
                                            @error('content')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="">
                                                <label>Featured Image</label>
                                                <input type="file" id="imageInput" accept="image/*" class="form-control" name="file">
                                            </div>

                                            <div>
                                                <img id="preview" style="max-width:100%;">
                                            </div>

                                            <button type="button" id="cropBtn" class="btn btn-success">
                                                Crop & Save
                                            </button>

                                            <!-- Hidden input to send cropped image -->
                                            <input type="hidden" name="featured_image" id="croppedImage">
                                            @error('file')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Cropped Image Preview:</label>
                                            <img id="croppedPreview" style="max-width:100%; display:none;">
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="archived" {{ old('status', $post->status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                            @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Publish Date</label>
                                            <input type="text" class="form-control" name="publish_date" id="publish_date" readonly>
                                            @error('publish_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Is Featured News</label>
                                            <div class="switch-wrapper">
                                                <label class="rocker rocker-small" for="switch-yes-no">
                                                    <input type="checkbox" id="switch-yes-no" name="is_featured" value="1">
                                                    <span class="switch-left">Yes</span>
                                                    <span class="switch-right">No</span>
                                                </label>
                                            </div>
                                            @error('publish_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <label>Is Breaking News</label>
                                            <div class="switch-wrapper">
                                                <label class="rocker rocker-small" for="switch-yes-no2">
                                                    <input type="checkbox" id="switch-yes-no2" name="is_breaking" value="1">
                                                    <span class="switch-left">Yes</span>
                                                    <span class="switch-right">No</span>
                                                </label>
                                            </div>
                                            @error('is_breaking')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Save as Draft</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Or Import Excel to Add News</h5>
                            </div>
                            <div class="card-body">
                                <form action="/admin/news-import" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <input type="file" class="form-control" name="file">
                                            @error('file')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                            @if ($row->status === 1)
                                            <span class="badge bg-success">Active</span>
                                            @else
                                            <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d/m/Y h:i A', strtotime($row->created_at)) }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group"
                                                aria-label="Small button group">
                                                <a href="{{ url('/admin/news/' . $row->id) }}"
                                                    class="btn btn-dark btn-sm">Edit</a>
                                                <a href="{{ route('news.destroy', $row->id) }}" class="btn btn-danger" data-confirm-delete="true">Delete</a>
                                                {{-- <form action="{{url('/admin/news/'.$row->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-confirm-delete="true">Delete</button>
                                                </form> --}}
                                                @if ($row->status === 1)
                                                <a href="{{ url('/admin/deactivate-news/' . $row->id) }}"
                                                    class="btn btn-primary btn-sm">Deactivate</a>
                                                @else
                                                <a href="{{ url('/admin/activate-news/' . $row->id) }}"
                                                    class="btn btn-warning btn-sm">Activate</a>
                                                @endif
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
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>

<script>
    $(document).ready(function() {
        $('#category').change(function() {
            let categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId,
                    type: 'GET',
                    success: function(data) {

                        $('#subcategory').empty();
                        $('#subcategory').append('<option value="">Select Subcategory</option>');

                        $.each(data, function(key, value) {
                            $('#subcategory').append(
                                '<option value="' + value.id + '">' + value.name + '</option>'
                            );
                        });
                    }
                });
            } else {
                $('#subcategory').empty();
                $('#subcategory').append('<option value="">Select Subcategory</option>');
            }
        });

        $("#publish_date").datepicker({

            dateFormat: "dd-mm-yy", // Display format
            altFormat: "yy-mm-dd", // Database format
            changeMonth: true, // Dropdown for month
            changeYear: true, // Dropdown for year
            yearRange: "1900:2050", // Year range
            minDate: null, // No minimum date
            maxDate: null, // No maximum date
            showButtonPanel: true, // Today & Done button
            showAnim: "slideDown", // Animation
            duration: "fast",
            firstDay: 1, // Week starts Monday
            showOtherMonths: true,
            selectOtherMonths: true,

            beforeShow: function(input, inst) {
                setTimeout(function() {
                    inst.dpDiv.css({
                        zIndex: 9999
                    });
                }, 0);
            },

            onSelect: function(dateText) {
                console.log("Selected Date: " + dateText);
            }

        });

        tinymce.init({
            selector: '#content',
            height: 400,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image',
                'charmap', 'preview', 'anchor', 'searchreplace',
                'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic underline | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image media | code fullscreen',
            branding: false,
            image_caption: true,
            automatic_uploads: true,
            file_picker_types: 'image',
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        let cropper = null;

        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        const cropBtn = document.getElementById('cropBtn');
        const croppedPreview = document.getElementById('croppedPreview');

        imageInput.addEventListener('change', function(e) {

            const file = e.target.files[0];

            if (!file) {
                alert("Please select an image first.");
                return;
            }

            const reader = new FileReader();

            reader.onload = function(event) {

                preview.src = event.target.result;
                croppedPreview.src = event.target.result;
                preview.style.display = "block";
                croppedPreview.style.display = "block";

                // Destroy previous cropper if exists
                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(preview, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                    autoCropArea: 1,
                });

                cropBtn.disabled = false; // Enable crop button
            };

            reader.readAsDataURL(file);
        });

        cropBtn.addEventListener('click', function() {

            if (!cropper) {
                alert("Select image first");
                return;
            }

            const canvas = cropper.getCroppedCanvas({
                width: 800,
                height: 450
            });

            const croppedImage = canvas.toDataURL('image/jpeg');

            // Store in hidden input
            document.getElementById('croppedImage').value = croppedImage;

            // Show preview
            croppedPreview.src = croppedImage;
            croppedPreview.style.display = "block";

            // Optional success message
            // alert("Image cropped successfully!");
        });


    });
</script>