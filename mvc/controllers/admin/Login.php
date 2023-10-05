<?php 

class Login extends Controller {

    protected $model;

    function __construct()
    {
        $this->model = $this->models("AdminModel");
    }

    public function index() {
        require_once("./mvc/views/admin/AdminLogin.php");
    }

    public function authenticate() {
        $email =  $_POST["email"];
        $passWord =  $_POST["password"];
        $remember =  isset($_POST["remember"]) ? $_POST["remember"] : false;

        $result = $this->model->isAccountExist($email, $passWord);
        echo "<pre>";
        
        if(count($result) == 1) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user-name"] = $result[0]["Name"];
            var_dump($_SESSION);
            header("location: http://localhost:8888/nmshop/admin/ManageBrand/index");
        } else {
            echo "Đăng nhập thất bại";
        }

    }
}