<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>login</title>
        <link rel="stylesheet" href="./Dangnhap.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    </head>
    <body>
    
        <div class="wrapper">
            <form action="" method="post">
                <h1>ĐĂNG NHẬP</h1>
                <div class="input-box">
                    <input type="text" name="user" placeholder="Tên người dùng" required>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="pass" placeholder="Mật khẩu" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="remember-forgot">
                    <label><input type="checkbox">Nhớ mật khẩu</label>
                    <a href="#">Quên mật khẩu</a>
                </div>

                <input type="submit" class="btn" name="submit" value="Đăng nhập">
                <?php if (isset($error) && !empty($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>
            </form>
        </div>
        <br>
        <?php
            if(isset($_POST["submit"]))
            {
                $user=$_POST["user"];
                $pass=$_POST["pass"];

                if(!empty($user)&&!empty($pass))
                {
                    require_once "config.php";
                    $sql = "select * from taikhoan_nv where tenDangNhap = ? and matKhau = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss",$user, $pass);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if($result->num_rows>0)
                    {
                        $data = $result->fetch_assoc();
                        $_SESSION["user"] = $data["tenDangNhap"];
                        echo "Đăng nhập thành công";
                        header("Location:Mainpage.php");
                    }
                    else
                    {
                        $error = "Đăng nhập không thành công";
                    }
                }
                else
                {
                    echo "Vui lòng nhập thông tin đầy đủ!";
                }
            }
        ?>
    </body>
</html>