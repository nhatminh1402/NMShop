<?php
// Biến dùng để xác định đâu là file js cần dùng cho file php này
$includeManageBrandjs = true;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 id="hihi">QUẢN LÝ HÃNG SẢN XUẤT</h1>
        </div>
      </div>
    </div>

  </section>

  <div class="container-fluid">
    <div class="row">
      <div class="col d-flex"><button type="button" data-toggle="modal" data-toggle="modal" data-target="#staticBackdrop" class="brand-button btn-add-brand-modal mb-2 btn btn-success"><i class="bi bi-plus-square"></i>
          THÊM
        </button>
        <div class="dropdown mr-1 ml-5">
          <button class="dropdown-sort btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sắp xếp theo tên
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item sort-asc" href="#">Tăng dần</a>
            <a class="dropdown-item sort-desc" href="#">Giảm dần</a>
          </div>
        </div>
        <div>
            <input id="search-brand-form" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <!-- Modal -->

  </section>

  <div class="modal-form-add-brand modal fade my-modal-add-brand" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">THÊM MỚI HÃNG ĐIỆN THOẠI</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="">Tên hãng</label>
              <input type="text" class="form-control" id="brand-name">
              <small style="color: red !important;" id="brand-name-error" class="form-text text-muted"></small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn-add-brand btn btn-primary">Add</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- modal-update-info-brand -->
  <div class="modal-update-brand modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">CẬP NHẬT HÃNG SẢN XUẤT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- --------- -->
          <form>
            <div class="form-group">
              <label >TÊN HÃNG</label>
              <input type="text" class="form-control" id="brand-name-update-info">
              <small style="color:red !important" id="brand-name-update-error" class="form-text text-muted"></small>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="brand-id-update-info" hidden>
            </div>
          </form>
          <!-- --------- -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-save-brand-update">Save changes</button>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.content-wrapper -->

<!-- <script src="./public/js/ManageBrand.js"></script> -->