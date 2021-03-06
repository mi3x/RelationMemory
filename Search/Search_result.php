<?php
    session_start();
    // DBと接続
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'rmdb');
    define('DB_USER', 'wolf');
    define('DB_PASSWORD', 'password');
    try {
         $dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, $options);
         $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
         echo $e->getMessage();
         exit;
    }
    
    $id = $_SESSION['id'];
    $manage_id = $_SESSION['manage_id'];
    
    /* タグが押されたかどうかの判断。押された場合そのタグのidが格納される */
    if(!empty($_POST['Tag'])){
        $tag = $_POST['Tag'];
        $sql = 'SELECT surname, name, tag_id, image FROM info_a WHERE user_id = "' .$id.'" AND manage_id = "' .$manage_id. '" AND tag_id = "' .$tag. '"';
    }else{
        $sql = 'SELECT surname, name, tag_id, image FROM info_a WHERE user_id = "' .$id.'" AND manage_id = "' .$manage_id. '"';
    }
    
    $MI_for_db = $dbh -> query($sql) -> fetchall(PDO::FETCH_ASSOC);
    foreach($MI_for_db as $MI){
        $MI_surname[] = $MI['surname'];
        $MI_name[] = $MI['name'];
        $MI_tag[] = $MI['tag_id'];
        $MI_image[] = $MI['image'];
        
        //$MI_array = count($MI_for_db); // ユーザがもつ管理情報の数を格納
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>メイン画面</title>
        <link rel="stylesheet" type="text/css" href="Main.css">
    </head>

    <body>
        <form action ='Search_result.php' method='post'>
        <!-- 管理情報を表示 -->
    	<?php for($i = 0; $i < count($MI_for_db); $i++):?>
            <span class ="container">
                <div class="main">
                    <image src=<?php $MI_image[$i];?>, class="image">
                    <button class="button" type="submit" onclick="location.href='Reading.html'">
                    <?php
                        //名前の表示
                        echo $MI_surname[$i] . $MI_name[$i];
                    ?>
                    </button>
                </div>
            </span>    
        <?php endfor?>
		
		<!-- 管理情報追加ボタン -->
        <button class="create" onclick="location.href='/MIPage/Create_mi.html'">
              <img src="plus.png" class="plus">
    	</button>
		
		<!-- タグの表示部分 -->
		<?php
		
		/* タグのID(tag_id)と, タグの名前(tag_name)をとってくる */
		$sql = 'SELECT tag_name, tag_id FROM tag WHERE user_id = "' .$id. '"';
		$MI_tag_from_tag = $dbh -> query($sql) -> fetchall(PDO::FETCH_ASSOC);
		
	    foreach($MI_tag_from_tag as $row){
			$MI_tag_id[] = $row['tag_id'];
			$MI_tag_name[] = $row['tag_name'];
		}
       
		?>
        <ul class="tag">
            <li id="tag1">
                <label>
                <input type="radio" name="Tag" style="display:none" onclick="location.href='Search_result.php'">
        			<span>
        			    すべて
        			</span>
        		</label>
        	</li>
        	
        	<!-- 全て以外のタグ -->
            <?php for($i = 0; $i < count($MI_tag_name); $i++): ?>
        	<li id="alltag">
        	    <label>
        	    <input type="submit" style="display:none" name="Tag" value=<?php echo $MI_tag_id[$i]?>>
            	    <span>
            		    <?php echo $MI_tag_name[$i];?>
            		</span>
        		</label>
        	</li>
        	<?php endfor ?>
        </ul>
        </form>
    </body>
</html>
