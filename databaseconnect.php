<?php
require 'credentials.php';
$conn = mysqli_connect($servername, $username, $password, $database);

//Check connection
if(!$conn){
    die('Connection failed: ' . mysqli_connect_error());
}

$return_array = array();

function echo_json($arr){
    echo json_encode($arr, JSON_FORCE_OBJECT);
}

function set_headers(){
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
}

function add_project($name, $stack, $problem, $solution, $repo_link, $open_source, $demo_vid=""){
    global $return_array;
    $new_project = array(
        "name"=>$name,
        "stack"=>$stack,
        "problem"=>$problem,
        "solution"=>$solution,
        "repoLink"=>$repo_link,
        "openSource"=>$open_source,
        "demoVideo"=>$demo_vid
        );
    array_push($return_array, $new_project);
}

$result = mysqli_query($conn, "SELECT * FROM projects");

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
      add_project($row["name"], 
      $row["stack"],
      $row["problem"],
      $row["solution"],
      $row["repoLink"],
      $row["openSource"],
      $row["demoVideo"]
      );
  }
} else {
  echo "0 results";
}

set_headers();
echo_json($return_array);

mysqli_free_result($result);
mysqli_free_result($set);
mysqli_close($conn);
?>