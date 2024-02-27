<?php
require_once("DatabaseOperations.php");
//Walidacja danych
class AccountValidation{

    //sprawdza, czy określona wartość występuje już w bazie danych
    private function existsInDatabase($column, $sqlVar){
        $database = new DatabaseOperations();

//zapytanie do bazy danych
        $sql = "select id from user where ".$column." = ? ;";
        return $database->protectedQuery($sql, array($sqlVar))->rowCount() > 0;
    }

    public function usernameExist($username){
        if($this->existsInDatabase("name", $username)) throw new Exception('Username is already taken');
        return false;
    }
    //sprawdza poprawnosc i czy istnieje
    public function validateEmail($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception('Email is not correct');
        if($this->emailExist($email)) throw new Exception('Email already in use');
        return true;
    }
    public function emailExist($email){ return $this->existsInDatabase("email", $email); }

    //sprawdza poprawnosc hasla
    public function validatePassword($password, $passwordConfirm){
        return $this->correctPassword($password) && $this->passwordsMatch($password, $passwordConfirm);
    }
    //czy haslo spelnia wymagania
    //operacje na ciagach znakowych
    public function correctPassword($password){
        if(!preg_match("#[0-9]+#",$password)) throw new Exception('Password must contain at least 1 number');
        if(!preg_match("#[A-Z]+#",$password)) throw new Exception('Password must contain at least 1 capital letter');
        return true;
    }
    //czy podane hasla to te same
    //korzystanie z metod na ciagach znakow
    public function passwordsMatch($password1, $password2){
        if($password1 != $password2) throw new Exception('Passwords does not match');
        return true;
    }
}
?>