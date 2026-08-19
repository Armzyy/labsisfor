<?php
include "config.php";

global $arrayuserdatabyusername, $ALERT_inputloginkosong, $ALERT_inputloginusernamesalah, $ALERT_inputloginpasswordsalah;

session_start();

if (isset($_SESSION['alert'])) {
    $alert =  $_SESSION['alert'];
    unset($_SESSION['alert']);
}

// input cookie & create session
if (isset($_COOKIE['cookie_username'])) {
    $cookie_username = $_COOKIE['cookie_username'];
    $cookie_password = $_COOKIE['cookie_password'];

    $stmt_cookie = mysqli_prepare($db, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt_cookie, "s", $cookie_username);
    mysqli_stmt_execute($stmt_cookie);
    $resultlogincookie = mysqli_fetch_array(mysqli_stmt_get_result($stmt_cookie));

    if ($resultlogincookie && $resultlogincookie['password'] == $cookie_password) {
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_password'] = $cookie_password;
        $_SESSION['session_role'] = $resultlogincookie['role'];
    }
}

// redirect by role
if (isset($_SESSION['session_username'])) {

    if ($_SESSION['session_role'] == "admin") {
        header('location: admin?page=home');
    } elseif ($_SESSION['session_role'] == "ketualab") {
        header('location: ketualab?page=home');
    } elseif ($_SESSION['session_role'] == "dosen") {
        header('location: dosen?page=home');
    } elseif ($_SESSION['session_role'] == "kooraslab") {
        header('location: kooraslab?page=home');
    } else {
        header('location: mahasiswa?page=home');
    }

    exit();
}

if (isset($_POST['login'])) {
    $usernamelogin = $_POST['inputid'];
    $passwordlogin = $_POST['inputpassword'];

    // SQL Get user data by username login using prepared statement
    $stmt_login = mysqli_prepare($db, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt_login, "s", $usernamelogin);
    mysqli_stmt_execute($stmt_login);
    $arrayuserdatabyusername = mysqli_fetch_array(mysqli_stmt_get_result($stmt_login));

    if ($usernamelogin == '' or $passwordlogin == '') {
        $_SESSION['alert'] = $ALERT_inputloginkosong;
        header('location: index');
    } else {
        if (empty($arrayuserdatabyusername['username'])) {
            $_SESSION['alert'] = $ALERT_inputloginusernamesalah;
            header('location: index');
        } elseif (!password_verify($passwordlogin, $arrayuserdatabyusername['password'])) {
            // Fallback: Cek apakah password di database masih menggunakan hash SHA-512 lama
            $enc_passlogin = hash_init('sha512');
            hash_update($enc_passlogin, $passwordlogin);
            $legacy_hash = hash_final($enc_passlogin);

            if ($arrayuserdatabyusername['password'] === $legacy_hash) {
                // Auto-migrate hash SHA-512 lama ke Bcrypt baru di database
                $new_bcrypt_hash = password_hash($passwordlogin, PASSWORD_BCRYPT);
                $stmt_rehash = mysqli_prepare($db, "UPDATE user SET password = ? WHERE username = ?");
                mysqli_stmt_bind_param($stmt_rehash, "ss", $new_bcrypt_hash, $usernamelogin);
                mysqli_stmt_execute($stmt_rehash);
                $arrayuserdatabyusername['password'] = $new_bcrypt_hash;
            } else {
                $_SESSION['alert'] = $ALERT_inputloginpasswordsalah;
                header('location: index');
            }
        }
    }

    if (empty($_SESSION['alert'])) {
        $_SESSION['session_username'] = $usernamelogin;
        $_SESSION['session_password'] = $arrayuserdatabyusername['password'];
        $_SESSION['session_role'] = $arrayuserdatabyusername['role'];

        $cookie_name = 'cookie_username';
        $cookie_value = $usernamelogin;
        $cookie_time = time() + (60 * 1);
        setcookie($cookie_name, $cookie_value, $cookie_time, "/");

        $cookie_name = 'cookie_password';
        $cookie_value = $arrayuserdatabyusername['password'];
        $cookie_time = time() + (60 * 1);
        setcookie($cookie_name, $cookie_value, $cookie_time, "/");

        $cookie_name = 'cookie_role';
        $cookie_value = $arrayuserdatabyusername['role'];
        $cookie_time = time() + (60 * 1);
        setcookie($cookie_name, $cookie_value, $cookie_time, "/");

        if ($_SESSION['session_role'] == "admin") {
            header('location: admin?page=home');
        } elseif ($_SESSION['session_role'] == "ketualab") {
            header('location: ketualab?page=home');
        } elseif ($_SESSION['session_role'] == "dosen") {
            header('location: dosen?page=home');
        } elseif ($_SESSION['session_role'] == "kooraslab" || $_SESSION['session_role'] == "aslab") {
            header('location: kooraslab?page=home');
        } else {
            header('location: mahasiswa?page=home');
        }
    }
}
