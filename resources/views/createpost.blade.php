@extends('layouts.admin')

@section('title', 'Create Post')
@section('page-title', 'Create Post')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')

<div class="form-box">

    @if ($errors->any())
        <div class="alert-error">

            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

        </div>
    @endif

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form
        action="/upload"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        {{-- URL IMPORT --}}
        <div
            class="input-group"
            style="display:flex;gap:8px;align-items:center;"
        >

            <input
                type="url"
                name="source_url"
                id="source_url"

                placeholder="Ưu tiên link bài viết từ VnExpress, Tuổi Trẻ, Thanh Niên, Vietnamnet để được hỗ trợ tốt nhất"

                value="{{ old('source_url') }}"

                style="flex:1;min-width:0;"
            >

            <button
                type="button"
                id="fetchSeoBtn"

                style="white-space:nowrap;position:relative;top:-6px;"
            >
                Lấy bài viết từ URL
            </button>

        </div>

        {{-- hidden image url --}}
        <input
            type="hidden"
            name="image_url"
            id="image_url"

            value="{{ old('image_url') }}"
        >

        {{-- title --}}
        <input
            type="text"
            name="title"
            id="title"

            placeholder="Title"

            value="{{ old('title') }}"
        >

        {{-- location --}}
        <input
            type="text"
            name="location"
            id="location"

            placeholder="Example: Hoa Lu,Ninh Binh,Northern Vietnam"

            value="{{ old('location') }}"
        >

        {{-- author --}}
        <input
            type="text"
            name="author"
            id="author"

            placeholder="Author"

            value="{{ old('author') }}"
        >

        {{-- TinyMCE --}}
        <label>Nội dung bài viết:</label>

        <textarea
            name="content"
            id="editor"
        >{{ old('content') }}</textarea>

        {{-- background --}}
        <label>Background image:</label>

        <div class="file-wrapper">

            <span
                class="file-name"
                id="bgName"
            >
                Chưa chọn file
            </span>

            <label class="file-btn">

                Chọn file

                <input
                    type="file"
                    name="background"
                    id="backgroundInput"

                    onchange="handleBackgroundFileChange(this)"
                >

            </label>

            {{-- preview image --}}
            <div
                id="previewImageContainer"

                style="
                    display:none;
                    margin-top:12px;
                "
            >

                <label>
                    Ảnh bài viết lấy tự động:
                </label>

                <img
                    id="previewImage"
                    src=""
                    alt="Preview image"

                    style="
                        max-width:100%;
                        max-height:220px;
                        display:block;
                        margin-top:8px;
                        border:1px solid #ccc;
                        border-radius:6px;
                    "
                >

            </div>

        </div>

        <button type="submit">
            Đăng bài
        </button>

    </form>

</div>

@endsection

@section('script')

<script src="/build/vendor/node_modules/tinymce/tinymce.min.js"></script>

<script>

tinymce.init({

    selector: '#editor',

    height: 500,

    promotion: false,

    convert_urls: false,

    relative_urls: false,

    plugins:
        'image link lists table code fullscreen preview wordcount',

    toolbar:
        'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | table | code fullscreen',

    images_upload_url: '/editor/image',

    images_upload_credentials: true,

    setup: function(editor) {

        editor.on('change', function() {

            editor.save();
        });
    },

    images_upload_handler: function(blobInfo, progress) {

        return new Promise(function(resolve, reject) {

            const formData = new FormData();

            formData.append(
                'file',
                blobInfo.blob(),
                blobInfo.filename()
            );

            formData.append(
                '_token',
                '{{ csrf_token() }}'
            );

            fetch('/editor/image', {

                method: 'POST',

                body: formData,

            })

            .then(r => r.json())

            .then(data => resolve(data.location))

            .catch(() => reject('Upload ảnh thất bại'));
        });
    }
});

// ======================
// background file
// ======================

function handleBackgroundFileChange(input)
{
    const previewContainer =
        document.getElementById(
            'previewImageContainer'
        );

    const previewImage =
        document.getElementById(
            'previewImage'
        );

    const imageUrlField =
        document.getElementById(
            'image_url'
        );

    const bgNameField =
        document.getElementById(
            'bgName'
        );

    if (input.files && input.files.length > 0)
    {
        if (bgNameField) {

            bgNameField.textContent =
                input.files[0].name;
        }

        if (imageUrlField) {

            imageUrlField.value = '';
        }

        if (previewImage) {

            previewImage.src = '';
        }

        if (previewContainer) {

            previewContainer.style.display =
                'none';
        }

    } else {

        if (bgNameField) {

            bgNameField.textContent =
                'Chưa chọn file';
        }
    }
}

// ======================
// fetch article
// ======================

const fetchSeoBtn =
    document.getElementById(
        'fetchSeoBtn'
    );

if (fetchSeoBtn)
{
    fetchSeoBtn.addEventListener(
        'click',

        async function ()
        {
            const urlField =
                document.getElementById(
                    'source_url'
                );

            const titleField =
                document.getElementById(
                    'title'
                );

            const locationField =
                document.getElementById(
                    'location'
                );

            const authorField =
                document.getElementById(
                    'author'
                );

            const editorField =
                document.getElementById(
                    'editor'
                );

            const bgFileInput =
                document.getElementById(
                    'backgroundInput'
                );

            const bgNameField =
                document.getElementById(
                    'bgName'
                );

            const previewContainer =
                document.getElementById(
                    'previewImageContainer'
                );

            const previewImage =
                document.getElementById(
                    'previewImage'
                );

            const imageUrlField =
                document.getElementById(
                    'image_url'
                );

            const url =
                urlField.value.trim();

            if (!url)
            {
                alert(
                    'Vui lòng nhập URL bài viết.'
                );

                return;
            }

            fetchSeoBtn.disabled = true;

            fetchSeoBtn.textContent =
                'Đang lấy bài viết...';

            try {

                const token =
                    document.querySelector(
                        'input[name="_token"]'
                    ).value;

                const response =
                    await fetch('/fetch-seo', {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                token,
                        },

                        body: JSON.stringify({
                            url
                        }),
                    });

                let data;

                try {

                    data = await response.json();

                } catch (parseError) {

                    const text =
                        await response.text();

                    console.error(
                        'fetch-seo parse error:',
                        parseError,
                        text
                    );

                    alert(
                        'Không thể đọc dữ liệu bài viết.'
                    );

                    return;
                }

                if (!response.ok)
                {
                    const message =

                        data.error

                        || (
                            data.errors
                            ? Object.values(
                                data.errors
                            ).flat()[0]
                            : null
                        )

                        || response.statusText;

                    alert(
                        message
                        || 'Không thể lấy bài viết.'
                    );

                    return;
                }

                // title
                if (data.title) {

                    titleField.value =
                        data.title;
                }

                // location
                if (data.location) {

                    locationField.value =
                        data.location;
                }

                // author
                if (data.author) {

                    authorField.value =
                        data.author;
                }

                // content
                if (data.content)
                {
                    editorField.value =
                        data.content;

                    tinymce
                        .get('editor')
                        ?.setContent(
                            data.content
                        );
                }

                // image
                if (data.image_url)
                {
                    if (imageUrlField) {

                        imageUrlField.value =
                            data.image_url;
                    }

                    if (previewImage) {

                        previewImage.src =
                            data.image_url;
                    }

                    if (previewContainer) {

                        previewContainer
                            .style
                            .display = 'block';
                    }

                    if (
                        bgNameField
                        && bgFileInput
                        && !bgFileInput.files.length
                    ) {

                        bgNameField.textContent =
                            'Ảnh bài viết được chọn tự động';
                    }
                }

            } catch (error) {

                alert(
                    'Lỗi khi lấy bài viết.'
                );

            } finally {

                fetchSeoBtn.disabled = false;

                fetchSeoBtn.textContent =
                    'Lấy bài viết từ URL';
            }
        }
    );
}

</script>

@endsection