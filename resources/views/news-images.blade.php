<x-layout>
    <x-slot name="title">News Images</x-slot>
    <x-slot name="main">
        <main class="content">
            <div class="container-fluid p-0">

                <div class="mb-3">
                    <h1 class="h3 d-inline align-middle">News Images
                        {{ '(' . count($data) . ')' }}
                    </h1>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Image</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/admin/add-image/'.$id) }}" method="post" enctype="multipart/form-data">
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
                                        <div class="col-md-6 mb-3">
                                            <input type="file" id="imageInput" accept="image/*" class="form-control" name="image">
                                             @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <div class="mt-3">
                                                Width: <span id="cropWidth">0</span> px |
                                                Height: <span id="cropHeight">0</span> px
                                            </div>
                                            <div>
                                                <img id="preview" style="max-width:100%;">
                                            </div>

                                            <button type="button" id="cropBtn" class="btn btn-success">
                                                Crop & Save
                                            </button>

                                            <!-- Hidden input to send cropped image -->
                                            <input type="hidden" name="croppedImage" id="croppedImage">
                                        </div>
                                         <div class="col-md-6 mb-3">
                                            <label>Cropped Image Preview:</label>
                                            <img id="croppedPreview" style="max-width:100%; display:none;">
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Add Image</button>
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
                            <div class="card-body">
                                <div class="row">
                                    @if (count($data) > 0)
                                        @foreach ($data as $row)
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <a href="{{ asset('uploads/'.$row->image) }}" target="_blank">
                                                <img src="{{ asset('uploads/'.$row->image) }}" class="img-thumbnail" width="300">
                                            </a>
                                            <div class="d-grid">
                                            <a href="{{ url('/admin/delete-news-image/' . $row->id) }}" class="btn btn-danger btn-block" data-confirm-delete="true">Delete</a>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-slot>
</x-layout>

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

                /* cropper = new Cropper(preview, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                    autoCropArea: 1,
                }); */

                cropper = new Cropper(preview, {
                    aspectRatio: NaN,
                    viewMode: 1,
                    autoCropArea: 1,
                    crop(event) {
                        document.getElementById('cropWidth').innerText = Math.round(event.detail.width);
                        document.getElementById('cropHeight').innerText = Math.round(event.detail.height);
                    }
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