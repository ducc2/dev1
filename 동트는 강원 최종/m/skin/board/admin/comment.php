<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>



<!-- 댓글 쓰기 시작 -->
<div id="comment_area" style="<?=$board_info[all_width]?>">
	<div id="comment_list">
		
		<table class="board_list-tb">
		<caption><?=$sh_title?> 목록</caption>
		<thead>
		<tr>
			<th scope="col">이름</th>
			<th scope="col">내용</th>
			<th scope="col">등록일</th>
		</tr>
		</thead>
		<tbody>

		<!-- 리스트 루프 시작 -->
		<?
		for($i=0;$i<sizeof($comment);$i++){
			$comments			= $comment[$i];
			$comments[idx]		= $idx;
			$bg				= 'bg'.($i%2);
			?>

		<tr class="<?=$bg?>">
			<td class="td_small"><?=$comments[name]?></td>
			<td class="td_large80"><div class="comment_content"><?=nl2br($comments[content])?></div></td>
			<td class="td_small"><?=substr($comments[datetime], 0, 16)?></td>
		</tr>		
		<?
			$idx--;
		}?>
		<!-- 리스트 루프 끝 -->

		</tbody>
		</table>		
		<div class="list_bottom_center">
			<nav class="pg_wrap"><span class="pg"><?=$linkpage?></span></nav>			
		</div>	
	</div>




    <form id="fregisterform" name="fregisterform" action="./board_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" target="ifm_proc">
    <input type="hidden" name="state" value="comment">
    <input type="hidden" name="referer" value="<?=$referer?>">
    <input type="hidden" name="board_id" value="<?=$board_id?>">
    <input type="hidden" name="board_no" value="<?=$no?>">
    <input type="hidden" name="cur_comment" value="<?=$cur_comment?>">
	<div class="form_div">
		<div class="location_title">댓글(comment)</div>
		<div><span style="color: #FF3366;"> * </span>표시가 있는 부분은 필수 입력 사항입니다.</div>

        <table class="person-tb">
        <caption><?=$sh_title?></caption>
        <tbody>
        <tr>
            <th scope="row"><label for="name">이름</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="name" name="name" value="" required class="input_box"> 
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="password">비밀번호</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="password" id="password" name="password" value="" required class="input_box"> 
            </td>
        </tr> 
		<tr>
			<th scope="row"><label for="options">비밀글</label></th>
			<td>
				<input type="checkbox" name="options" id="options" value="secret"> 비밀글
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="content">내용</label><span style="color: #FF3366;"> * </span></th>
			<td>
				<span class="sound_only">웹에디터 시작</span>
				<TEXTAREA name="content" id="content" class="smarteditor2" style="width:99%;height:200px;"></TEXTAREA>
			</td>
		</tr>
        </tbody>
        </table>
    </div>
    <div id="btn_confirm">
        <input type="submit" value="댓글등록" id="btn_submit" class="button">
    </div>
    </form>
	<iframe name="ifm_proc" id="ifm_proc" src="" frameborder="0" scrolling="no" style="display:none;"></iframe>


    <script>
    // submit 폼체크
    function fregisterform_submit(f){
		if (f.name.value.length < 1) {
			alert("이름을 입력해 주세요.");
			f.name.focus();
			return false;
		}    		
			
		var form		= document.getElementById("fregisterform");
		form.action		= './board_proc.php';
		form.target		= "ifm_proc";
		form.method		= 'post';
		form.submit();

        return true;
    }
    </script>
</div>
<!-- 댓글 쓰기 끝 -->
