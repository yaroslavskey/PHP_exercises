<?php 

class View {

    public function makeHeader($conf){
        
        $html = "<html>";
        $html .= "<head>";
        $html .= "<link rel=\"stylesheet\" href=\"./styles.css\">";
        $html .= "</head>";
        $html .= "<body><br><br>";

        return $html;

    }

    public function makeFooter($conf){
        
        $html = "</body></html>";
        
        return $html;

    }
  
    public function loginForm($conf) {
        
        $html = "<div class=\"wraper\">";

            $html .="<form method=\"POST\">";
            $html .="<input type=\"text\" name=\"login\" placeholder=\"Логін\">";
            $html .="<input type=\"password\" name=\"password\" placeholder=\"Пароль\">";
            $html .="<input type=\"hidden\" name=\"task\" value=\"login\">";
            $html .="<input type=\"submit\" value=\"Залогінитись\">";
            $html .="</form>";

            $html .="<form method=\"POST\">";
            $html .="<input type=\"hidden\" name=\"task\" value=\"register\">";
            $html .="<input type=\"submit\" value=\"Зареєструватись\">";
            $html .="</form>";

        $html .= "</div>";
        
        return $html;

    }

    public function registerForm($conf) {
        
        $html ="<form method=\"POST\">";
        $html .="<input type=\"text\" name=\"name\" placeholder=\"Імя\">";
        $html .="<input type=\"text\" name=\"surname\" placeholder=\"Прізвище\">";
        $html .="<input type=\"text\" name=\"middlename\" placeholder=\"По батькові\">";
        $html .="<input type=\"text\" name=\"login\" placeholder=\"Логін\">";
        $html .="<input type=\"password\" name=\"password\" placeholder=\"Пароль\">";
        $html .="<input type=\"hidden\" name=\"task\" value=\"addUser\">";
        $html .="<input type=\"submit\" value=\"Записати в БД\">";
        $html .="</form>";

        $html .="<form method=\"POST\">";
        $html .="<input type=\"hidden\" name=\"task\" value=\"login\">";
        $html .="<input type=\"submit\" value=\"Залогінитись\">";
        $html .="</form>";
    
        return $html;

    }

    public function makeErrorMessage($conf, $error) {
        
        $html ="<h2>{$error}</h2>";
        
        return $html;

    }

    public function makeHTML($conf) {
        
        $html ="<form method=\"POST\">";
        $html .="<h1><br>Вітаю! Ви вдало залогінились.<br></h1>";
        $html .="<input type=\"submit\" value=\"Оновити сторінку\" name=\"submit\">";
        $html .="</form>";

        return $html;

    }

}

?>