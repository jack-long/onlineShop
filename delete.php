<?php
include_once("inc/Connstring.php");

session_start(); //Pay attention here

if(!isset($_SESSION["admin"])){
    header("Location: index.php");
    exit();
}

$table = "goods";

$gId = isset($_GET['gId']) ? $_GET['gId'] : '';

if($gId == ''){
    header("Location: index.php");
    exit();
} else {
    $query =<<<END
    DELETE FROM {$table}
    WHERE gId={$gId};
END;

    $mysqli->query($query) or die("Could not query database" . $mysqli->errno . $mysqli->error);
    
    if($mysqli->affected_rows >= 1){
        $feedback = "y";
    }else{
        $feedback = "n";
    }
    $mysqli->close();
    //echo "Delete succeed!";
    header("Location: index.php?del={$feedback}");
    exit();
}

?>