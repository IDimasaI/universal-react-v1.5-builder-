<?php
class CA {
    
}
class PublicController extends CA {
    public function test2($var1,$var2) {
       'лаадно, тебе все можно';
      include 'Pages/test2.php';
    }

    
    public function test() {
       'лаадно, тебе все можно';
      include 'Pages/test.php';
    }

   
}

class PrivateController extends CA {
    public function testdsd3() {
       'вы кто такие ? Я вас не звал идите нахуй !';
      include 'Pages/test3dadsa.php';
    }

    public function test3($var1) {
       'вы кто такие ? Я вас не звал идите нахуй !';
      include 'Pages/test3.php';
    }

  
}
class UsersController extends CA {
   
}
?>



