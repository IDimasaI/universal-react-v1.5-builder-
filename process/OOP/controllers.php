<?php


class CA {
    protected function non_auth() {
        $tokenCookie = filter_input(INPUT_COOKIE, '__token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tokenCookie= htmlspecialchars($tokenCookie);
        if($tokenCookie){
            session_name('__token');
            session_start();
                if (empty($_SESSION['token_user'])||!isset($_SESSION['token_user'])) {
                    header('Location: https://sc.projectmy.rf.gd');
                    exit;
                }
            session_write_close();
        }else{
            header('Location: https://sc.projectmy.rf.gd');
            exit;
        }
    }
}

class HomeController extends CA {
    public function index() {
        echo "<section class='base' id='main_page'><p>Основная страница</p><br><a href='router'>Сборник всех маршрутов</a></section>";
    }
}

class UserController extends CA {
    public function me() {
        $this->non_auth();
        include 'routers/me.php';
    }

    public function public_users() {
        $this->non_auth();
        echo 'public_users. Этого еще нет';
    }
}

class PublicController{
    public function Regions($name){
        $name;
       include './routers/Regions.php';
    }
}

class FitsController extends CA {
    public function fits($type) {
        echo $type;
    }
}
?>