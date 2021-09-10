<?php
include 'mysql.php';
$keyword = $_POST['keyword'];


$keyword_array = explode("/", $keyword);


exec("python/envs/hackathon/bin/python python/hackathon/search_resume_with_keywords.py $keyword 2>&1", $output);
$json = implode(PHP_EOL, $output);
$info = json_decode($json, true);
//print $json;


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
        height: 100%;
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
      <div class="content">
        <h1 style="color: black; font-size: 3em;">Find Resume</h1><br><br>
        
        <div class="row">
            <div class="btn_upl" id="btn_upl">
                
                <h1 style="color: white;">&nbsp;<img src="/images/icon_complete.png" style="height: 50px; vertical-align:middle;"> Search Complete!</h1>
                            <span style="font-size: 30px;">Result for <b><span style="color:turquoise;"><?php echo $keyword; ?></b></span></span>
                            <span style="font-size: 17px;">
                            <?php
                            for($i =0; $i < sizeof($keyword_array); $i++){
                                echo "<br>Related keyword about ".$keyword_array[$i].": <span style='color:turquoise;'>";
                                $array = $info['relate'][$keyword_array[$i]];
                                $j = 0;
                                foreach ($array as $item) {
                                    if ($j > 0) {
                                        echo ", ".$item;
                                    } else {
                                        echo $item;
                                    }
                                    $j++;
                                }
                                echo "</span>";
                            }
                            ?>

                        
                            </span>


                            <br><br><br><span style="font-size: 30px;">Recommend Students</span><br>
                            <?php
                            for($i = 0; $i < 30; $i++) {
                                if($info['priority'][$i]['pdf'] == NULL) break;
                                $file = $info['priority'][$i]['pdf'];
                                $score = round($info['priority'][$i]['total_score'], 1);
                                $related_vocabs = $info['priority'][$i]['related_vocabs'];
                                $row = $mysqli -> query("SELECT * FROM student WHERE file = '$file'") -> fetch_array(MYSQLI_ASSOC);
                                $rank = $i+1;
                                echo "<div class='btn_stu' onclick='window.location=\"information.php?no=$row[no]\"'>";
                                echo "<span style='font-size: 20px;'>".$rank.". <b>".$row["name"]."</b></span><br>Score: ".$score."<br>Keywords for this student: <span style='color:turquoise;'>";
                                for ($j=0;$j<sizeof($related_vocabs);$j++) {
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

                <br>
              
            </div><br>
            <div class="btn_can" onclick="location.href='index.html';">
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