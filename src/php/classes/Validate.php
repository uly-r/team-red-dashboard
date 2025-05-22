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
    $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com','bmcc.cuny.edu','stu.bmcc.cuny.edu', 'teamred.com'];

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

        public function validateTask($post){
            $this->errors=[];
            $title =        trim($post['task_name']);
            $description =  trim($post['task_description']);
            $due_date =     trim($post['date_due']);
            $is_completed = trim($post['task_status']);
            $task_priority= trim($post['taskPriority']);

            $this->validateTitle($title);
            $this->validateDescription($description);
            $this->validateDate($due_date);
            $this->validateIsCompleted($is_completed);
            $this->validateTaskPriority($task_priority);

            return empty($this->errors); // if there are errors returns false, no true

        }
        

        private function validateTitle($title){
            if (empty($title)|| strlen($title)<4 ||strlen($title)>12) {
            $this->errors['task_name'] = "Title must be 4 to 12 characters";
            return false;
            }
            return true;
        }

        private function validateDescription($description) {
            if (empty($description)|| strlen($description)<4 ||strlen($description)>255) {
            $this->errors['task_description'] = "Description  must be 4 to 255 characters";
            return false;
            }
            return true;
        }

         private function validateDate($date) {
            if (empty($date)) {
            $this->errors['due_date'] = "Date is required";
            return false;
            }
            return true;
        }

        private function validateIsCompleted($is_completed) {
            if (!in_array($is_completed, ["0", "1"])) {
             $this->errors['task_status']= "Invalid task status";
            return false;
                 }
            return true;
            }

        private function validateTaskPriority ($priority) {
            $valid_priorities =['1', '2', '3'];

            if (!in_array($priority, $valid_priorities)) {
                $this->errors['taskPriority']= "Please select a valid priority";
                return false;
            }
            return true;
        }

   }