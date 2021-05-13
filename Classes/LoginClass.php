<?php

namespace Classes;

use Classes\Connection;

class LoginClass{

    public function loginAccount(){
        $data1 = new Connection();
        $db = $data1->Connection();

        if(isset($_GET['loginId']) && $_GET['loginId'] == 1){
            $loginData = file_get_contents('php://input');
            $loginOutput = json_decode($loginData);
            $user = $loginOutput->{'user'};
            $pass = $loginOutput->{'pass'};


            if(empty($pass) && empty($user)){
                echo 'Fail5';
            } else if(empty($user)){
                echo 'Fail3';
            } else if(empty($pass)){
                echo 'Fail4';
            } else {

            $db->where('Username', $user);
            $getUsers = $db->get('accounts');
            
            
            foreach($getUsers as $gu){
                $gu2 = $gu['Username'];
            }

            if($user == $gu2){
                $db->where('Username', $gu2);
                $getHashedPass = $db->get('accounts');

                foreach($getHashedPass as $ghp){
                    $ghp2 = $ghp['Password'];

                    if(password_verify($pass, $ghp2) == 1){

                        $db->where('Username', $gu2);
                        $db->where('Password', $ghp2);
                        $getAccount = $db->get('accounts');
                        echo json_encode($getAccount);

                    } else {
                        echo 'Fail2';
                    }
                }

            } else {
                echo 'Fail1';
            }
        }



            }

            if (isset($_GET['loginId']) && $_GET['loginId'] == 2) {
            }

    }

    
}

?>