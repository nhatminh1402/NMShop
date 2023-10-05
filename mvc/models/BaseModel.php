<?php
/* Lớp tạo ra các phương thức trích xuất dữ liệu tổng quát nhất trong Database,
 cho các model kế thừa và xử dụng. 

- Tham số truyền vào cho các hàm ở dạng tổng quát khi thao tác với sql như sau
$data = ["tên-côt" => "giá-trị", .....]
 */
class Basemodel extends DataConnect
{

    function selectAll()
    {
        $sql = "select * from " . $this->table . " order by id desc";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function TotalNumRecord()
    {
        $sql = "select * from " . $this->table;
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->rowCount();
    }

    function add($data = [])
    {
        $sql = "insert into " . $this->table . " (";
        $columName = implode(",", array_keys($data));
        $sql .= $columName . ")" . " values (";
        $Value = rtrim(str_repeat("?,", count($data)), ",");
        $sql .= $Value . ")";

        $query = $this->conn->prepare($sql);

        // Tham số truyền vào của hàm execute phải là mảng chỉ số liên tục.
        $param = array_values($data);

        if ($query->execute($param)) {
            return json_encode(
                [
                    "result" => "true",
                    "message" => "Thêm mới thành công"
                ]
            );
        } else {
            return json_encode(
                [
                    "result" => "false",
                    "message" => "Thêm mới thất bại"
                ]
            );
        }
    }

    function deleteById($data = [])
    {
        $columnName = array_keys($data)[0];
        $sql = "delete from " . $this->table . " where " . $columnName . " = ?";

        $query = $this->conn->prepare($sql);
        if ($query->execute(array_values($data))) {
            return json_encode(
                [
                    "result" => "true",
                    "message" => "Xoá thành công"
                ]
            );
        } else {
            return json_encode(
                [
                    "result" => "false",
                    "message" => "Xoá thất bại"
                ]
            );
        }
    }

    function update($arrValue, $arrWhere)
    {
        $sql = "Update " . $this->table;
        // Lấy ra danh sách cột cần Update thông tin
        $UpdateColumn = " SET ";
        foreach ($arrValue as $key => $value) {
            $UpdateColumn .= $key . " = ?,";
        }
        $UpdateColumn = rtrim($UpdateColumn, ',');
        // Lấy ra danh sách cột điều kiện cần Update thông tin
        $WhereColumn = " WHERE ";
        foreach ($arrWhere as $key => $value) {
            $WhereColumn .= $key . " = ?,";
        }
        $WhereColumn = rtrim($WhereColumn, ',');
        // Cập nhật lại câu lệnh sql
        $sql .= $UpdateColumn . $WhereColumn;

        // Danh sách tham số cần truyền vào ?
        $arrParams =  array_values(array_merge($arrValue, $arrWhere));
        $query = $this->conn->prepare($sql);
        if ($query->execute($arrParams)) {
            return json_encode(
                [
                    "result" => "true",

                ]
            );
        } else {
            return json_encode(
                [
                    "result" => "false"
                ]
            );
        }
    }

    function totalRows($searchColumn = [], $searchValue = "")
    {
        $sql = "";
        if (empty($searchColumn) || empty($searchValue)) {
            $sql = "select * from " . $this->table;
        } else {
            $sql = "select * from " . $this->table . " where ";
            $whereClause = "";
            foreach ($searchColumn as $searchIem) {
                $whereClause .= $searchIem . " LIKE '%" . $searchValue . "%' OR ";
            }

            $whereClause = rtrim($whereClause, "OR ");
            $sql .= $whereClause;

        }
        
        $query = $this->conn->prepare($sql);
        echo $sql;
        $query->execute();

        return $query->rowCount();
    }


    function pagination($indexStart, $NumberOfPage, $columnSort, $sortCondition, $searchColumn = [], $searchValue = "")
    {
        $sql = "";
        if (empty($searchColumn) || empty($searchValue)) {
            $sql = "select * from " . $this->table . " order by " . $columnSort . " " . $sortCondition . " LIMIT " . $indexStart . "," . $NumberOfPage;
        } else {
            $sql = "select * from " . $this->table . " where ";
            $whereClause = "";
            foreach ($searchColumn as $searchIem) {
                $whereClause .= $searchIem . " LIKE '%" . $searchValue . "%' OR ";
            }

            $whereClause = rtrim($whereClause, "OR ");

            $sql .= $whereClause . " ORDER BY " . $columnSort . " " . $sortCondition . " LIMIT " . $indexStart . "," . $NumberOfPage;
        }

        $query = $this->conn->prepare($sql);
        $query->execute();
       

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
