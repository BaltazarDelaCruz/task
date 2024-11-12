<?php
require_once('DBConnection.php');
session_start();

$action = isset($_GET['a']) ? $_GET['a'] : '';

class Actions extends DBConnection {
    function __construct() {
        parent::__construct();
    }

    function login(){
        extract($_POST);
        $sql = "SELECT * FROM user_list where username = '{$username}' and `password` = '".md5($password)."' ";
        @$qry = $this->query($sql)->fetchArray();
        if(!$qry){
            $resp['status'] = "failed";
            $resp['msg'] = "Invalid username or password.";
        }else{
            $resp['status'] = "success";
            $resp['msg'] = "Login successfully.";
            foreach($qry as $k => $v){
                if(!is_numeric($k))
                $_SESSION[$k] = $v;
            }
        }
        return json_encode($resp);
    }
    function signup() {
        $first_name = $_POST['first_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
    
        // Basic validation
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            return json_encode(['status' => 'error', 'msg' => 'Please fill all required fields.']);
        }
    
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Use SQLite's prepared statement method
        $stmt = $this->prepare("INSERT INTO user (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)");
        
        // Bind the values to the parameters
        $stmt->bindValue(':firstname', $first_name, SQLITE3_TEXT);
        $stmt->bindValue(':lastname', $last_name, SQLITE3_TEXT);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':password', $hashed_password, SQLITE3_TEXT);
    
        // Execute the statement and check if successful
        if ($stmt->execute()) {
            return json_encode(['status' => 'success', 'msg' => 'Signup successful. Redirecting to login...']);
        } else {
            return json_encode(['status' => 'error', 'msg' => 'Signup failed. Please try again later.']);
        }
    }

    // Add a logout function (optional)
    function logout() {
        session_destroy();
        return json_encode(['status' => 'success', 'msg' => 'Logged out successfully.']);
    }

    function __destruct() {
        parent::__destruct();
    }
}

$actions = new Actions();

switch($action) {
    case 'login':
        echo $actions->login();
        break;
    case 'signup':
        echo $actions->signup();
        break;
    default:
        echo json_encode(['status' => 'error', 'msg' => 'Invalid action.']);
        break;
}
?>
