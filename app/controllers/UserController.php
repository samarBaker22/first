<?php
namespace app\controllers;

require __DIR__.'/../models/UserModel.php';
use app\models\UserModel;


class UserController {
    private $model;

    public function __construct($db) {
      
        $this->model = new UserModel($db);
    }
    private function jsonResponse($data){
        header("content-type:application/json");
        echo json_encode($data);
        exit;

    }
    public function index() {
        $users = $this->model->getUsers();
        //echo json_encode($users);
        $this->jsonResponse($users);
        // var_dump('gg');
        //راح ترجع مصفوفة داخل مصفوفة كي و فاليو
        //include __DIR__.'/../views/user_list.php';
        //خليك بهاد المجلد لا تروح لغيرو
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username']??'';
            $password = $_POST['password']??'';
            //عم نستخدم مكتبة
            $data = [
                'username' => $username,
                'password' => $password,
            ];

            if ($this->model->addUser($data)) {
                $this->jsonResponse(['message'=>'user add successfully']);
              //عشان يشوف ا>زا ضاف ويعرض كل يوزر
                // راح ترجع رابط اساسي بدون اد
               // header('Location:' . BASE_PATH);
                //echo 'done' ;
            } else {
                //echo "Failed to add user.";
                $this->jsonResponse(['error'=>'failed not allowed']);
            }
        }
            else{
                $this->jsonResponse(['error'=>'method not allowed']);
            }
        }
    
    

    public function showUsers() {
        $users = $this->model->getUsers();
        include '../views/user_list.php';
    }

    public function deleteUser($id) {
        if ($this->model->deleteUser($id)) {
            echo "User deleted successfully!";
            header('Location:' . BASE_PATH);
        } else {
            echo "Failed to delete user.";
        }
    }

    public function updateUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $data = [
                'username' => $username,
                'password' => $password,
            ];
//data post id get update=>true||false
            if ($this->model->updateUser($id, $data)) {
                echo "User updated successfully!";
                header('Location:' . BASE_PATH);
            } else {
                echo "Failed to update user.";
            }
        } else {
            $user = $this->model->getUserById($id);
            include __DIR__.'/../views/edit_user.php';
        }
    }

    public function editUser($id) {
        $user = $this->model->getUserById($id);
        include __DIR__.'/../views/edit_user.php';
    }

    public function searchUsers($searchTerm) {
        $users = $this->model->searchUsers($searchTerm);
        include '../views/user_list.php';
    }

    public function showSearchedUsers($searchTerm) {
        $users = $this->model->searchUsers($searchTerm);
        include '../views/user_list.php';
    }
}
