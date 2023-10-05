<?php
/* 
    Class App nhận trách nhiệm tiếp nhận request. Phân tích - xử lý xem controller nào sẻ được thực hiện
    Cấu trúc thanh url như sau: tên_miền/admin/controler_Admin/para [dành cho Admin]
    Hoặc:                           tên_miền/controller/para... [dành cho khách hàng]
*/

class App {
    protected $controller = "";
    protected $action = "";
    protected $params = [];

    // Hàm tạo có nhiệm vụ với mỗi request - xử lý url và gọi ra controller - view tương ứng cho người dùng
    function __construct() {
        $urlArr = $this->getURL();

        // Bước 1: Kiểm tra xem người dùng gọi controller nào
        if($urlArr != null) {
            // Xử lý controller cho Admin
            if($urlArr[0] == "admin") {
                // Nếu có thì cập nhật lại controller mặc định thành controller theo request
                if(isset($urlArr[1])) {
                    if(file_exists("./mvc/controllers/admin/".$urlArr[1].".php") == true){
                        $this->controller = $urlArr[1];
                        unset($urlArr[0]);
                        unset($urlArr[1]);
                        // Tiến hành gọi controller tương ứng sau khi xử lý thành công
                        require_once "./mvc/controllers/admin/".$this->controller.".php";
                    } 
                } else {
                    // xử lý sau
                }
            // Xử lý controller cho người dùng
            } else {
                if(file_exists("./mvc/controllers/".$urlArr[0].".php") == true){
                    // Cập nhật lại controller mặc định thành controller theo request của người dùng
                    $this->controller = $urlArr[0];
                    unset($urlArr[0]);
                    // Tiến hành gọi controller tương ứng sau khi xử lý thành công
                    require_once "./mvc/controllers/".$this->controller.".php";
                }
            }
        }
        // Gọi controller tương ứng
        $this->controller = new $this->controller;

        // Bước 2: Gọi Action ứng với controller đó.
        $urlArr = array_values($urlArr);
        
        if(isset($urlArr[0])) {
            if(method_exists($this->controller, $urlArr[0])) {
                $this->action = $urlArr[0];
                unset($urlArr[0]);
            }
        }

        $this->params = empty($urlArr) ? [] : array_values($urlArr);

        call_user_func_array([$this->controller, $this->action], $this->params);
    }


    // Hàm giúp lấy về URL từ file .htaccess
    function getURL() {
        if(isset($_GET["url"])) {
            $url = $_GET["url"];
            $urlArr = array_filter(explode("/",$url));
            return array_values($urlArr);
        }
        return null;
    }
}