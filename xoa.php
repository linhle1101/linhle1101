<?php
    require_once "config.php";
    if(isset($_GET['ma_phim'])){
        $id= $_GET['ma_phim'];

        $sql ="delete from phim 
                        where ma_phim='$id'";
        
        $result = $conn->query($sql);

        if($result)
        {
            echo "<script>alert('Xóa phim thành công');window.location.href = './Main page.php';</script>";

        }
        else
        {
            echo "Xóa phim thất bại";

        }
    }
    ?>