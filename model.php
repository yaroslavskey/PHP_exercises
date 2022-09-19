<?php

class Model {

    protected $db;

    public function __construct($conf){

        $this->db = new mysqli("localhost", "root", "1qaz@WSX3edc", "auth");

    }

    public function checkUserLogin($conf, $login, $password){
                
        $result = new stdClass();
        $result->login_status = null;
        $result->password_status = null;
        $result->user_id = -1;
        
        $stmt = $this->db->prepare("
                SELECT * FROM {$conf['usertable']} WHERE login=?
                ");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_array(MYSQLI_ASSOC);

        if ($user) {                        
            
            $result->login_status = true;

            if (password_verify($password, $user['pswd'])) {                
                $result->password_status = true;
                $result->user_id = $user['id'];
            } else {                
                $result->password_status = false;
            }

        }else{            
            $result->login_status = false;
        }       

        return $result;

    }

    public function createToken($conf, $userid, $login, $length=32){    
       
        $res = true;
        
        if ($length<4 || $length > 32) {
            $length = 32;
        }        

        $token = bin2hex(random_bytes(16)); 
        $currentTime = time();       

        $stmt = $this->db->prepare("
            INSERT INTO {$conf['tokentable']} (id, student_id, login, token, tokentime) VALUES (NULL, ?,?,\"{$token}\",{$currentTime})
            ON DUPLICATE KEY UPDATE token=\"{$token}\" , tokentime = {$currentTime}
            ");
        $stmt->bind_param("is", $userid, $login);
        $stmt->execute();
        $res = $stmt->get_result();

        $_SESSION['tokentime'] = $currentTime;
        $_SESSION['login'] = $login;
        $_SESSION['token'] = $token;        
        
        return $token;

    }

    public function updateToken($conf){

        $res = true;

        $stmt = $this->db->prepare("
              SELECT * FROM {$conf['tokentable']} WHERE login=?
              ");
        $stmt->bind_param("s", $_SESSION['login']);
        $stmt->execute();
        $result = $stmt->get_result();
        $tokensDB = $result->fetch_array(MYSQLI_ASSOC);  

        if ($tokensDB['token']==$_SESSION['token']) {                        

            if ($_SESSION['tokentime'] == $tokensDB['tokentime']) {                                  

                $currentTime = time();                

                $stmt = $this->db->prepare("
                    UPDATE `{$conf['tokentable']}` SET `tokentime`={$currentTime} WHERE `login`=?;
                    "); 
                $stmt->bind_param("s", $_SESSION['login']);               
                $stmt->execute();
                $result = $stmt->get_result();
                $_SESSION['tokentime'] = $currentTime;                
                
            } else {
                $res = false;
            }

        }else{            
            $res = false;
        }

        return $res;

    }

    public function addUser($conf, $login, $password, $name, $surname, $middlename){

        $stmt = $this->db->prepare("
                SELECT * FROM {$conf['usertable']} WHERE login=?
                ");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_array(MYSQLI_ASSOC);

        if ($user) { 
            return false;                       
        }else{
            $pswd = password_hash($password,PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("
                    INSERT INTO {$conf['usertable']}(id, name, surname, middlename, login, pswd) VALUES (NULL, ?, ?, ?, ?, ?)
                    ");
            $stmt->bind_param("sssss", $name, $surname, $middlename, $login, $pswd);
            $stmt->execute();
            $res = $stmt->get_result();
            //$user = $res->fetch_array(MYSQLI_ASSOC);

            $data = $this->checkUserLogin($conf, $login, $password); 

            if ($data->login_status && $data->password_status) {                
                $token = $this->createToken($conf, $data->user_id, $login); 
            } 
           
            return true; 

        }
        
    }
  
}