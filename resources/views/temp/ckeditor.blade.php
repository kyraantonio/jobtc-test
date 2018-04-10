<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CKEditor</title>

        <link rel="stylesheet" type="text/css" href="<?php echo url('assets/ckeditor/contents.css'); ?>">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Make sure the path to CKEditor is correct. -->
        <script type="text/javascript" src="<?php echo url('assets/ckeditor/ckeditor.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo url('assets/ckeditor/config.js'); ?>"></script>

    </head>
    <body>
        <form>
           <div id="text_editor">
                <textarea name="editor1" id="editor1">
               
            </textarea>
           </div>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
        </form>
    </body>
</html>
