<!DOCTYPE html>
<html>
<head>
    <title>Laravel Crop Image Before Upload Example</title>
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="image-cropper/image-cropper.css"/>
    <script src="image-cropper/cropper/cropper.js"></script>
</head>
<style type="text/css">
    body{
        background: #f7fbf8;
    }
    h1{
        font-weight: bold;
        font-size:23px;
    }
    .section{
        margin-top:150px;
        background:#fff;
        padding:50px 30px;
    }
</style>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 section">
            <h1>Laravel Crop Image Before Upload Example</h1>
            <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                @csrf
{{--                <div id="avatar-image"></div>--}}
                <div id="drag-image"></div>
                <br/>
                <button class="btn btn-success">Submit</button>
            </form>
            <div class="mt-4">
                <div class="row">
                    @foreach($medias as $item)
                        <div class="col-md-3 mt-3">
                            <img src="{{ asset('storage' . $item->name) }}" alt="{{ $item->original_name }}">
                            <div class="pt-2">
                                <label for="">Thumnail</label>
                                <img src="{{ asset('storage' . $item->thumbnail_img) }}" alt="{{ $item->original_name }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@include('view-crop::include._modal-crop-bs4')

<script type='text/javascript' src="image-cropper/image-cropper.js"></script>
<script>
    // Instantiate the ImageCropper class
    const imageCropper = new ImageCropper({
        'dragTitle': 'Kéo và thả hoặc nhấn để tải lên',
        'isThumbnail': true
    });
</script>
</body>
</html>
