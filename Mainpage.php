<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN LÝ PHIM</title>
    <link rel="stylesheet" href="./Mainpage.css">

    <style>
        
    </style>
</head>

<body>
    <div class="grid-container">
        <div class="top-bar">
            <button class="menu-toggle" onclick="toggleMenu()">☰</button>
            <a href="Mainpage.php"><img src="imgs/CGV_Cinemas.svg.png" alt="Logo"/></a>
            <div class="user-info">
            <?php
                if(isset($_SESSION["user"]))
                {?>
                    <span style="color: black;">Xin chào <?php echo $_SESSION["user"];?></span>
                <?php
                }
                ?> 
            <a href="#"><img src="imgs/icon_account.png"/></a>
            </div>
            <br style="clear:both">
        </div>

        <div class="side-menu" id="sideMenu">
            <h2>Menu</h2><a href="#">Trang Chủ</a>
            <a href="#">Quản lý phim</a>
            <a href="#">Quản lý lịch chiếu</a>
            <a href="#">Quản lý phòng chiếu</a>
            <a href="#">Quản lý nhân viên</a>
        </div>

        <script>
            function toggleMenu() {
                document.getElementById('sideMenu').classList.toggle('open');
            }
        </script>
    </div>
    <?php
        require_once "config.php";
        $sql = "select * from phim";
        // Thực thi câu lệnh
        $result = $conn->query($sql);
        $list_phim=[];
        if ($result) {
        // Lấy và chuyển tất cả các bộ dữ liệu sang dạng mảng kết hợp
        $list_phim = $result->fetch_all(MYSQLI_ASSOC);}
        
        /*$id_selected="";
        if(isset($_GET["phim"]))
        {
            $id_selected=$_GET["phim"];
        }*/
    ?>
    <H2>QUẢN LÝ PHIM</H2>
    <div class="timkiem_themmoi">
        <div class="timkiem">
            <form action="" method="post">
                Tên phim: <input class="nhap" list="Tên phim" name="tenphim" placeholder="Nhập từ khóa cần tìm">
                                <datalist id="Tên phim">
                                <?php
                                    foreach($list_phim as $row){
                                        echo "<option value='".$row['ten']."'>";}?>
                                </datalist>
                <input class="btn-timkiem" type="submit" value="Tìm kiếm" name="Timkiem">
                </a>
            </form>
        </div>
        <div>
            <a href="AddFilm.php" class="them_moi">Thêm Phim</a>  
        </div>
        <form action="" method="post">
            <label for="month">Tháng</label>
            <input type="number" min="1" max="12" step="1" value="1" name="month" id="month">
            <input class="btn-timkiem" type="submit" value="Lọc" name="locthang">
        </form>
    </div>
    
    <table class="table-nv">
        <tr> 
            <th>Mã phim</th>
            <th>Tên phim</th>
            <th>Thể loại</th>
            <th>Thời lượng</th>
            <th>Ngày khởi chiếu</th>
            <th>Quốc gia</th>
            <th>Đạo diễn</th>
            <th>Năm sản xuất</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
        <?php
            $sql="select p.ma_phim, p.ten, t.ten_the_loai, p.thoi_luong, p.ngay_khoi_chieu, p.nuoc_san_xuat, p.nam_san_xuat, p.ten_dao_dien, p.mo_ta 
                from phim p 
                join theloaiphim t on p.ma_the_loai = t.ma_the_loai order by p.ma_phim limit 10";
            if(isset($_POST["Timkiem"])){
                $ten_phim = $_POST["tenphim"];
                $sql="select p.ma_phim, p.ten, t.ten_the_loai, p.thoi_luong, p.ngay_khoi_chieu, p.nuoc_san_xuat, p.nam_san_xuat, p.ten_dao_dien, p.mo_ta 
                from phim p 
                join theloaiphim t on p.ma_the_loai = t.ma_the_loai 
                where p.ten LIKE '%$ten_phim%'
                ORDER BY p.ma_phim";}
            if(isset($_POST["locthang"])){
                $thang = $_POST["month"];
                $sql="select p.ma_phim, p.ten, t.ten_the_loai, p.thoi_luong, p.ngay_khoi_chieu, p.nuoc_san_xuat, p.nam_san_xuat, p.ten_dao_dien, p.mo_ta 
                from phim p 
                join theloaiphim t on p.ma_the_loai = t.ma_the_loai
                where month(p.ngay_khoi_chieu)=$thang";
            }

                $result = $conn->query($sql);
                if ($result) {
                $phim = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($phim as $phim){
                    echo "<tr>";
                    echo "<td>".$phim["ma_phim"]."</td>
                    <td>".$phim["ten"]."</td>
                    <td>".$phim["ten_the_loai"]."</td>
                    <td>".$phim["thoi_luong"]."</td>
                    <td>".$phim["ngay_khoi_chieu"]."</td>
                    <td>".$phim["nuoc_san_xuat"]."</td>
                    <td>".$phim["ten_dao_dien"]."</td>
                    <td>".$phim["nam_san_xuat"]."</td>
                    <td style='width: 150px;'>".$phim["mo_ta"]."</td>
                    <td class='hanh-dong'>
                        <a href='./sua.php?ma_phim=".$phim['ma_phim']."'>Sửa</a> |
                        <a href='./xoa.php?ma_phim=".$phim['ma_phim']."' onclick='return checkdelete()'>Xóa</a>
                    </td>";
                    echo " </tr>"; 
                }
                }else {
                    echo "<tr><td colspan='10'>Không tìm thấy phim nào.</td></tr>";
                }
                $conn->close();
        ?>
        <script>
        function checkdelete()
        {
            return confirm('Bạn có chắc chắn muốn xóa phim hay không ')
        }

        </script>
        
    </table>
</body>
</html>