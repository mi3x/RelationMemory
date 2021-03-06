<?php
session_start();
/* DBと接続 */
include "../Setting/access_db.php";

// ログイン処理
// 「ログインボタン」が押されたとき
if(isset($_POST['login'])){
    $user_id = $_POST['id'];
    $user_pw = $_POST['inputPassword'];

    // ユーザアカウントテーブルから一致するid,pwを含むデータを特定
    $sql  = 'SELECT user_id, user_name FROM user WHERE user_id = "' .$user_id. '" AND user_password = "' .$user_pw. '"';
    // dbから得られたログイン情報を格納
    $result = $dbh -> query($sql) -> fetch(PDO::FETCH_ASSOC);
    if($result != null){
        $_SESSION["ID"] = $user_id;
        header("Location: ../Template.html");
        exit;
    }
    $error_message = "※ID、もしくはパスワードが間違っています。<br>　もう一度入力して下さい。";
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>リレメモスタート画面</title>
        <meta charset="UTF8">
        <link rel = "stylesheet" type = "text/css" href = "../Start/Start.css">
    </head>

    <body>
        <div class = "center1">
            <p>・知り合った人の情報を記録</p>
            <p>・豊富な検索機能</p>
            <p>・登録した情報を特定の人と共有</p>
        </div>

        <div class = "center2">
            <form action = "Start.php" method = "POST">
            <dialog>
                ユーザID　
                <input type = "text" name = "id">
                <br>
                <!-- <form> -->
                  パスワード
                    <input type = "password" name = "inputPassword"><br/>
                    <input type = "submit" name = "login" value = "ログイン">
                    <input type = "checkbox" id = "chk" onChange = "toggleInputType(this)" checked>
                    <label for = "chk">
                        パスワードを隠す
                    </label>
                </form>
                <a href = "Secret.html" >忘れた方はこちら<br>
                </a>
                <div class = "button_place">
                    <!--input type = "button" value = "ログイン" onclick = " location.href = '../Template.html'" id = 'login'-->
                    <input type = "button" value = "閉じる" id = "close">
                </div>
            </dialog>
            <input type = "button" value = "今すぐ始める" onclick = " location.href = 'Create_user.php'" id = "start">
            <input type= "button" value = "ログイン" id = "show">
        </div>

        <!-- ダイアログの表示 -->
        <script>
            var dialog = document.querySelector('dialog');
            var btn_show = document.getElementById('show');
            var btn_close = document.getElementById('close');
            btn_show.addEventListener('click', function() {
            dialog.showModal();
            }, false);
            btn_close.addEventListener('click', function() {
            dialog.close();
            }, false);

            function toggleInputType(chk) {
                if (chk.checked) {
                    document.forms[0].inputPassword.type = "password";
                } else {
                    document.forms[0].inputPassword.type = "text";
                }
            }
        </script>

    </body>
</html>
