<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CKEditor 5 - Quick start CDN</title>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.umd.js"></script>
    <!-- Add if you use premium features. -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/43.0.0/ckeditor5-premium-features.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5-premium-features.umd.js"></script>
    <!--  -->
    <style>
        .main-container {
            width: 795px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div id="editor">
            <p>Hello from CKEditor 5!</p>
        </div>
    </div>
    <script>
        const {
            ClassicEditor,
            Essentials,
            Bold,
            Italic,
            Font,
            Paragraph
        } = CKEDITOR;
        const { FormatPainter } = CKEDITOR_PREMIUM_FEATURES;

        ClassicEditor
            .create( {
                attachTo: document.querySelector( '#editor' ),
                licenseKey: '<YOUR_LICENSE_KEY>',
                plugins: [ Essentials, Bold, Italic, Font, Paragraph, FormatPainter ],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'formatPainter'
                ]
            } )
            .then( /* ... */ )
            .catch( /* ... */ );
    </script>
</body>
</html>
