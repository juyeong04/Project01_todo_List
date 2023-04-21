<?php
define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/Project/src/" );
define( "URL_DB", SRC_ROOT."common/db_common.php" );
define( "URL_HEADER", SRC_ROOT."header_to_do_list.php" );
define( "PROFILE", SRC_ROOT."profile_to_do_list.php" );
define( "FOOTER", SRC_ROOT."footer_to_do_list.php");
include_once( URL_DB ); // db_common.php 불러옴

$http_method = $_SERVER["REQUEST_METHOD"];

if($http_method === "GET") // GET값 받은거
{
  $list_no = 1; 
  if( array_key_exists( "list_no", $_GET ) )
  {
    $list_no = $_GET["list_no"];
  }
  $result_info = select_list_no( $list_no );
}
else
{
  $arr_post = $_POST; // POST값 보낼거
  $arr_info =
    array(
      "list_title"             => $arr_post["list_title"]
        ,"list_memo"           => $arr_post["list_memo"]
        ,"list_comp_flg"       => $arr_post["list_comp_flg"]
        ,"list_start_time"     => $arr_post["list_start_time"]
        ,"list_start_minute"   => $arr_post["list_start_minute"]
        ,"list_end_time"       => $arr_post["list_end_time"]
        ,"list_end_minute"     => $arr_post["list_end_minute"]
        ,"list_no"             => $arr_post["list_no"]
    );
  
  $result_cnt = update_list( $arr_info );
  header("Location: detail_to_do_list.php?list_no=".$arr_post["list_no"]); // 수정 완료 후 해당 게시글 번호의 detail 페이지로 넘어가기
  exit();
}


?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>리스트 수정 페이지</title>
  <link rel="stylesheet" href="./common/css_common.css">
  <link rel="stylesheet" href="./update_to_do_list.css">
</head>
<body>
  <div class="con">
    <!-- 헤더 -->
    <?php include_once( URL_HEADER ); ?>
    <br>
    <?php include_once( PROFILE ) ?>
    <div class="con1">
      <form action="" method="post">
        <!-- hidden 게시글 번호 -->
        <input type="hidden" name="list_no" value="<?php echo $result_info["list_no"]?>"> <!-- list_no 화면에 표시할 필요는 없지만 해당 번호의 정보를 가져와야함으로 hidden을 사용해줌 -->
        <div class="update_title">
          <h2>리스트 수정</h2>
        </div>
        <div class="update_list_ti">
          <!-- 제목 -->
          <label for="title">제목 </label>
          <input type="text" name="list_title" id="title" value="<?php echo $result_info["list_title"]?>" required placeholder="제목" autofocus>
        </div>
        <div class="update_time">
          <!-- 시작 시간 -->
          <label for="start_time">시작 시간</label>
          <input  type="number" name="list_start_time" id="start_time" min=00 max=23 value="<?php echo $result_info['list_start_time']?>"> :
          <input  type="number" name="list_start_minute" id="start_min" min=00 max=59 value="<?php echo $result_info['list_start_minute']?>">
          <!-- 종료 시간 -->
          <label for="end_time">종료 시간</label>
          <input type="number" name="list_end_time" id="end_time" min=00 max=23 value="<?php echo $result_info['list_end_time']?>"> :
          <input type="number" name="list_end_minute" id="end_min" min=00 max=59 value="<?php echo $result_info['list_end_minute']?>">
        </div>
        <div class="update_memo">
          <!-- 메모 칸 CSS에서 resize:none 해주기! -->
          <label for="memo">메모 :</label>
          <textarea name="list_memo" id="memo" cols="30" rows="10" placeholder="메모" ><?php echo $result_info["list_memo"]?></textarea>
        </div>
        <div class="update_radio">
          <!-- 라디오 버튼 -->
          <input type="radio" name="list_comp_flg" id="done" value=1 <?php if($result_info["list_comp_flg"] === "1") { echo "checked"; }?>>
          <label for= "done">완료</label>
          <input type="radio" name="list_comp_flg" id="yet" value=0  <?php if($result_info["list_comp_flg"] === "0") { echo "checked"; }?>>
          <label for="yet">미완료</label>
        </div>
        <div class="update_buttons">
          <button type="submit">수정</button>
          <a href="detail_to_do_list.php?list_no=<?php echo $result_info["list_no"]?>" class="canc_button">취소</a>
          <a href="delete_to_do_list.php?list_no=<?php echo $result_info["list_no"]?>" class="del_button">삭제</a>
        </div>
      </form>
    </div>
  </div>
  <?php include_once( FOOTER ); ?>
</body>
</html>