@extends('products.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="product-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail">{{ $product->detail }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Images:</strong>
                    <input type="file" name="images[]" multiple class="form-control">
                    <div class="mt-2" id="image-container">
                        @if($product->images)
                            @foreach(json_decode($product->images) as $image)
                                <div class="image-wrapper d-inline-block position-relative" data-image="{{ $image }}" style="margin-right: 10px;">
                                    <img src="/storage/{{ $image }}" class="img-thumbnail" width="100px">
                                    <button type="button" class="btn btn-danger btn-sm remove-image" style="position: absolute; top: -5px; right: -5px; border-radius: 50%; padding: 0; width: 20px; height: 20px; font-size: 12px; line-height: 20px; color: white; background-color: red; border: none; cursor: pointer;">&times;</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageContainer = document.getElementById('image-container');

            imageContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-image')) {
                    const imageWrapper = e.target.closest('.image-wrapper');
                    const image = imageWrapper.getAttribute('data-image');

                    // Remove the image from the DOM
                    imageWrapper.remove();

                    // Optionally, keep track of removed images
                    const removedImagesInput = document.createElement('input');
                    removedImagesInput.setAttribute('type', 'hidden');
                    removedImagesInput.setAttribute('name', 'removed_images[]');
                    removedImagesInput.setAttribute('value', image);
                    document.getElementById('product-form').appendChild(removedImagesInput);
                }
            });
        });
    </script>
@endsection
