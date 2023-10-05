<?php

class ManageBrand extends Controller
{
  protected $model;

  public function __construct()
  {
    if(!isset($_SESSION["logged-in"])) {
      //header("location: http://localhost:8888/nmshop/admin/login/index");
      die;
    }
    
    $this->model = $this->models("DanhMucHangModel");
  }

  // Hiển thị trang quản lý hãng điện thoại
  function index()
  {
    $this->view("ManageBrand");
  }

  function add()
  {

    if (empty($_POST)) {
      // Chuyển về trang bán hàng
      die;
    }

    $name = $_POST["brandName"];

    $result = json_decode($this->model->add(["Ten_hang" => $name]), true);

    if ($result["result"] == "true") {
      echo json_encode(
        [
          "result" => true
        ]
      );
    } else {
      echo json_encode(
        [
          "result" => false
        ]
      );
    }
  }

  function pagination()
  {
    // Khởi tạo số record mặc định của mỗi page
    $NumberOfPage = 5;

    // Lấy ra page cần hiển thị
    if (isset($_POST["pageNumber"])) {
      $page = $_POST["pageNumber"];
    } else {
      $page = 1;
    }

    //Lấy ra điều kiện sắp xếp
    if (isset($_POST["sortCondition"])) {
      $sortCondition = $_POST["sortCondition"];
    } else {
      // Mặc định sắp xếp theo id tăng dần
      $sortCondition = "DESC";
    }


    //Lấy ra cột cần sắp xếp
    if (isset($_POST["columnSort"])) {
      $columnSort = $_POST["columnSort"];
    } else {
      // Mặc định sắp xếp theo id
      $columnSort = "id";
    }

    $indexStart = ($page - 1) * $NumberOfPage;

    $searchValue = "";
    $searchColumnArray = "";
    // Lấy ra chuỗi ký tự "Tìm kiếm" nếu có
    if (empty($_POST["searchValue"]) || empty($_POST["searchColumn"])) {
      $result = $this->model->pagination($indexStart, $NumberOfPage, $columnSort, $sortCondition);
    } else {
      // Nhận dữ liệu từ AJAX request
      $searchColumnJSON = $_POST['searchColumn'];
      // Chuyển chuỗi JSON thành mảng PHP
      $searchColumnArray = json_decode($searchColumnJSON, true);
      $searchValue = $_POST["searchValue"];
      $result = $this->model->pagination($indexStart, $NumberOfPage, $columnSort, $sortCondition, $searchColumnArray, $_POST["searchValue"]);
    }


    // Hiển thị kết quả truy vấn
    if (count($result) <= 0) {
      echo "<h1>KHÔNG CÓ DỮ LIỆU!</h1>";
    } else {
      $output = '<div class="row"><div class="col-12">
            <table class="table table-striped table-hover">
              <thead class="">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">HÃNG</th>
                  <th scope="col">HÀNH ĐỘNG</th>
                </tr>
              </thead>
              <tbody id="get-data" class="data-brand-upload">';
      foreach ($result as $item) {
        $output .= '<tr>
                <th scope="row">' . $item["id"] . '</th>
                <td id="name-brand-value' . $item["id"] . '" class="brand-name">' . $item["Ten_hang"] . '</td>
                <td>
                  <button type="button" data-id="' . $item["id"] . '" class="brand-button brand-button-update btn btn-primary">
                    <i class="bi bi-pencil-square"></i>
                    CHỈNH SỬA
                  </button>
                  <button type="button" class="brand-button-delete btn btn-danger" data-id="' . $item["id"] . '">
                    <i class="bi bi-trash3"></i>
                    XOÁ
                  </button>
                </td>
              </tr>';
      }
      $output .= '</tbody></table></div></div>';

      // // Xử lý dữ liệu cho thanh phân trang
      $totalRows = $this->model->totalRows($searchColumnArray, $searchValue); 
      $totalPage = ($totalRows % $NumberOfPage) == 0 ? ($totalRows / $NumberOfPage) : ($totalRows / $NumberOfPage) + 1;

      $output .= '<div class="row"><div class="col-12"><nav aria-label="Page navigation example"><ul class="pagination">';
      for ($i = 1; $i <= $totalPage; $i++) {
        $active = "";
        if ($page == $i) {
          $active = "active";
        }
        $output .= '<li class="page-item ' . $active . '" data-id="' . $i . '">
                      <a data-id="' . $i . '"" data-search-value="'.$searchValue.'" class="page-link page-link-brand-name">' . $i . '</a>
                    </li>';
      }

      $output .= "</ul></nav></div></div>";

      echo $output;
    }
  }

  function deleteBrand()
  {

    if (!isset($_POST["idBrandClick"])) {
      // header()
      //chuyển về trang home;
      // die;
    }

    $data = ["id" => $_POST["id"]];

    $result = json_decode($this->model->deleteById($data), true);

    if ($result["result"]) {
      echo json_encode(
        [
          "result" => true
        ]
      );
    } else {
      echo json_encode(
        [
          "result" => false
        ]
      );
    }
  }

  function updateBrand()
  {
    $id = "";
    $brandName = "";
    if (!isset($_POST["id"])) {
      // điều hướng về trang khách hàng
      die;
    }

    if (!isset($_POST["brandName"])) {
      // điều hướng về trang khách hàng
      die;
    }

    $id = $_POST["id"];
    $brandName = $_POST["brandName"];
    $dataUpdate = [
      "Ten_hang" => $brandName
    ];

    $whereUpdate = [
      "id" => $id
    ];

    $result = json_decode($this->model->update($dataUpdate, $whereUpdate), true);
    if ($result["result"] == true) {
      echo json_encode(
        [
          "result" => "success"
        ]
      );
    } else {
      echo json_encode(
        [
          "result" => "failed"
        ]
      );
    }
  }

  function search()
  {
  }


}
