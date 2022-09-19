<?php

session_start();

require "./conf.php";
require "./view.php";
require "./model.php";

$View = new View($conf);
$Model = new Model($conf);

$task = "";
if (isset($_POST["task"])) {
    $task = htmlspecialchars($_POST['task']);  
}

if(!($task == "register" || $task == "addUser")){
    if (isset($_SESSION['tokentime']) && (time()-($_SESSION['tokentime']) < 1*60)){    
   
        if($Model->updateToken($conf)){
            $task = "userlist";
        }else{
            $task = "login";
        }
        
    } else {
        $task = "login"; 
    }
}

$page = $View->makeHeader($conf);

switch ($task) {
    
    case 'login': 
                
        if (isset($_POST['login'])) {  
                        
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']); 

            $data = $Model->checkUserLogin($conf, $login, $password); 

            if ($data->login_status && $data->password_status) {                
               
                // generate token + save token to session                
                $token = $Model->createToken($conf, $data->user_id, $login);  

                // redirect to "page"
                $page .= $View->makeHTML($conf); 

            } else {                
                
                $page .= $View->makeErrorMessage($conf,'Не коректно введений логін або пароль');
                $page .= $View->loginForm($conf);
                
            }

        } else {
            
            $page .= $View->makeErrorMessage($conf,'Введіть ваш логін і пароль');
            $page .= $View->loginForm($conf);            
        }

        break;

    case 'register':

        $page .= $View->registerForm($conf);
        break;

    case 'addUser':
        
        if (isset($_POST['login']) && isset($_POST['password'])) {  

            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']); 
            
            $name = "";
            if(isset($_POST['name'])){
                $name = htmlspecialchars($_POST['name']);
            }

            $surname = "";
            if(isset($_POST['surname'])){
                $surname = htmlspecialchars($_POST['surname']);
            }

            $middlename = "";
            if(isset($_POST['middlename'])){
                $middlename = htmlspecialchars($_POST['middlename']);
            }

            if($Model->addUser($conf, $login, $password, $name, $surname, $middlename)){
                $page .= $View->makeHTML($conf);
            }else{
                $page .= $View->makeErrorMessage($conf,'Такий логін вже існує');
                $page .= $View->registerForm($conf);            
            };

        }

        break;

    case 'userlist':

        $page .= $View->makeHTML($conf);
        break;

    default:

        $page .= $View->makeErrorMessage($conf,'Введіть ваш логін і пароль');
        $page .= $View->loginForm($conf);

        break;

}

$page .= $View->makeFooter($conf);

echo $page;
