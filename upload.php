<?php

    if($_POST){
        if($_POST['atitle']){
            if($_FILES['images']['name']) {
                if($_FILES['cover']['name']){
                $error=0;
                $serror = 0;
                for($i=0;$i<count($_FILES['images']['name']);$i++){
                    $name = $_FILES['images']['name'][$i];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $size = $_FILES['images']['size'][$i]/1024;
                    if(($ext != "jpg") and ($ext != "jpeg") and ($ext != "png") and ($ext != "gif") and ($ext != "JPG") and ($ext != "JPEG") and ($ext != "PNG") and ($ext != "GIF")){
                        $error = $error+1;
                    }
                    if($size>10240){
                        $serror = $serror+1;
                    }
                }
                    $name = $_FILES['cover']['name'];
                    $size = $_FILES['cover']['size']/1024;
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    if(($ext != "jpg") and ($ext != "jpeg") and ($ext != "png") and ($ext != "gif") and ($ext != "JPG") and ($ext != "JPEG") and ($ext != "PNG") and ($ext != "GIF")){
                        $error = $error+1;
                    }
                    if($size>10240){
                        $serror = $serror+1;
                    }
                    if($error==0 and $serror==0){
                        //MAIN
                                $name = $_POST['atitle'];
                                $count = substr_count($name,' ');
                                $new = "";
                                echo $ext;
                                for($i=0;$i<$count;$i++){
                                    $index = strpos($name,' ');
                                    $new = $new.substr($name,0,$index)."_";
                                    $name = substr($name,$index+1,strlen($name));
                                }
                                $atitle = $new.$name;

                                $location = $_SERVER['DOCUMENT_ROOT'].'/gallery/';

                                //Make SD and Thumbnail Folder
                                if(!is_dir($location.'SD/'.$atitle)){
                                    if(!is_dir($location.'thumbnail/'.$atitle)){
                                        mkdir($location.'SD/'.$atitle);
                                        mkdir($location.'thumbnail/'.$atitle);
                                    }
                                }


                                $hdloc = $location.'SD/'.$atitle.'/';
                                $thumbloc = $location.'thumbnail/'.$atitle.'/';
                                for($i=0;$i<count($_FILES['images']['name']);$i++){
                                    $name = $_FILES['images']['name'][$i];
                                    $type = $_FILES['images']['type'][$i];
                                    $tmp_name = $_FILES['images']['tmp_name'][$i];

                                    //Copy to SD Folder
                                    copy($tmp_name,$hdloc.$name);



                                }


                                //FOR COVER
                                $name = $_FILES['cover']['name'];
                                $tmp_name = $_FILES['cover']['tmp_name'];
                                $ext = pathinfo($name, PATHINFO_EXTENSION);
                                $name = "0_album_cover.".$ext;
                                move_uploaded_file($tmp_name,$hdloc.$name);


                                //FOR THUMBNAIL
                                for($i=0;$i<count($_FILES['images']['name']);$i++){

                                    $name = $_FILES['images']['name'][$i];
                                    $tmp_name = $_FILES['images']['tmp_name'][$i];
                                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                                    if($ext =="jpg"||$ext=="jpeg"||$ext =="JPG"||$ext=="JPEG" ){
                                        $src = imagecreatefromjpeg($tmp_name);
                                    }
                                    else if($ext =="png"||$ext =="PNG"){
                                        $src = imagecreatefrompng($tmp_name);
                                    }
                                    else{
                                        $src = imagecreatefromgif($tmp_name);
                                    }

                                    list($width,$height)=getimagesize($tmp_name);
                                    $newwidth=240;
                                    $newheight=160;
                                    $tmp=imagecreatetruecolor($newwidth,$newheight);
                                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                                    $filename = $thumbloc.$name;
                                    imagejpeg($tmp,$filename,100);
                                    imagedestroy($src);
                                    imagedestroy($tmp);

                                }

                                header("Location:index.php");


                    }

                    else if($serror>0){
                        echo "<script>alert('Files exceed the 10 Mb limit')</script>";
                    }
                    else if($error>0){
                        echo "<script>alert('Uploaded Files are not Images')</script>";
                    }


                }else{
                    echo "<script>alert('Select The Cover Image')</script>";
                }
            }else{
                echo "<script>alert('Select The Images to be Uploaded')</script>";
            }
        }else{
            echo "<script>alert('Enter The Album Title')</script>";
        }
    }

?>
