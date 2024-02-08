<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="container">
    <div class="content-header mb-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Add Comment') }}</h1>
                </div>
            </div>
            <a href="{{ route('comments.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
        @if ($parentComment)
            <div class="container border p-2 rounded mb-3">
                <div class="border-bottom mb-2">
                    {{ $parentComment->user_name }}
                </div>
                <div>
                    @if ($parentComment->getMedia('comment_media')->first())
                        <img src="{{ $parentComment->getMedia('comment_media')->first()->getUrl() }}" alt="Image">
                    @endif
                </div>
                <div>
                    {!! html_entity_decode($parentComment->text->text) !!}
                </div>
            </div>
        @endif
    <div class="content">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data" di="previewForm">
                        @csrf
                        <div class="form-group ">
                            <label for="user_name">Name:</label>
                            <input type="text" name="user_name" value="{{ old('user_name') }}" class="form-control">
                            @error('user_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                            <label for="email">Email:</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <label for="home_page">Home page:</label>
                            <input type="url" name="home_page" value="{{ old('home_page') }}" class="form-control">
                            <label for="text">Text:</label>
                            <div id="tagButtons" class="btn-group">
                                <button class="tagButton" onclick="insertTag('i', 'i')">[i]</button>
                                <button class="tagButton" onclick="insertTag('strong', 'strong')">[strong]</button>
                                <button class="tagButton" onclick="insertTag('code', 'code')">[code]</button>
                                <button class="tagButton" onclick="insertLink()">[a]</button>
                            </div>
                            <textarea name="text" class="form-control" id="text" >{{ old('text') }}</textarea>
                            @error('text')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <input type="hidden" value="{{ $parentComment?->id }}" name="parent_id">

                            <label for="media">Загрузить файл</label>
                            <input type="file" class="form-control" name="media" id="media">
                            @error('media')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror

                            <div class="form-group row m-2">
                                <div class="col-2">
                                    {!! Captcha::img() !!}
                                </div>
                                <div class="col-5">
                                    <input type="text" id="captcha" name="captcha" class="form-control" placeholder="Введите код с картинки" required>
                                </div>
                            </div>

                            @error('captcha')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Create comment</button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="showPreview()" data-bs-target="#exampleModal" >
                            Show preview
                        </button>
                    </form>
                </div>
            </div>
        </div>



        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Preview</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="previewImage" alt="Preview Image">
                        <p id="previewText"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        function previewText() {
            var text = $('#text').val();
            $('#previewText').text(text);
        }

        function previewImage() {
            var input = document.getElementById('media');
            var previewImage = document.getElementById('previewImage');

            var file = input.files[0];

            if (file) {
                $("#previewImage").show()
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                console.log($("#previewImage"))
                $("#previewImage").hide()
            }
            return true;
        }

        function showPreview() {
            previewText();
            previewImage();
            $('#exampleModal').show();
        }

        function closePreview() {
            $('#exampleModal').hide();
        }
    </script>
    <script>
        function insertTag(openTag, closeTag) {
            var textarea = document.getElementById('text');
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;
            var selectedText = textarea.value.substring(start, end);
            var replacement = '<' + openTag + '>' + selectedText + (closeTag ? '</' + closeTag + '>' : '');

            textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);

            previewText();
        }

        function insertLink() {
            var url = prompt("Enter the URL:");
            if (url !== null) {
                var title = prompt("Enter the title (optional):");
                var link = '<a href="' + url + '"';
                if (title) {
                    link += ' title="' + title + '"';
                }
                link += '>Link text</a>';
                insertTag('', '');

                previewText();
            }
        }

        function previewText() {
            var text = $('#text').val();
            $('#previewText').html(text);
        }
    </script>



</body>
</html>
