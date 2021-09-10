<?php
$searchwords = stripslashes($_POST['data']);






exec("python/envs/hackathon/bin/python python/hackathon/src/word_similarity/dictionary_search.py $searchwords 2>&1", $output);
$json = implode(PHP_EOL, $output);

if($json === "True") {
    print(1);
} else {
    print(0);
}

//include 'mysql.php';









// $keyword = $_GET['keyword'];
// print $keyword;




// exec("python/envs/hackathon/bin/python python/hackathon/src/word_similarity/dictionary_search.py $keyword", $output);
// $json = implode(PHP_EOL, $output);
// print $json;

?>