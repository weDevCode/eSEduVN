<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Truy cập trực tiếp bị cấm!</h1>');
    }
    @require_once('settings.php');
    /**
     * Class Database để thao tác với cơ sở dữ liệu MySQL
     */
    class Database 
    {
        public $conn;
        /**
         * Hàm khởi tạo kết nối đến cơ sở dữ liệu
         * Báo lỗi nếu không kết nối được đến cơ sở dữ liệu
         * @return void
         */
        public function __construct() {
            $this->conn = @mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
            if (!$this->conn) {
                die("<h1>Không thể kết nối tới Cơ Sở Dữ Liệu, hãy kiểm tra lại thông tin! (#01)</h1>");
            }
        }
        /**
         * Hàm thực thi chuỗi lệnh SQL đơn giản đến phức tạp.
         * Trả về void khi thực hiện xong
         * @param string $query nhận vào chuỗi giá trị.
         * @return query|false
         * Trả về chuỗi query nếu thực thi thành công.
         * Trả về false nếu thất bại
         */
        public function query(string $query)
        {
            $conn = $this->conn;
            return $conn->query($query);
        }
        /**
         * Hàm khởi tạo bảng theo mẫu
         * CREATE TABLE $tableName (
         *      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         *      time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
         * )
         * @param string $tableName
         * Tên bảng cần tạo
         * @return true|false 
         * Trả về true nếu thành công, false nếu thất bại
         */
        public function createTable(string $tableName)
        {
            if ($tableName == '') {
                echo "Bạn phải nhập tên bảng để tạo!";
                return false;
            } else {
                $conn = $this->conn;
                $query = 
                "CREATE TABLE $tableName (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
                if (!$conn->query($query)) {
                    echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                    return false;
                } else {
                    return true;
                }
            }
        }

        /**
         * Hàm chèn dữ liệu 1 dòng vào bảng
         * @param string $tableName
         * Bảng cần chèn
         * @param string $col
         * Các Cột cần chèn
         * @param string $data
         * Các Dữ liệu cần chèn
         * @return last_id|false
         * Trả về id dòng mới chèn vào nếu thành công, false nếu thất bại
         */
        public function insertADataRow(string $tableName, string $col, string $data)
        {
            $conn = $this->conn;
            if ($tableName == '') {
                echo "Vui lòng nhập tên bảng cần chèn dữ liệu!";
                return false;
            } else {
                $data = mysqli_real_escape_string($conn, $data);
                $query = 
                "INSERT INTO $tableName ($col)
                VALUES ('$data')";
                if (!$conn->query($query)) {
                    echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                    return false;
                } else {
                    return mysqli_insert_id($conn);
                }
            }
        }

        /**
         * Hàm chèn dữ liệu nhiều dòng vào bảng
         * @param string $tableName
         * Bảng cần chèn
         * @param array $col
         * Các Cột cần chèn
         * @param array $data
         * Các Dữ liệu cần chèn
         * @return last_id|false
         * Trả về id dòng mới chèn vào nếu thành công, false nếu thất bại
         */
        public function insertMulDataRow(string $tableName, array $col, array $data)
        {
            $query1 = '';
            $query2 = '';
            $conn = $this->conn;
            if ($tableName == '') {
                echo "Vui lòng nhập tên bảng cần chèn dữ liệu!";
                return false;
            } elseif (count($col) == count($data)) {
                $query = "INSERT INTO $tableName";
                for ($i=0; $i < count($col); $i++) { 
                    if (count($col)==1) { // Nếu tổng là 1
                        $query1 .= "$col[$i]";
                        $query2 .= "'".mysqli_real_escape_string($conn, $data[$i])."'";
                        break;
                    }
                    if ($i==count($col)-1) { // Nếu lặp đến cuối cùng
                        $query1 .= "$col[$i]";
                        $query2 .= "'".mysqli_real_escape_string($conn, $data[$i])."'";
                        break;
                    }
                    $query1 .= "$col[$i], ";
                    $query2 .= "'".mysqli_real_escape_string($conn, $data[$i])."', ";
                }
                $query .= "(".$query1.") VALUES (".$query2.");";
                if (!$conn->query($query)) {
                    echo "Thực thi câu lệnh <b>$query</b> thất bại";
                    return false;
                } else {
                    return mysqli_insert_id($conn);
                }
            } else {
                echo "2 mảng phải bằng nhau về số lượng!";
                return false;
            }
        }

        /**
         * Hàm cập nhật dữ liệu 1 dòng từ bảng
         * @param string $tableName
         * Bảng để xoá dữ liệu
         * @param string $col
         * Cột cần cập nhật
         * @param string $data
         * Dữ liệu cần cập nhật
         * @param string $columnToUpdate
         * Điều kiện kiểm tra: cột.
         * @param string $dataToUpdate
         * Điều kiện kiểm tra: dữ liệu.
         * Nếu $columnToUpdate==$dataToUpdate ==> Thực thi
         * @return true|false
         * Trả về true nếu thành công, false nếu thất bại
         */
        public function updateADataRow(string $tableName, string $col, string $data, string $columnToUpdate, string $dataToUpdate)
        {
            $conn = $this->conn;
            if ($tableName == '') {
                echo "Vui lòng nhập tên bảng cần cập nhật!";
                return false;
            } else {
                $data = mysqli_real_escape_string($conn, $data);
                $query = 
                "UPDATE $tableName SET $col='$data' WHERE $columnToUpdate='$dataToUpdate'";
                if (!$conn->query($query)) {
                    echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                    return false;
                } else {
                    return true;
                }
            }
        }

        /**
         * Hàm cập nhật dữ liệu nhiều dòng cho bảng
         * @param string $tableName
         * Tên bảng cần cập nhật dữ liệu
         * @param array $col
         * Các cột cần cập nhật
         * @param array $data
         * Các dữ liệu để cập nhật cho các cột
         * @param string $columnToUpdate
         * Điều kiện kiểm tra: cột
         * @param string $dataToUpdate
         * Điều kiện kiểm tra: dữ liệu.
         * Nếu $columnToUpdate==$dataToUpdate ==> Thực thi
         * @return true|false
         * Trả về true nếu thành công, false nếu thất bại
         */
        public function updateMulDataRow(string $tableName, array $col, array $data, string $columnToUpdate, string $dataToUpdate)
        {
            $conn = $this->conn;
            if ($tableName == '') {
                echo "Vui lòng nhập tên bảng cần cập nhật!";
                return false;
            } elseif (count($col) == count($data)) {
                for ($i=0; $i < count($col); $i++) { 
                    $query = 
                    "UPDATE $tableName
                    SET ".$col[$i]."="."'".mysqli_real_escape_string($conn, $data[$i])."'"."
                    WHERE $columnToUpdate='$dataToUpdate';";
                    if (!$conn->query($query)) {
                        echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                        return false;
                    }
                }
                return true;
            } else {
                echo "2 mảng phải bằng nhau về số lượng!";
                return false;
            }
        }
        /**
         * Hàm xoá dữ liệu 1 dòng từ bảng
         * @param string $tableName
         * Bảng để xoá dữ liệu
         * @param string $columnToDelete
         * Cột cần xoá
         * @param string $dataToDelete
         * Dữ liệu cần xoá - Nếu $columnToDelete == $dataToDelete ==> Xoá dòng
         * @return true|false
         * Trả về true nếu thành công, false nếu thất bại
         */
        public function deleteADataRow(string $tableName, string $columnToDelete, string $dataToDelete)
        {
            $conn = $this->conn;
            if ($tableName == '') {
                echo "Vui lòng nhập tên bảng cần cập nhật!";
                return false;
            } else {
                $dataToDelete = mysqli_real_escape_string($conn, $dataToDelete);
                $query = 
                "DELETE FROM $tableName
                WHERE $columnToDelete='$dataToDelete'";
                if (!$conn->query($query)) {
                    echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                    return false;
                } else {
                    return true;
                }
            }
        }

        /**
         * Hàm xoá dữ liệu nhiều dòng từ bảng
         * @param string $tableName
         * Bảng để xoá dữ liệu
         * @param array $columnToDelete
         * Các cột cần xoá
         * @param array $dataToDelete
         * Các dữ liệu cần xoá - Nếu $columnToDelete == $dataToDelete ==> Xoá dòng
         * @return true|false
         * Trả về true nếu thành công, false nếu thất bại
         */
        public function deleteMulDataRow(string $tableName, array $columnToDelete, array $dataToDelete)
        {
            $conn = $this->conn;
            if ($tableName == '') {
                echo "Vui lòng nhập tên bảng cần cập nhật!";
                return false;
            } elseif (count($columnToDelete) == count($dataToDelete)) {
                for ($i=0; $i < count($columnToDelete); $i++) { 
                    $query = 
                    "DELETE FROM $tableName
                    WHERE ".$columnToDelete[$i]."="."'".mysqli_real_escape_string($conn, $dataToDelete[$i])."'";
                    if (!$conn->query($query)) {
                        echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                        return false;
                    }
                }
                return true;
            } else {
                echo "2 mảng phải bằng nhau về số lượng!";
                return false;
            }
        }
        /**
         * Hàm tìm và chọn giá trị từ 1 cột hay 1 hàm từ SQL
         * @param string $tableName
         * Tên bảng cần lấy dữ liệu
         * @param string $columnToSelect
         * Giá trị trong cột cần chọn
         * @param string $colToCheck
         * Cột cần kiểm tra
         * @param string $dataToCheck
         * Dữ liệu cần kiểm tra
         * @return data|0|false
         * Trả về data lấy được nếu thành công, 0 nếu không tìm thấy, false nếu thất bại
         */
        public function getSingleData(string $tableName, string $columnToSelect, string $colToCheck = '', string $dataToCheck = '')
        {
            $conn = $this->conn;
            if ($tableName == '') {
                echo "Vui lòng nhập tên bảng cần lấy dữ liệu!";
                return false;
            } elseif ($colToCheck!=''&&$dataToCheck!='') {
                $dataToCheck = mysqli_real_escape_string($conn, $dataToCheck);
                $query = 
                "SELECT $columnToSelect FROM $tableName WHERE $colToCheck='$dataToCheck'";
                $result = $conn->query($query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    return $row[$columnToSelect];
                } else {
                    return 0;
                }
                if (!$result) {
                    echo "Thực thi câu lệnh <b>$query</b> thất bại";
                    return false;
                }
            } else {
                $query = 
                "SELECT $columnToSelect FROM $tableName";
                $result = $conn->query($query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    return $row[$columnToSelect];
                } else {
                    return 0;
                }
                if (!$result) {
                    echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                    return false;
                }
            }
        }

        /**
         * Hàm tìm và chọn giá trị từ nhiều cột hay hàm từ SQL
         * @param string $tableName
         * Tên bảng cần lấy dữ liệu
         * @param array $columnToSelect
         * Các giá trị trong cột cần chọn
         * @param string $colToCheck
         * Cột cần kiểm tra
         * @param string $dataToCheck
         * Dữ liệu cần kiểm tra
         * @return array|0|false
         * Trả về array lấy được nếu thành công, 0 nếu không tìm thấy, false nếu thất bại
         */
        public function getMulData(string $tableName, array $columnToSelect, string $colToCheck = '', string $dataToCheck = '')
        {
            $conn = $this->conn;
            if ($tableName == '') {
                echo "Vui lòng nhập tên bảng cần lấy dữ liệu!";
                return false;
            } elseif ($colToCheck!=''&&$dataToCheck!='') {
                $query = '';
                for ($i=0; $i < count($columnToSelect); $i++) {
                    if ($i==0) {
                        if (count($columnToSelect)==1) {
                            $query = "SELECT ".$columnToSelect[$i]." FROM $tableName";
                            break;
                        } else {
                            $query = "SELECT ".$columnToSelect[$i].", ";
                            continue;
                        }
                    } elseif ($i==(count($columnToSelect))-1) {
                        $query .= $columnToSelect[$i]." FROM $tableName";
                        continue;
                    } 
                    $query .= $columnToSelect[$i].", ";
                }
                $query .= " WHERE $colToCheck='".mysqli_real_escape_string($conn, $dataToCheck)."'";
                $result = $conn->query($query);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $rows[] = $row;
                    }
                    return $rows;
                } else {
                    return 0;
                }
                if (!$result) {
                    echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                    return false;
                }
            } else {
                $query = '';
                for ($i=0; $i < count($columnToSelect); $i++) {
                    if ($i==0) {
                        if (count($columnToSelect)==1) {
                            $query = "SELECT ".$columnToSelect[$i]." FROM $tableName";
                            break;
                        } else {
                            $query = "SELECT ".$columnToSelect[$i].", ";
                            continue;
                        }
                    } elseif ($i==(count($columnToSelect))-1) {
                        $query .= $columnToSelect[$i]." FROM $tableName";
                        continue;
                    } 
                    $query .= $columnToSelect[$i].", ";
                }
                $result = $conn->query($query);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $rows[] = $row;
                    }
                    return $rows;
                } else {
                    return 0;
                }
                if (!$result) {
                    echo "Thực thi câu lệnh <pre>$query</pre> thất bại";
                    return false;
                }
            }
        }
    }
    $db = new Database;