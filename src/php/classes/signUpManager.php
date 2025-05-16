<?php 

class signUpManager {

    private $conn;
    private $error;
   
    public function __construct($conn) {
        $this->conn = $conn;
        $this->error = null;
    }

    private function checkIfUserNameExist ($username){
      
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->num_rows>0;
    }

    private function checkIfEmailExist ($email){
      
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows>0;
    }

    public function createAccount($post)
    {
        $username = $post['username'];
        $email = $post['email']; 
        $password = password_hash($post['password'], PASSWORD_BCRYPT);

    if ($this->checkIfUserNameExist($username)) {
        $this->error = "Username already exists";
        return false;
    } else if ($this->checkIfEmailExist($email)) {
        $this->error = "Sign up failed";
        return false;
    } else {
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $this->error = "An error occurred please try again";
            $stmt->close();
            return false;
        }
    }
    }
    public function getError() {
        return $this->error;
    }

}