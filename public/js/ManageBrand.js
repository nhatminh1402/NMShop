// Khởi tạo giá trị mặc định khi vào page lần đầu tiên 
let sortCondition = "desc"
let columnSort = "id"

/* Phân trang sử dụng ajax: tham số truyền vào bao gồm
    1. Hiển thị trang số bao nhiêu
    2. Sort theo tiêu chí nào: DESC/ASC
    3. Sort theo cột nào
*/

function fetch_data_brand(pageNumber, sortCondition, columnSort, searchColumn = null, searchValue = null) {
    $.ajax({
        url: "http://localhost:8888/nmshop/admin/managebrand/pagination",
        method: "POST",
        data: 
            { pageNumber : pageNumber, 
              sortCondition : sortCondition, 
              columnSort  : columnSort,
              searchColumn: JSON.stringify(searchColumn),
              searchValue : searchValue
            },
        dataType: "html",
        success: function (response) {
            $(".content-wrapper .content").html(response)
        }, error: function (textStatus, errorThrown) {
            console.log("Yêu cầu AJAX thất bại");
            console.log("Lỗi: " + textStatus);
            console.log("ErrorThrown: " + errorThrown);
        }
    })
}

// Cho khởi chạy lần đầu tiên hiển thị dữ liệu phân trang
fetch_data_brand()


$(function () {
    $(".sort-desc").on("click", function (event) {
        event.preventDefault();
        $(".dropdown-sort").html('Sắp xếp theo tên: ' + '<i class="bi bi-arrow-bar-down"></i>')
        //Cập nhật lại điều kiện sắp xếp
        sortCondition = "desc"
        columnSort = "Ten_hang"
        fetch_data_brand(1, sortCondition, columnSort)
    })

    $(".sort-asc").on("click", function (event) {
        event.preventDefault();
        $(".dropdown-sort").html('Sắp xếp theo tên: ' + '<i class="bi bi-arrow-bar-up"></i>')
        //Cập nhật lại điều kiện sắp xếp
        sortCondition = "ASC"
        columnSort = "Ten_hang"
        fetch_data_brand(1, sortCondition, columnSort)
    })

})

// Search
$(function() {
    $("#search-brand-form").on("keypress", function(event) {
        if(event.keyCode == 13) {
            $searchValue = $("#search-brand-form").val()
            fetch_data_brand(1, sortCondition, columnSort, [ "id", "Ten_hang" ], $searchValue)
        }
    })
})


// Sự kiện click để điều hướng về trang thứ "n"
$(document).on("click", ".page-link-brand-name", function () {
    let pageNumber = $(this).data("id")
    let searchValue = $(this).data("search-value")
    console.log(searchValue)
    fetch_data_brand(pageNumber, sortCondition, columnSort, ["id", "Ten_hang"], searchValue)
})


// Thêm mới một hãng điện thoại
$(".btn-add-brand").on("click", function () {
    if (!$("#brand-name").val()) {
        $("#brand-name-error").text("Vui lòng không để trống")
    } else {
        let brandName = $("#brand-name").val()
        $.ajax({
            url: "http://localhost:8888/nmshop/admin/ManageBrand/add",
            method: "POST",
            data: { brandName: brandName },
            dataType: "json",// kiểu dũ liệu trả về 
            success: function (response) {
                if (response.result == true) {
                    $(".modal.my-modal-add-brand").modal("toggle")
                    fetch_data_brand(1)
                    //Pop-Up thông báo thêm mới thành công
                    Swal.fire(
                        'THÊM MỚI THÀNH CÔNG',
                        '',
                        'success'
                    )
                } else {
                    console.log("Lỗi");
                }
            },
            error: function (errorThrown) {
                // Xử lý lỗi
                console.log("Yêu cầu AJAX thất bại");
                console.log("Lỗi: " + textStatus);
                console.log("ErrorThrown: " + errorThrown);
            }
        })
    }

})

// Xoá một hãng điện thoại
$(document).on("click", ".brand-button-delete", function () {
    let idBrandClick = $(this).data("id")
    // Hiển thị alert confirm xác nhận xoá cho người dùng
    Swal.fire({
        title: 'BẠN CHẮC CHẮN MUỐN XOÁ CHỨ?',
        text: "Lưu ý: không thể hoàn tác dữ liệu sau khi xác nhận xoá!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xoá'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "http://localhost:8888/nmshop/admin/managebrand/deleteBrand",
                method: "POST",
                data: { id : idBrandClick },
                dataType: "json",
                success: function (response) {
                    if (response.result == true) {
                        // Hiển thị alert thông báo xoá thành công  
                        Swal.fire(
                            'Deleted!',
                            'Xoá thành công.',
                            'success'
                        )
                        fetch_data_brand(1)
                    } else {
                        // Hiển thị alert thông báo xoá thất bại 
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: '<a href="">Why do I have this issue?</a>'
                          })
                    }
                }, error: function (textStatus,errorThrown) {
                    console.log("Yêu cầu AJAX thất bại");
                    console.log("Lỗi: " + textStatus);
                    console.log("ErrorThrown: " + errorThrown);
                }
            })
        }
    })

})


$(function() {
    // Hiển thị modal cập nhật tên hãng điện thoại
    $(document).on("click", ".brand-button-update", function() {
        $(".modal-update-brand").modal("toggle")
        let idBrand = $(this).data("id")
        let BrandName = $(this).parent().parent().children(".brand-name").text()
        $("#brand-name-update-info").val(BrandName)
        $("#brand-id-update-info").val(idBrand)
    })

    $(document).on("click", ".btn-save-brand-update", function() {
        let brandName = $("#brand-name-update-info").val()
        let id = $("#brand-id-update-info").val()
        brandName = brandName.trim()
        if(!brandName) {
          $("small#brand-name-update-error").text("Vui lòng nhập đầy đủ thông tin")
        } else {
           $.ajax({
            url: "http://localhost:8888/nmshop/admin/managebrand/updateBrand",
            method: "POST",
            data : { id : id, brandName : brandName},
            dataType: "json", 
            success: function(response) {
                if(response.result == "success") {
                    $(".modal-update-brand").modal("toggle")
                    $("#name-brand-value" + id).text(brandName)
                    //alert thông báo thành công
                    Swal.fire(
                        'Updated!',
                        'Cập nhật thành công.',
                        'success'
                    )
                } else {
                    // Hiển thị alert thông báo lỗi
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        footer: '<a href="">Why do I have this issue?</a>'
                      })
                }
            }
           }) 

        }
        
    })
    
})
