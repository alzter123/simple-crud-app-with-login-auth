<?php

namespace Classes;

use Classes\Connection;

class AccountClass{

    public function getAccount(){
        $data2 = new Connection();
        $db = $data2->Connection();

        if(isset($_GET['getId']) && $_GET['getId'] == 1){
            $db->where('UserId', $_GET['token']);
            $getAdminAccount = $db->get('accounts');
            echo json_encode($getAdminAccount);
        }
        if(isset($_GET['getId']) && $_GET['getId'] == 2){
            $db->where('AccessId', 2);
            $getAdminAccount = $db->get('accounts');
            echo json_encode($getAdminAccount);
        }
    }

    public function addAccount(){
        $data3 = new Connection();
        $db = $data3->Connection();

        if(isset($_GET['addId']) && $_GET['addId'] == 1){
            $accountData = file_get_contents('php://input');
            $accOutput = json_decode($accountData);
            $user = $accOutput->{'username'};
            $pass = $accOutput->{'password'};
            $fname = $accOutput->{'fname'};
            $lname = $accOutput->{'lname'};

            $hashPass = password_hash($pass, PASSWORD_DEFAULT);

            $addAccData = array(
                'AccessId' => 2,
                'Username' => $user,
                'Password' => $hashPass,
                'FirstName' => $fname,
                'LastName' => $lname
            );

            $newAccountData = $db->insert('accounts', $addAccData);
            if($newAccountData){
                echo "User account successfully created!";
            }
        }
    }

    public function updateAccount(){
        $data4 = new Connection();
		$db = $data4->Connection();


        if(isset($_GET['editId']) && $_GET['editId'] == 1){
            $updateAcc = file_get_contents('php://input');
            $updateOutput = json_decode($updateAcc);
            $userId = $updateOutput->{'userId'};
            $user = $updateOutput->{'user'};
            $pass = $updateOutput->{'pass'};
            $fname = $updateOutput->{'fname'};
            $lname = $updateOutput->{'lname'};

            $hashNewPass = password_hash($pass, PASSWORD_DEFAULT);

            $updateAccData = array(
                'AccessId' => 2,
                'Username' => $user,
                'Password' => $hashNewPass,
                'FirstName' => $fname,
                'LastName' => $lname
            );

            $db->where('UserId', $userId);
            $renewedAcc = $db->update('accounts', $updateAccData);
            if($renewedAcc){
                echo "User account successfully updated!";
            }
        }
    }

    public function deleteAccount(){
        $data5 = new Connection();
		$db = $data5->Connection();


        if(isset($_GET['delId']) && $_GET['delId'] == 1){

            $db->where('UserId', $_GET['userId']);
            $deleteUser = $db->delete('accounts');
            if($deleteUser){
                echo "User account successfully deleted!";
            
            }
        }
    }


}

?>