<!DOCTYPE html>
<html lang="vi"> 
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Film Management</title>
        <link rel="stylesheet" href="./AddFilm.css"/>
    </head>
    <body>

    
    <script> 
    function previewFile() { var preview = document.getElementById('preview'); 
    var file = document.getElementById('file').files[0]; 
    var reader = new FileReader(); 

    reader.addEventListener('load', function () { 
        preview.src = reader.result; 
    }, false);

        if (file) { 
            reader.readAsDataURL(file); 
        } 
    } 
    </script>


        <div class="grid-container">
                <div class="top-bar">
                    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
                    <a href="Mainpage.php"><img src="imgs/CGV_Cinemas.svg.png" alt="Logo"/></a>
                    <a href="#" class="imgacc"><img src="imgs/icon_account.png"/></a>
                </div>
                <div class="body">
                    <h1>QUẢN LÝ PHIM</h1>
                    <form action="" method="post"><table class="table">
                        <tr>
                            <th><label>Mã phim</label></th>
                            <td><input type="text" disabled></td>
                            <td></td>
                            <th><label>Ngày khởi chiếu</label></th>
                            <td><input type="date" name="ngay_khoi_chieu"></td>
                            <td rowspan="5"> 
                                    
                                    <img id="preview" src="" alt="Hình ảnh" style="max-width: 200px;"><br>
                                    <label for="file" >Chọn tệp:</label> 
                                    <input type="file" name="file" id="file" accept="image/*" onchange="previewFile()"><br>
                                    <p></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Tên phim</label></th>
                            <td><input type="text" name="ten"></td>
                            <td></td>
                            <th><label>Quốc gia</label></th>
                            <td>
                                <input list="Quốc gia" name="nuoc_san_xuat">
                                <datalist id="Quốc gia">
                                    <option value="Việt Nam">
                                    <option value="Trung Quốc">
                                    <option value="Thái Lan">
                                    <option value="Hàn Quốc">
                                    <option value="Nhật Bản">
                                    <option value="Mỹ">
                                    <option value="Nga">
                                    <option value="Ấn Độ">
                                </datalist>
                            </td>
                        </tr>
                        <?php
                            require_once "config.php";
                            $sql="SELECT * FROM theloaiphim";
                            $result = $conn->query($sql);
                            $list_the_loai=[];
                            if ($result) {
                            
                                $list_the_loai = $result->fetch_all(MYSQLI_ASSOC);
                            }

                            $id_selected ="";
                            if(isset($_GET["ma_the_loai"]))
                            {
                                $id_selected = $_GET["ma_the_loai"];
                            }?>

                        <tr>
                            <th><label>Thể loại</label></th>
                            <td>
                            <select name = "ma_the_loai">
                            <?php
                                foreach($list_the_loai as $row){
                                    $attr="";
                                    if($id_selected==$row["ma_the_loai"])
                                    {
                                        $attr="selected";
                                    }
                            ?>
                            <option value ="<?php echo $row['ma_the_loai']?>" <?php echo $attr;?>><?php echo $row['ten_the_loai'];?></option>
                            <?php 
                                }
                            ?>
                            </td>
                            <td></td>
                            <th><label>Đạo diễn</label></th>
                            <td><input type="text" name="ten_dao_dien"></td>
                        </tr>
                        <tr>
                            <th><label>Thời lượng</label></th>
                            <td><input type="text" name="thoi_luong"></td>
                            <td></td>
                            <th><label>Năm sản xuất</label></th>
                            <td><input type="number" min="1900" max="2099" step="1" value="2025" name="nam_san_xuat"></td>
                        </tr>
                        <tr>
                            <th><label>Mô tả</label></th>
                            <td><textarea rows="2" cols="30" name="mo_ta"></textarea></td>
                            <td></td>
                            
                        </tr>
                    </table>
                    <div>
                        <input type="submit" value="Thêm" name="add">
                    </div>
                    
                    </form>
                </div>
                <div class="side-menu" id="sideMenu">
                    <h2>Menu</h2>
                    <a href="#">Trang Chủ</a>
                    <a href="#">Quản lý phim</a>
                    <a href="#">Quản lý lịch chiếu</a>
                    <a href="#">Quản lý phòng chiếu</a>
                    <a href="#">Quản lý phân quyền</a>
                </div>

                <script>
                    function toggleMenu() {
                        document.getElementById('sideMenu').classList.toggle('open');
                    }
                </script>
        </div>

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy thông tin từ form
            $ten = $_POST["ten"];
            $ma_the_loai = $_POST["ma_the_loai"];
            $thoi_luong = $_POST["thoi_luong"];
            $ngay_khoi_chieu = $_POST["ngay_khoi_chieu"];
            $nuoc_san_xuat = $_POST["nuoc_san_xuat"];
            $nam_san_xuat = $_POST["nam_san_xuat"];
            $ten_dao_dien = $_POST["ten_dao_dien"];
            $mo_ta = $_POST["mo_ta"];
            $hinh_anh = $_POST["file"];
            // Tìm mã phim lớn nhất hiện tại
            $sql = "SELECT ma_phim FROM phim ORDER BY ma_phim DESC LIMIT 1";
            $result = $conn->query($sql);
        
            $new_ma_phim = "P0001"; // Mã mặc định nếu chưa có phim nào
        
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $last_ma_phim = $row["ma_phim"];
                $num = intval(substr($last_ma_phim, 1)) + 1; // Cắt bỏ ký tự 'P' và tăng số
                $new_ma_phim = "P" . str_pad($num, 2, "0", STR_PAD_LEFT); // Tạo mã mới, ví dụ: P0002
            }
        // Thêm phim mới
        $sql = "INSERT INTO phim (ma_phim, ten, ma_the_loai, thoi_luong, ngay_khoi_chieu, nuoc_san_xuat, nam_san_xuat, ten_dao_dien, mo_ta, file_hinhAnh) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $new_ma_phim, $ten, $ma_the_loai, $thoi_luong, $ngay_khoi_chieu, $nuoc_san_xuat, $nam_san_xuat, $ten_dao_dien, $mo_ta, $hinh_anh);
        if ($stmt->execute()) {
            echo "Thêm phim thành công!";
        } else {
            echo "Lỗi: " . $stmt->error;
        }
        }
        ?>
    </body>
</html>