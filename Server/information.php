<?php
include 'mysql.php';
$no = $_GET['no'];

$row = $mysqli -> query("SELECT * FROM student WHERE no = '$no'") -> fetch_array(MYSQLI_ASSOC);
/*
echo "Name: ".$row["name"]."<br>";
echo "Phone: ".$row["phone"]."<br>";
echo "Email: ".$row["email"]."<br>";
echo "Skills: ".str_replace("/", ", ", $row["skills"])."<br>";
echo "Majors: ".str_replace("/", ", ", $row["majors"])."<br>";
echo "Educations: ".str_replace("/", ", ", $row["educations"])."<br>";
echo "Experiences: ".str_replace("/", ", ", $row["experiences"])."<br>";
echo "Resume: <a href='python/hackathon/data/resume/$row[file]' target='_blank'>".$row["file"]."</a><br>";

exec("python/envs/hackathon/bin/python python/hackathon/src/document_similarity/predictor.py $row[file] 2>&1", $output);
$json = implode(PHP_EOL, $output);

$another = json_decode($json, true);
*/
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <script src="jquery-3.5.1.min.js"></script>
    <meta charset="utf-8">
    <title>Random Access Neuron</title>
    <style>
        html,
        body {
        width: 100%;
        }
        

        .container {
        align-items: center;
        display: flex;
        justify-content: center;
        width: 100%;
        }

        body {
            background-image: url("/images/background3.jpg");
            background-size: auto 100%;
        }

        .btn_upl {
            opacity: 1;
            background-color:teal;
            min-width: 1000px;
            color: white;
            padding: 10px;
        }
        .btn_can {
            opacity: 0.8;
            background-color:red;
            cursor: pointer;
            line-height:50%;
        }
        .btn_can:hover {
            opacity: 1;
        }
        .btn_stu {
            opacity: 0.7;
            background-color:#002626;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
        }
        .btn_stu:hover {
            opacity: 1;
        }
        input {
          font-size: 20px;
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



* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
a{
        color:#48b4e0;
      }
        a:visited{
        color:#48b4e0;
      }
    </style>
    <script>
        function loading() {
            document.getElementById("overlay").style.display = "flex";
            document.body.style.cursor = 'wait';
        }
    </script>

    <script>
    
        window.onload=function(){document.body.style.cursor='default';}
        function complete() {
            document.body.style.cursor = 'default';
        }
    </script>
</head>

<body onload="complete();">
    <div class="overlay" id="overlay"><h1 style="color: black; font-size: 3em;">Searching...</h1></div>
    <div class="container">
      <div class="content"><br>
        <div class="row">
            <div class="btn_upl" id="btn_upl">
                
                <h1 style="color: white;">&nbsp;<img src="/images/icon_student.png" style="height: 50px; vertical-align:middle;"> <?php echo $row["name"];?></h1>
                <div class="row">
                    <div class="column" style="background-color:#004444; min-height: 600px;">
                        
                    <ul style="color: white; line-height:150%; font-size: 20px; ">
                    <?php
                    echo "<li><b>Name: </b>".$row['name']."<br></li>";
                    echo "<li><b>Phone: </b> (".substr($row['phone'], 0, 3).") ".substr($row['phone'], 3, 3)."-".substr($row['phone'],6)."<br></li>";
                    echo "<li><b>Email: </b><a href='mailto:$row[email]' target='_blank'>".$row['email']."</a><br></li>";
                    echo "<li><b>Skills: </b>".str_replace("/", ", ", substr($row['skills'], 0, 200))."<br></li>";
                    echo "<li><b>Majors: </b>".str_replace("/", ", ", substr($row['majors'], 0, 200))."<br></li>";
                    echo "<li><b>Educations: </b>".str_replace("/", ", ", substr($row['educations'], 0, 200))."<br></li>";
                    echo "<li><b>Experiences: </b>".str_replace("/", ", ", substr($row['experiences'], 0, 200))."<br></li>";
                    echo "<li><b>Resume: </b><a href='python/hackathon/data/resume/$row[file]' target='_blank'>".$row['file']."</a><br></li>";
                    ?>
                    </ul>
                    </div>
                    <div class="column" style="background-color:#004444; min-height: 500px; height: 600px; ">
                        <embed src="python/hackathon/data/resume/<?php echo $row['file'];?>#toolbar=0&navpanes=0&scrollbar=1" type="application/pdf" style="width: 100%; height: 100%;">
                    </div>
                </div>
                <!--
                <br><br>
                <h1 style="color: white;">&nbsp;<img src="/images/icon_compare.png" style="height: 50px; vertical-align:middle;"> Recommend Another Students</h1><br>
                            <?php
                            for($i = 0; $i < 5; $i++) {
                                $file = $info['priority'][$i]['pdf'];
                                $score = round($info['priority'][$i]['total_score'], 1);
                                $related_vocabs = $info['priority'][$i]['related_vocabs'];
                                $row = $mysqli -> query("SELECT * FROM student WHERE file = '$file'") -> fetch_array(MYSQLI_ASSOC);
                                $rank = $i+1;
                                echo "<div class='btn_stu' onclick='window.location=\"information.php?no=$row[no]\"'>";
                                echo "<span style='font-size: 20px;'>".$rank.". <b>".$row["name"]."</b></span><br>Score: ".$score."<br>Keywords for this student: <span style='color:turquoise;'>";
                                for ($j=0;$j<10;$j++) {
                                    if ($j > 0) {
                                        echo ", ".$related_vocabs[$j];
                                    } else {
                                        echo $related_vocabs[$j];
                                    }
                                    $j++;
                                }
                                echo "</span></div><br>";
                                }
                            ?>
                

                <?php
                        
                        print $another;
                        ?>

                <br>
                            -->
            </div><br>
            <div class="btn_can" onclick="window.history.back();">
                <center><br>
              <h2 style="color: white;">Cancel</h2><br></center>
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