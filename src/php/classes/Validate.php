<?php

class Validate {

    
private array $errors=[];

 public function getErrors() {
        return $this->errors;
    }

    private function validateUserName($username){
        if ( empty($username) || strlen($username)<3 ||strlen($username)>12) {
            $this->errors['username'] = "Username must 3 to 12 characters";
            return false;
        }
        return true;
    }

    private function validateEmail($email) {
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->errors['email'] = "Invalid email format.";
        return false;
    }

    // allowed domains
    $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com','bmcc.cuny.edu','stu.bmcc.cuny.edu'];

    // xtract domain part
    $domain = substr(strrchr($email, "@"), 1); // e.g. 'gmail.com'
    if (!in_array(strtolower($domain), $allowedDomains)) {
        $this->errors['email'] = "Invalid domain.";
        return false;
    }
    return true;
    }

    public function validateSignUp($post) {
        /*
        Currently this only validates the username and email this can be expanded later to verify passsword lengths
        */
            $this->errors= [];
            $username = trim($post['username']);
            $email = trim($post['email']);

            $this->validateUserName($username);
            $this->validateEmail($email);

            return empty($this->errors); // if there are errors returns false, no true
        }



   }