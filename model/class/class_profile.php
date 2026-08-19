<?php
    include "config.php";

    // =============================================== Security check
    if(!isset($_SESSION['session_username'])){
        header('location: login');
        exit();
    }
    // =============================================== Security check

    if(isset($_SESSION['alert'])){
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    if($S_rolestatus == "admin"){
        $SVG = "<svg id='wave' style='transform:rotate(0deg); transition: 0.3s' viewBox='0 0 1440 180' version='1.1' xmlns='http://www.w3.org/2000/svg'><defs><linearGradient id='sw-gradient-0' x1='0' x2='0' y1='1' y2='0'><stop stop-color='darkslateblue' offset='0%'></stop><stop stop-color='cadetblue' offset='100%'></stop></linearGradient></defs><path style='transform:translate(0, 0px); opacity:1' fill='url(#sw-gradient-0)' d='M0,126L26.7,132C53.3,138,107,150,160,138C213.3,126,267,90,320,84C373.3,78,427,102,480,108C533.3,114,587,102,640,108C693.3,114,747,138,800,138C853.3,138,907,114,960,108C1013.3,102,1067,114,1120,99C1173.3,84,1227,42,1280,45C1333.3,48,1387,96,1440,114C1493.3,132,1547,120,1600,99C1653.3,78,1707,48,1760,54C1813.3,60,1867,102,1920,120C1973.3,138,2027,132,2080,114C2133.3,96,2187,66,2240,66C2293.3,66,2347,96,2400,105C2453.3,114,2507,102,2560,87C2613.3,72,2667,54,2720,54C2773.3,54,2827,72,2880,66C2933.3,60,2987,30,3040,33C3093.3,36,3147,72,3200,93C3253.3,114,3307,120,3360,105C3413.3,90,3467,54,3520,57C3573.3,60,3627,102,3680,120C3733.3,138,3787,132,3813,129L3840,126L3840,180L3813.3,180C3786.7,180,3733,180,3680,180C3626.7,180,3573,180,3520,180C3466.7,180,3413,180,3360,180C3306.7,180,3253,180,3200,180C3146.7,180,3093,180,3040,180C2986.7,180,2933,180,2880,180C2826.7,180,2773,180,2720,180C2666.7,180,2613,180,2560,180C2506.7,180,2453,180,2400,180C2346.7,180,2293,180,2240,180C2186.7,180,2133,180,2080,180C2026.7,180,1973,180,1920,180C1866.7,180,1813,180,1760,180C1706.7,180,1653,180,1600,180C1546.7,180,1493,180,1440,180C1386.7,180,1333,180,1280,180C1226.7,180,1173,180,1120,180C1066.7,180,1013,180,960,180C906.7,180,853,180,800,180C746.7,180,693,180,640,180C586.7,180,533,180,480,180C426.7,180,373,180,320,180C266.7,180,213,180,160,180C106.7,180,53,180,27,180L0,180Z'></path></svg>";
    }else if($S_rolestatus == "mahasiswa"){
        $SVG = "<svg id='wave' style='transform:rotate(0deg); transition: 0.3s' viewBox='0 0 1440 180' version='1.1' xmlns='http://www.w3.org/2000/svg'><defs><linearGradient id='sw-gradient-0' x1='0' x2='0' y1='1' y2='0'><stop stop-color='deepskyblue' offset='0%'></stop><stop stop-color='skyblue' offset='100%'></stop></linearGradient></defs><path style='transform:translate(0, 0px); opacity:1' fill='url(#sw-gradient-0)' d='M0,126L26.7,132C53.3,138,107,150,160,138C213.3,126,267,90,320,84C373.3,78,427,102,480,108C533.3,114,587,102,640,108C693.3,114,747,138,800,138C853.3,138,907,114,960,108C1013.3,102,1067,114,1120,99C1173.3,84,1227,42,1280,45C1333.3,48,1387,96,1440,114C1493.3,132,1547,120,1600,99C1653.3,78,1707,48,1760,54C1813.3,60,1867,102,1920,120C1973.3,138,2027,132,2080,114C2133.3,96,2187,66,2240,66C2293.3,66,2347,96,2400,105C2453.3,114,2507,102,2560,87C2613.3,72,2667,54,2720,54C2773.3,54,2827,72,2880,66C2933.3,60,2987,30,3040,33C3093.3,36,3147,72,3200,93C3253.3,114,3307,120,3360,105C3413.3,90,3467,54,3520,57C3573.3,60,3627,102,3680,120C3733.3,138,3787,132,3813,129L3840,126L3840,180L3813.3,180C3786.7,180,3733,180,3680,180C3626.7,180,3573,180,3520,180C3466.7,180,3413,180,3360,180C3306.7,180,3253,180,3200,180C3146.7,180,3093,180,3040,180C2986.7,180,2933,180,2880,180C2826.7,180,2773,180,2720,180C2666.7,180,2613,180,2560,180C2506.7,180,2453,180,2400,180C2346.7,180,2293,180,2240,180C2186.7,180,2133,180,2080,180C2026.7,180,1973,180,1920,180C1866.7,180,1813,180,1760,180C1706.7,180,1653,180,1600,180C1546.7,180,1493,180,1440,180C1386.7,180,1333,180,1280,180C1226.7,180,1173,180,1120,180C1066.7,180,1013,180,960,180C906.7,180,853,180,800,180C746.7,180,693,180,640,180C586.7,180,533,180,480,180C426.7,180,373,180,320,180C266.7,180,213,180,160,180C106.7,180,53,180,27,180L0,180Z'></path></svg>";
    }else if($S_rolestatus == "dosen"){
        $SVG = "<svg id='wave' style='transform:rotate(0deg); transition: 0.3s' viewBox='0 0 1440 180' version='1.1' xmlns='http://www.w3.org/2000/svg'><defs><linearGradient id='sw-gradient-0' x1='0' x2='0' y1='1' y2='0'><stop stop-color='darkblue' offset='0%'></stop><stop stop-color='deepskyblue' offset='50%'></stop></linearGradient></defs><path style='transform:translate(0, 0px); opacity:1' fill='url(#sw-gradient-0)' d='M0,126L26.7,132C53.3,138,107,150,160,138C213.3,126,267,90,320,84C373.3,78,427,102,480,108C533.3,114,587,102,640,108C693.3,114,747,138,800,138C853.3,138,907,114,960,108C1013.3,102,1067,114,1120,99C1173.3,84,1227,42,1280,45C1333.3,48,1387,96,1440,114C1493.3,132,1547,120,1600,99C1653.3,78,1707,48,1760,54C1813.3,60,1867,102,1920,120C1973.3,138,2027,132,2080,114C2133.3,96,2187,66,2240,66C2293.3,66,2347,96,2400,105C2453.3,114,2507,102,2560,87C2613.3,72,2667,54,2720,54C2773.3,54,2827,72,2880,66C2933.3,60,2987,30,3040,33C3093.3,36,3147,72,3200,93C3253.3,114,3307,120,3360,105C3413.3,90,3467,54,3520,57C3573.3,60,3627,102,3680,120C3733.3,138,3787,132,3813,129L3840,126L3840,180L3813.3,180C3786.7,180,3733,180,3680,180C3626.7,180,3573,180,3520,180C3466.7,180,3413,180,3360,180C3306.7,180,3253,180,3200,180C3146.7,180,3093,180,3040,180C2986.7,180,2933,180,2880,180C2826.7,180,2773,180,2720,180C2666.7,180,2613,180,2560,180C2506.7,180,2453,180,2400,180C2346.7,180,2293,180,2240,180C2186.7,180,2133,180,2080,180C2026.7,180,1973,180,1920,180C1866.7,180,1813,180,1760,180C1706.7,180,1653,180,1600,180C1546.7,180,1493,180,1440,180C1386.7,180,1333,180,1280,180C1226.7,180,1173,180,1120,180C1066.7,180,1013,180,960,180C906.7,180,853,180,800,180C746.7,180,693,180,640,180C586.7,180,533,180,480,180C426.7,180,373,180,320,180C266.7,180,213,180,160,180C106.7,180,53,180,27,180L0,180Z'></path></svg>";
    }else if($S_rolestatus == "ketualab"){
        $SVG = "<svg id='wave' style='transform:rotate(0deg); transition: 0.3s' viewBox='0 0 1440 180' version='1.1' xmlns='http://www.w3.org/2000/svg'><defs><linearGradient id='sw-gradient-0' x1='0' x2='0' y1='1' y2='0'><stop stop-color='lightseagreen' offset='0%'></stop><stop stop-color='darkturquoise' offset='50%'></stop></linearGradient></defs><path style='transform:translate(0, 0px); opacity:1' fill='url(#sw-gradient-0)' d='M0,126L26.7,132C53.3,138,107,150,160,138C213.3,126,267,90,320,84C373.3,78,427,102,480,108C533.3,114,587,102,640,108C693.3,114,747,138,800,138C853.3,138,907,114,960,108C1013.3,102,1067,114,1120,99C1173.3,84,1227,42,1280,45C1333.3,48,1387,96,1440,114C1493.3,132,1547,120,1600,99C1653.3,78,1707,48,1760,54C1813.3,60,1867,102,1920,120C1973.3,138,2027,132,2080,114C2133.3,96,2187,66,2240,66C2293.3,66,2347,96,2400,105C2453.3,114,2507,102,2560,87C2613.3,72,2667,54,2720,54C2773.3,54,2827,72,2880,66C2933.3,60,2987,30,3040,33C3093.3,36,3147,72,3200,93C3253.3,114,3307,120,3360,105C3413.3,90,3467,54,3520,57C3573.3,60,3627,102,3680,120C3733.3,138,3787,132,3813,129L3840,126L3840,180L3813.3,180C3786.7,180,3733,180,3680,180C3626.7,180,3573,180,3520,180C3466.7,180,3413,180,3360,180C3306.7,180,3253,180,3200,180C3146.7,180,3093,180,3040,180C2986.7,180,2933,180,2880,180C2826.7,180,2773,180,2720,180C2666.7,180,2613,180,2560,180C2506.7,180,2453,180,2400,180C2346.7,180,2293,180,2240,180C2186.7,180,2133,180,2080,180C2026.7,180,1973,180,1920,180C1866.7,180,1813,180,1760,180C1706.7,180,1653,180,1600,180C1546.7,180,1493,180,1440,180C1386.7,180,1333,180,1280,180C1226.7,180,1173,180,1120,180C1066.7,180,1013,180,960,180C906.7,180,853,180,800,180C746.7,180,693,180,640,180C586.7,180,533,180,480,180C426.7,180,373,180,320,180C266.7,180,213,180,160,180C106.7,180,53,180,27,180L0,180Z'></path></svg>";
    }else if($S_rolestatus == "kooraslab"){
        $SVG = "<svg id='wave' style='transform:rotate(0deg); transition: 0.3s' viewBox='0 0 1440 180' version='1.1' xmlns='http://www.w3.org/2000/svg'><defs><linearGradient id='sw-gradient-0' x1='0' x2='0' y1='1' y2='0'><stop stop-color='brown' offset='0%'></stop><stop stop-color='darkkhaki' offset='35%'></stop></linearGradient></defs><path style='transform:translate(0, 0px); opacity:1' fill='url(#sw-gradient-0)' d='M0,126L26.7,132C53.3,138,107,150,160,138C213.3,126,267,90,320,84C373.3,78,427,102,480,108C533.3,114,587,102,640,108C693.3,114,747,138,800,138C853.3,138,907,114,960,108C1013.3,102,1067,114,1120,99C1173.3,84,1227,42,1280,45C1333.3,48,1387,96,1440,114C1493.3,132,1547,120,1600,99C1653.3,78,1707,48,1760,54C1813.3,60,1867,102,1920,120C1973.3,138,2027,132,2080,114C2133.3,96,2187,66,2240,66C2293.3,66,2347,96,2400,105C2453.3,114,2507,102,2560,87C2613.3,72,2667,54,2720,54C2773.3,54,2827,72,2880,66C2933.3,60,2987,30,3040,33C3093.3,36,3147,72,3200,93C3253.3,114,3307,120,3360,105C3413.3,90,3467,54,3520,57C3573.3,60,3627,102,3680,120C3733.3,138,3787,132,3813,129L3840,126L3840,180L3813.3,180C3786.7,180,3733,180,3680,180C3626.7,180,3573,180,3520,180C3466.7,180,3413,180,3360,180C3306.7,180,3253,180,3200,180C3146.7,180,3093,180,3040,180C2986.7,180,2933,180,2880,180C2826.7,180,2773,180,2720,180C2666.7,180,2613,180,2560,180C2506.7,180,2453,180,2400,180C2346.7,180,2293,180,2240,180C2186.7,180,2133,180,2080,180C2026.7,180,1973,180,1920,180C1866.7,180,1813,180,1760,180C1706.7,180,1653,180,1600,180C1546.7,180,1493,180,1440,180C1386.7,180,1333,180,1280,180C1226.7,180,1173,180,1120,180C1066.7,180,1013,180,960,180C906.7,180,853,180,800,180C746.7,180,693,180,640,180C586.7,180,533,180,480,180C426.7,180,373,180,320,180C266.7,180,213,180,160,180C106.7,180,53,180,27,180L0,180Z'></path></svg>";
    }

    $PROFILE = getuserbyusername($S_username);
    
    if($PROFILE['picture'] == "user"){
        $photopp = $__asset."/profile_img/".$PROFILE['picture'].".png";
    }else{
        $photopp = $PROFILE['picture'];
    }

    if(isset($_POST['updateprofile'])){
        $linkpp = $_POST['inputphotoprofile'];

        if($linkpp != ""){
            if(str_contains($linkpp, "pexels")){  
                $SQL_updatepp = "UPDATE user SET picture = '$linkpp' WHERE username = '$S_username'";
                $updatepp = mysqli_query($db, $SQL_updatepp);

                if($updatepp){
                    $_SESSION['alert'] = $ALERT_updateprofileberhasil;
                    header('location: '.$LINK_profile.'');
                }else{
                    $_SESSION['alert'] = $ALERT_updateprofilegagal;
                    header('location: '.$LINK_profile.'');
                }
            }else{
                $_SESSION['alert'] = $ALERT_updateprofilebukanpexels;
                header('location: '.$LINK_profile.'');
            } 
        }else{
            $_SESSION['alert'] = $ALERT_updateprofilekosong;
            header('location: '.$LINK_profile.'');
        }
    }

    if(isset($_POST['submitprofiletelepon'])){
        $nomertelpon = ltrim($_POST['profiletelepon'], '0');

        if($nomertelpon != ""){
            $SQL_updatenomer = "UPDATE user SET phone = '$nomertelpon' WHERE username = '$S_username'";
            $updatenomer = mysqli_query($db, $SQL_updatenomer);

            if($updatenomer){
                $_SESSION['alert'] = $ALERT_updateprofileberhasil;
                header('location: '.$LINK_profile.'');
            }else{
                $_SESSION['alert'] = $ALERT_updateprofilegagal;
                header('location: '.$LINK_profile.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_updateprofilekosong;
            header('location: '.$LINK_profile.'');
        }
    }
    
    if(isset($_POST['submitprofileemail'])){
        $email = $_POST['profileemail'];

        if($email != ""){
            $SQL_updateemail= "UPDATE user SET email = '$email' WHERE username = '$S_username'";
            $updateemail= mysqli_query($db, $SQL_updateemail);

            if($updateemail){
                $_SESSION['alert'] = $ALERT_updateprofileberhasil;
                header('location: '.$LINK_profile.'');
            }else{
                $_SESSION['alert'] = $ALERT_updateprofilegagal;
                header('location: '.$LINK_profile.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_updateprofilekosong;
            header('location: '.$LINK_profile.'');
        }
    }

    if(isset($_POST['submitalamatdomisili'])){
        $alamat = addslashes($_POST['alamatdomisili']);

        if($alamat != ""){
            $SQL_updatealamat= "UPDATE user SET address = '$alamat' WHERE username = '$S_username'";
            $updatealamat= mysqli_query($db, $SQL_updatealamat);

            if($updatealamat){
                $_SESSION['alert'] = $ALERT_updateprofileberhasil;
                header('location: '.$LINK_profile.'');
            }else{
                $_SESSION['alert'] = $ALERT_updateprofilegagal;
                header('location: '.$LINK_profile.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_updateprofilekosong;
            header('location: '.$LINK_profile.'');
        }
    }

    if(isset($_POST['submitkotadomisili'])){
        $kota = strtoupper($_POST['kotadomisili']);

        if($kota != ""){
            $SQL_updatekota= "UPDATE user SET city = '$kota' WHERE username = '$S_username'";
            $updatekota= mysqli_query($db, $SQL_updatekota);

            if($updatekota){
                $_SESSION['alert'] = $ALERT_updateprofileberhasil;
                header('location: '.$LINK_profile.'');
            }else{
                $_SESSION['alert'] = $ALERT_updateprofilegagal;
                header('location: '.$LINK_profile.'');
            }
        }else{
            $_SESSION['alert'] = $ALERT_updateprofilekosong;
            header('location: '.$LINK_profile.'');
        }
    }

    if(isset($_POST['submitgantipassword'])){
        $passlama = $_POST['inputpasswordlama'];
        $passbaru = $_POST['inputpasswordbaru'];
        $passkonfirm = $_POST['inputkonfirmasipasswordbaru'];

        $stmt_getpasscek = mysqli_prepare($db, "SELECT password FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt_getpasscek, "s", $S_username);
        mysqli_stmt_execute($stmt_getpasscek);
        $resultpasscek = mysqli_fetch_array(mysqli_stmt_get_result($stmt_getpasscek));

        if(($passlama != "") && ($passbaru != "") && ($passkonfirm != "")){
            if(!password_verify($passlama, $resultpasscek['password'])){
                $_SESSION['alert'] = $ALERT_passwordlamatidaksesuai;
                header('location: '.$LINK_profile.'');
            }else{
                if($passbaru != $passkonfirm){
                    $_SESSION['alert'] = $ALERT_passwordbarutidaksesuai;
                    header('location: '.$LINK_profile.'');
                }else{
                    $new_pass_hash = password_hash($passbaru, PASSWORD_BCRYPT);
                    $stmt_updatepassword = mysqli_prepare($db, "UPDATE user SET password = ? WHERE username = ?");
                    mysqli_stmt_bind_param($stmt_updatepassword, "ss", $new_pass_hash, $S_username);
                    $updatepassword = mysqli_stmt_execute($stmt_updatepassword);

                    if($updatepassword){
                        $_SESSION['alert'] = $ALERT_passwordupdateberhasil;
                        header('location: '.$LINK_profile.'');
                    }else{
                        $_SESSION['alert'] = $ALERT_passwordupdategagal;
                        header('location: '.$LINK_profile.'');
                    }
                    
                }
            }
        }else{
            $_SESSION['alert'] = $ALERT_passwordupdatekosong;
            header('location: '.$LINK_profile.'');
        }
    }

    $quotes = [
        "If you’re offered a seat on a rocket ship, don’t ask what seat! Just get on. - Sheryl Sandberg"
        ,
        
        "First, have a definite, clear practical ideal; a goal, an objective. Second, have the necessary means to achieve your ends; wisdom, money, materials, and methods. Third, adjust all your means to that end. - Aristotle"
        ,
        
        "If the wind will not serve, take to the oars. - Latin Proverb"
        ,
        
        "You can’t fall if you don’t climb.  But there’s no joy in living your whole life on the ground. - Unknown"
        ,
        
        "We must believe that we are gifted for something, and that this thing, at whatever cost, must be attained. - Marie Curie"
        ,
        
        "Too many of us are not living our dreams because we are living our fears. - Les Brown"
        ,
        
        "Challenges are what make life interesting and overcoming them is what makes life meaningful. - Joshua J. Marine"
        ,
        
        "If you want to lift yourself up, lift up someone else. - Booker T. Washington"
        ,
        
        "I have been impressed with the urgency of doing. Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci"
        ,
        
        "Limitations live only in our minds.  But if we use our imaginations, our possibilities become limitless. - Jamie Paolinetti"
        ,
        
        "You take your life in your own hands, and what happens? A terrible thing, no one to blame. - Erica Jong"
        ,
        
        "What’s money? A man is a success if he gets up in the morning and goes to bed at night and in between does what he wants to do. - Bob Dylan"
        ,
        
        "I didn’t fail the test. I just found 100 ways to do it wrong. - Benjamin Franklin"
        ,
        
        "In order to succeed, your desire for success should be greater than your fear of failure. - Bill Cosby"
        ,
        
        "A person who never made a mistake never tried anything new. - Albert Einstein"
        ,
        
        "The person who says it cannot be done should not interrupt the person who is doing it. - Chinese Proverb"
        ,
        
        "There are no traffic jams along the extra mile. - Roger Staubach"
        ,
        
        "It is never too late to be what you might have been. - George Eliot"
        ,
        
        "You become what you believe. - Oprah Winfrey"
        ,
        
        "I would rather die of passion than of boredom. - Vincent van Gogh"
        ,
        
        "A truly rich man is one whose children run into his arms when his hands are empty. - Unknown"
        ,
        
        "It is not what you do for your children, but what you have taught them to do for themselves, that will make them successful human beings. - Ann Landers"
        ,
        
        "If you want your children to turn out well, spend twice as much time with them, and half as much money. - Abigail Van Buren"
        ,
        
        "Build your own dreams, or someone else will hire you to build theirs. - Farrah Gray"
        ,
        
        "The battles that count aren’t the ones for gold medals. The struggles within yourself–the invisible battles inside all of us–that’s where it’s at. - Jesse Owens"
        ,
        
        "Education costs money.  But then so does ignorance. - Sir Claus Moser"
        ,
        
        "I have learned over the years that when one’s mind is made up, this diminishes fear. - Rosa Parks"
        ,
        
        "It does not matter how slowly you go as long as you do not stop. - Confucius"
        ,
        
        "If you look at what you have in life, you’ll always have more. If you look at what you don’t have in life, you’ll never have enough. - Oprah Winfrey"
        ,
        
        "Remember that not getting what you want is sometimes a wonderful stroke of luck. - Dalai Lama"
        ,
        
        "You can’t use up creativity.  - The more you use, the more you have. Maya Angelou"
        ,
        
        "Dream big and dare to fail. - Norman Vaughan"
        ,
        
        "Our lives begin to end the day we become silent about things that matter. - Martin Luther King Jr."
        ,
        
        "Do what you can, where you are, with what you have. - Teddy Roosevelt"
        ,
        
        "If you do what you’ve always done, you’ll get what you’ve always gotten. - Tony Robbins"
        ,
        
        "Dreaming, after all, is a form of planning. - Gloria Steinem"
        ,
        
        "It’s your place in the world; it’s your life. Go on and do all you can with it, and make it the life you want to live. - Mae Jemison"
        ,
        
        "You may be disappointed if you fail, but you are doomed if you don’t try. - Beverly Sills"
        ,
        
        "Remember no one can make you feel inferior without your consent. - Eleanor Roosevelt"
        ,
        
        "Life is what we make it, always has been, always will be. - Grandma Moses"
        ,
        
        "The question isn’t who is going to let me; it’s who is going to stop me. - Ayn Rand"
        ,
        
        "When everything seems to be going against you, remember that the airplane takes off against the wind, not with it. - Henry Ford"
        ,
        
        "It’s not the years in your life that count. It’s the life in your years. - Abraham Lincoln"
        ,
        
        "Change your thoughts and you change your world. - Norman Vincent Peale"
        ,
        
        "Either write something worth reading or do something worth writing. - Benjamin Franklin"
        ,
        
        "Nothing is impossible, the word itself says, “I’m possible!” - Audrey Hepburn"
        ,
        
        "The only way to do great work is to love what you do. - Steve Jobs"
        ,
        
        "If you can dream it, you can achieve it. - Zig Ziglar"
    ];