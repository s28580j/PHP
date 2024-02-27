<?php
    require_once("classes/DatabaseOperations.php");
    $database = new DatabaseOperations();
    session_start();
// Sprawdzenie, czy istnieją potrzebne zmienne sesyjne
    if(!isset($_SESSION["userId"]) || !isset($_SESSION["deleteFlag"])){ header("location: index.php");}
    //zapytanie do bazy danych
    $sql = "delete from user where id = ?;";
    $sqlVarArray = array($_SESSION["userId"]);
    $database->protectedQuery($sql, $sqlVarArray);
    session_destroy();
    header("location: index.php");
?>