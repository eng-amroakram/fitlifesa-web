<!DOCTYPE html>
<html>

<head>
    <title> Bootstrap wysiwyg Example </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width= device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />


</head>

<body>
    <input id="x" type="hidden" name="content">
    <trix-editor input="x"></trix-editor>

    <button id="makeReadOnly">Make Read-Only</button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.querySelector('trix-editor[input="x"]');

            const makeReadOnlyButton = document.querySelector('#makeReadOnly');

            // Event listener for the "Make Read-Only" button
            makeReadOnlyButton.addEventListener('click', function() {
                // const trixEditor = editor.editor;
                // trixEditor.setReadOnly(true); // Set to read-only

                // // Disable the button after making it read-only
                // makeReadOnlyButton.disabled = true;
                editor.contentEditable = false

            });
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
</body>

</html>
