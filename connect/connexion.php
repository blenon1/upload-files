<?php 
    try {
    $db = new PDO('mysql:host=localhost;dbname=upload', 'root', '');
    }catch(Exception $e) {
        die("ERROR" .$e->getMessage());
    }