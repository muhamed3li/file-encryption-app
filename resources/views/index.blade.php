<!DOCTYPE html>
<html>

<head>
    <title>File Encryption App</title>
    <link href="{{ asset('assets/bootstrap.min.css') }}" rel="stylesheet">

</head>

<body>
    <div class="container text-center py-5">
        <div class="">
            <div class="card-body">
                <h4 class="card-title">File Encryption App</h4>
                <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file"
                            class="form-control w-50 m-auto {{ $errors->has('file') ? ' is-invalid' : '' }}"
                            name="file" required>
                        @if ($errors->has('file'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button style="width: 10rem;" type="submit" class="mt-3 btn btn-primary form-control">Upload
                        File</button>
                </form>

                @isset($fileName)
                    <br>
                    <hr>
                    <h2>File Details:</h2>
                    <p>File Name: {{ $fileName }}</p>
                    <p>File Size: {{ $fileSize }} bytes</p>
                    <p>File Extension: {{ $fileExtension }}</p>

                    <div class="d-flex justify-content-center">

                        <form action="{{ route('encrypt') }}" method="POST">
                            @csrf
                            <input type="hidden" name="file" value="{{ $fileNameHashed }}">
                            <button type="submit" class="form-control btn btn-success ml-3">Encrypt</button>
                        </form>

                        <form action="{{ route('decrypt') }}" method="POST">
                            @csrf
                            <input type="hidden" name="file" value="{{ $fileNameHashed }}">
                            <button type="submit" class="btn btn-danger">Decrypt</button>
                        </form>
                    </div>
                    @if (session('error'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ session('error') }}</strong>
                        </span>
                    @endif
                @endisset
            </div>
        </div>

    </div>

    <script src="{{ asset('assets/bootstrap.min.js') }}"></script>

</body>

</html>
