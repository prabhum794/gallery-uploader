<html>
    <head>
        <title>Gallery</title>
        <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>

<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>

<script>
        $(document).ready(function() {
        //elements
        var progressbox     = $('#progressbox');
        var progressbar     = $('#progressbar');
        var statustxt       = $('#statustxt');
        var submitbutton    = $("#SubmitButton");
        var myform          = $("#UploadForm");
        var output          = $("#output");
        var completed       = '0%';
                $(myform).ajaxForm({
                    beforeSend: function() { //brfore sending form
                        submitbutton.attr('disabled', ''); // disable upload button
                        statustxt.empty();
                        progressbox.slideDown(); //show progressbar
                        progressbar.width(completed); //initial value 0% of progressbar
                        statustxt.html(completed); //set status text
                        statustxt.css('color','#000'); //initial color of status text
                    },
                    uploadProgress: function(event, position, total, percentComplete) { //on progress
                        progressbar.width(percentComplete + '%') //update progressbar percent complete
                        statustxt.html(percentComplete + '%'); //update status text
                        if(percentComplete>50)
                            {
                                statustxt.css('color','#fff'); //change status text to white after 50%
                            }
                        },
                    complete: function(response) { // on complete
                        output.html(response.responseText); //update element with received data
                        myform.resetForm();  // reset form
                        submitbutton.removeAttr('disabled'); //enable submit button
                        progressbox.slideUp(); // hide progressbar
                    }
            });
        });

    </script>
<style>
#progressbox {
border: 1px solid #0099CC;
padding: 1px; 
position:relative;
width:400px;
border-radius: 3px;
margin: 10px;
display:none;
text-align:left;
}
#progressbar {
height:20px;
border-radius: 3px;
background-color: #003333;
width:1%;
}
#statustxt {
top:3px;
left:50%;
position:absolute;
display:inline-block;
color: #000000;
}
</style>

    </head>
    <body>
        <form enctype="multipart/form-data" method="post" action="upload.php" id="UploadForm">
            <table>
                <tr>
                    <td>Album Title</td>
                    <td><input type="text" name="atitle" value="<?php if(isset($_POST['atitle'])){echo $_POST['atitle'];} ?>"></td>
                </tr>
                <tr>
                    <td>Choose Images</td>
                    <td><input type="file" name="images[]" multiple=""></td>
                </tr>
                <tr>
                    <td>Choose Cover Image</td>
                    <td><input type="file" name="cover"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Upload"></td>
                </tr>
            </table>
        </form>
        <div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
    </body>
</html>