<?php
include 'mysql.php';
$file = str_replace(' ','_',$_FILES['file']);
$name = $file["name"];
$type = $file["type"];
$size = $file["size"];
$tmp_name = $file["tmp_name"];
$extension = array_pop(explode('.', $name));


if($extension === "pdf" || $extension === "docx") {
  move_uploaded_file($tmp_name, "python/hackathon/data/resume/$name");
  exec("python/envs/hackathon/bin/python python/hackathon/main.py $name", $output);
  $json = implode(PHP_EOL, $output);

  //echo "<br><br><b>Get JSON from Python successfully!</b><br>";
  //print $json;
  $student = json_decode($json);

  $name = preg_replace('/[^A-Za-z0-9\-\s]/', '', $student->name);
  $phone = preg_replace('/[^0-9]*/s', '', $student->phone);
  $email = preg_replace('/[^A-Za-z0-9\-\_\@\.]/', '', $student->email);
  $skills = preg_replace('/[^A-Za-z0-9\/\s]/', '', implode('/', $student->skills));
  $majors = preg_replace('/[^A-Za-z0-9\/]\s/', '', implode('/', $student->majors));
  $educations = preg_replace('/[^A-Za-z0-9\/\s]/', '', implode('/', $student->educations));
  $experiences = preg_replace('/[^A-Za-z0-9\/\s]/', '', implode('/', $student->experiences));
  $file = $file["name"];
  //echo "<br><br><b>Get student data successfully!</b><br>";
  //echo $name."<br>".$phone."<br>".$email."<br>".$skills."<br>".$majors."<br>".$educations."<br>".$experiences."<br>".$file["name"];
} else {
  echo "<script>alert('Incorrect file.');location.href='upload.html';</script>";
}

$sql = "INSERT INTO student (no, name, phone, email, skills, majors, educations, experiences, file) VALUES (NULL, '$name', '$phone', '$email', '$skills', '$majors', '$educations', '$experiences', '$file')";

if ($mysqli->query($sql) === TRUE) {
  //echo "<br><br><b>Insert DB successfully!</b><br>Done.";
} else {
  echo "Error: " . $sql . "<br>" . $mysqli->error;
}



?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Random Access Neuron</title>
    <style>
        html,
        body {
        width: 100%;
        }
        a:visited{
        color:blue;
      }
        

        .container {
        align-items: center;
        display: flex;
        justify-content: center;
        height: 100%;
        width: 100%;
        }

        body {
            background-image: url("/images/background2.jpg");
            background-size: auto 100%;
        }

        .btn_upl {
            opacity: 1;
            background-color:teal;
            padding: 10px;
            max-width: 1000px;
        }
        .btn_can {
            opacity: 0.8;
            background-color:grey;
            cursor: pointer;
            line-height:50%;
        }
        .btn_can:hover {
            opacity: 1;
        }
        input {
          font-size: 15px;
        }

        .overlay{
        display: none;
        opacity:0.9;
        background-color:#ccc;
        position:fixed;
        width:100%;
        height:100%;
        top:0px;
        left:0px;
        z-index:1000;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
        cursor: wait;
        }

      a{
        color:#48b4e0;
      }
        a:visited{
        color:#48b4e0;
      }
    </style>
    <script>
        window.onload=function(){document.body.style.cursor='default';}
        function complete() {
            document.body.style.cursor = 'default';
        }
    </script>
</head>

<body onload="complete();">
    <div class="overlay" id="overlay"><h1 style="color: black; font-size: 3em;">Uploading...</h1></div>
    <div class="container">
      <div class="content">
        <h1 style="color: black; font-size: 3em;">Upload your resume</h1><br><br>
        
        <div class="row">
            <div class="btn_upl" id="btn_upl">
                    <h1 style="color: white;">&nbsp;<img src="/images/icon_complete.png" style="height: 50px; vertical-align:middle;"> Upload Complete!</h1>
                <ul style="color: white; line-height:150%;">
                <?php
                echo "<li><b>Name: </b>".$name."<br></li>";
                echo "<li><b>Phone: </b> (".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6)."<br></li>";
                echo "<li><b>Email: </b><a href='mailto:$email' target='_blank'>".$email."</a><br></li>";
                echo "<li><b>Skills: </b>".str_replace("/", ", ", $skills)."<br></li>";
                echo "<li><b>Majors: </b>".str_replace("/", ", ", $majors)."<br></li>";
                echo "<li><b>Educations: </b>".str_replace("/", ", ", $educations)."<br></li>";
                echo "<li><b>Experiences: </b>".str_replace("/", ", ", $experiences)."<br></li>";
                echo "<li><b>Resume: </b><a href='python/hackathon/data/resume/$file' target='_blank'>".$file."</a><br></li>";
                ?>
                </ul>
            
              
            </div><br>
            <div class="btn_can" onclick="location.href='index.html';">
                <center><br>
              <h2 style="color: black;">Okay</h2><br></center>
            </div>
        </div>
      </div>
    </div>
    <br><br>
  </body>
</html>
<?php
$mysqli->close();
?>