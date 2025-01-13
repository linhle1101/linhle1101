
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết thông tin Nhân Viên</title>
    <link rel="stylesheet" href="sua.css">
</head>
<body>
<?php
    require_once "config.php";
    if(isset($_GET['ma_phim'])){
        $id= $_GET['ma_phim'];

        $sql ="select * from phim where ma_phim = '$id'";
        
        $result = $conn->query($sql);

        if($result){
            $phim = $result->fetch_assoc();
    ?>
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

<!-- Phần thân -->
<div class="grid-container">
                <div class="top-bar">
                    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
                    <a href="Mainpage.php"><img src="imgs/CGV_Cinemas.svg.png" alt="Logo"/></a>
                    <a href="#" class="imgacc"><img src="imgs/icon_account.png"/></a>
                </div>
                <div class="body">
                <H1>CẬP NHẬT THÔNG TIN PHIM</H1><br>
                <form action="" method="post">
                    <table class="table">
                        <tr>
                            <th><label>Mã phim</label></th>
                            <td><input type="text" value="<?php echo $phim['ma_phim'];?>" disabled></td>
                            <td></td>
                            <th><label>Ngày khởi chiếu</label></th>
                            <td><input type="date" name="ngay_khoi_chieu" value="<?php echo $phim['ngay_khoi_chieu'];?>"></td>
                            <td rowspan="5"> 
                                    
                                    
                                    <p></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Tên phim</label></th>
                            <td><input type="text" name="ten" value="<?php echo $phim['ten'];?>"></td>
                            <td></td>
                            <th><label>Quốc gia</label></th>
                            <td>
                                <input list="Quốc gia" name="nuoc_san_xuat" value="<?php echo $phim['nuoc_san_xuat'];?>">
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

                            $id_selected = $phim["ma_the_loai"];
                            ?>

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
                            <td><input type="text" name="ten_dao_dien" value="<?php echo $phim['ten_dao_dien'];?>"></td>
                        </tr>
                        <tr>
                            <th><label>Thời lượng</label></th>
                            <td><input type="text" name="thoi_luong" value="<?php echo $phim['thoi_luong'];?>"></td>
                            <td></td>
                            <th><label>Năm sản xuất</label></th>
                            <td><input type="number" min="1900" max="2099" step="1" value="<?php echo $phim['nam_san_xuat'];?>" name="nam_san_xuat"></td>
                        </tr>
                        <tr>
                            <th><label>Mô tả</label></th>
                            <td><textarea rows="2" cols="30" name="mo_ta"><?php echo $phim['mo_ta'];?></textarea></td>
                            <td></td>
                            
                        </tr>
                    </table>
                    <div style="float: right;">
                    <img id="preview" src="<?php echo $phim['file_hinhAnh'];?>" alt="Hình ảnh" style="max-width: 200px;"><br>
                                    <label for="file" >Chọn tệp:</label> 
                                    <input type="file" name="file" id="file" accept="image/*" onchange="previewFile()">
                            </div>
                            <br style="clear:both">
                    <div>
                        <input type="submit" value="Cập nhật" name="update">
                    </div>
                    
                    </form>
    </div>
    
        <?php
        }

// Cập nhật dữ liệu
        if(isset($_POST["update"]))
        {
            $ten = $_POST["ten"];
            if ($_POST["file"] == "") {
                $hinh_anh = $phim["file_hinhAnh"];} 
            else {$hinh_anh = $_POST["file"];} 
            $ma_the_loai = $_POST["ma_the_loai"];
            $thoi_luong = $_POST["thoi_luong"];
            $ngay_khoi_chieu = $_POST["ngay_khoi_chieu"];
            $nuoc_san_xuat = $_POST["nuoc_san_xuat"];
            $nam_san_xuat = $_POST["nam_san_xuat"];
            $ten_dao_dien = $_POST["ten_dao_dien"];
            $mo_ta = $_POST["mo_ta"];
            
            
            $sql="UPDATE phim SET ten = '$ten', ma_the_loai = '$ma_the_loai', 
                thoi_luong = '$thoi_luong', ngay_khoi_chieu = '$ngay_khoi_chieu', nuoc_san_xuat = '$nuoc_san_xuat', 
                nam_san_xuat = '$nam_san_xuat', ten_dao_dien = '$ten_dao_dien', mo_ta = '$mo_ta', file_hinhAnh = '$hinh_anh' 
                    WHERE ma_phim= ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $id);
            if ($stmt->execute()) {
                echo "<script>alert('Cật nhập dữ liệu thành công');window.location.href = './Mainpage.php';</script>";
            exit;
            } else {
                echo "Lỗi: " . $stmt->error;
            }
     
        }
    }  
        ?>

<div class="side-menu" id="sideMenu">
            <h2>Menu</h2><a href="#">Trang Chủ</a>
            <a href="#">Quản lý phim</a>
            <a href="#">Quản lý lịch chiếu</a>
            <a href="#">Quản lý phòng chiếu</a>
            <a href="#">Quản lý nhân viên</a>
        </div>
        <script>
            function toggleMenu() 
            {
                document.getElementById('sideMenu').classList.toggle('open');
            }
        </script>
</body>
</html>
