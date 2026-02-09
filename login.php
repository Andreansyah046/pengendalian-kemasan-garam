<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="asset/css/login2.css">
    <link rel="stylesheet" type="text/css" href="asset/plugin/font-icon/css/fontawesome-all.min.css">
</head>
<style>
    #password{
        width: 85%;
    }
    #toggle-password{
        height: 38px;
        width: 37px;
        border: 1px solid #ddd;
        cursor: pointer;
        border-radius: 5px;
    }
</style>
<body>
<div id="login">
    <img src="asset/image/LOGO-CV-MEDIA.png" id="logo-login">
    <div class="alert alert-red text-center" style="display:none;" id="alert"><i class="fa fa-info-circle fa-lg"></i><p id="value">sdasdasd</p></div>
    <div id="panel-login">
        <form id="formlogin" method="POST" action="ceklogin.php">
            <div class="group-input">
                <label for="username">Username :</label>
                <input type="text" class="form-custom" required autocomplete="off" placeholder="Username" id="username" name="username" >
            </div>
            <div class="group-input">
                <label for="password">Password :</label>
                <input type="password" class="form-custom" required autocomplete="off" placeholder="Password" id="password" name="password">
                <button class="btn btn-outline-secondary" type="button" id="toggle-password">👁️</button>
            </div>
            <button class="btn btn-green btn-full"><i class="fa fa-arrow-alt-circle-right text-white"></i> Login</button>
        </form>
    </div>
</div>
<!-- <img src="asset/image/top-image.svg" id="hiasan"><br> -->
</body>

<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<?php
    if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    echo "<script>
        Swal.fire({
            icon: '{$alert['type']}',
            title: '{$alert['message']}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>";
    unset($_SESSION['alert']); // Hapus agar tidak muncul terus
}
?>
<script>
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('toggle-password');

    togglePasswordButton.addEventListener('click', () => {
        // Toggle the input type between password and text
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        // Change the button icon accordingly
        togglePasswordButton.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>
<script src="asset/js/jquery.js" type="text/javascript"></script>
</html>