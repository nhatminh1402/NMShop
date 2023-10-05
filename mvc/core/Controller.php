<?php

class Controller {

    // Gọi đến MasterPage, truyền vào $page: chính là page detail muốn hiển thị
    // Page detail cần dữ liệu gì thì truyền vào biến $data
    function view($page, $data = NULL) {
        require_once "./mvc/views/admin/MasterPage.php";
    }

    function models($model) {
        require_once "./mvc/models/".$model.".php";
        return new $model;
    }
}