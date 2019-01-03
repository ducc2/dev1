<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<script type="text/javascript">
	//우편번호
		function openPostcode(zipcode, addr, addr_det) {
			new daum.Postcode({
				oncomplete: function(data) {
				 /*	// 기존 사용소스
					// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
					// 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
					document.getElementById('zipcode1').value = data.postcode1;
					document.getElementById('zipcode2').value = data.postcode2;
					//document.getElementById('addr1').value = data.address;

					//전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
					//아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
					var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
					document.getElementById('addr1').value = addr;

					document.getElementById('addr2').focus();
				 */

					// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
					
					// 각 주소의 노출 규칙에 따라 주소를 조합한다.
					// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
					var fullAddr = ''; // 최종 주소 변수
					var extraAddr = ''; // 조합형 주소 변수

					// 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
					if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
						fullAddr = data.roadAddress;

					} else { // 사용자가 지번 주소를 선택했을 경우(J)
						fullAddr = data.jibunAddress;
					}

					// 사용자가 선택한 주소가 도로명 타입일때 조합한다.
					if(data.userSelectedType === 'R'){
						//법정동명이 있을 경우 추가한다.
						if(data.bname !== ''){
							extraAddr += data.bname;
						}
						// 건물명이 있을 경우 추가한다.
						if(data.buildingName !== ''){
							extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
						}
						// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
						fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
					}

					// 우편번호와 주소 정보를 해당 필드에 넣는다.
					//document.getElementById('zipcode1').value = data.postcode1;	//6자리 우편번호 사용(3자리씩 분리
					//document.getElementById('zipcode2').value = data.postcode2; //6자리 우편번호 사용
					document.getElementById(zipcode).value = data.zonecode;	//5자리 기초구역번호 사용
					document.getElementById(addr).value = fullAddr;

					// 커서를 상세주소 필드로 이동한다.
					document.getElementById(addr_det).focus();
				}
			}).open();
		}

	</script>

<!-- 배너 관리 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="./<?=$include_file?>_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="state" value="<?=$state?>">
    <input type="hidden" name="referer" value="<?=$referer?>">
    <input type="hidden" name="idx" value="<?=$_GET[idx]?>">
	<input type="hidden" name="updir" value="<?=$updir?>">

	<div class="form_div">
		<div class="location_title"><?=$sh_title?></div>

        <table class="person-tb">
        <caption><?=$sh_title?></caption>
        <tbody>
		<tr>
            <th scope="row"><label for="ban_use">구독내용</label></th>
            <td>
				<input type="radio" name="division" id="division3" value="both" <? if ( !$row['subscribeType'] || $row['subscribeType']=='both') { echo "checked"; } ?>> <label for="division3">잡지 / E-mail 뉴스레터 전체 구독을 원합니다.</label><br>
				<input type="radio" name="division" id="division2" value="offline" <? if ( $row['subscribeType']=='offline') { echo "checked"; } ?>> <label for="division2">잡지 구독을 원합니다.</label><br>
				<input type="radio" name="division" id="division1" value="online" <? if ( $row['subscribeType']=='online') { echo "checked"; } ?>> <label for="division1">E-mail 뉴스레터 구독을 원합니다</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ban_name">이름</label></th>
            <td>
                <input type="text" id="ban_name" name="userNm" value="<?=$row[userNm]?>" required class="input_box400"> 
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="ban_name">전화번호</label></th>
            <td>
                <input type="text" id="ban_name" name="tel" value="<?=$row[tel]?>" class="input_box400"> 
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="ban_name">이메일</label></th>
            <td>
                <input type="text" id="ban_name" name="email" value="<?=$row[email]?>" class="input_box400"> 
            </td>
        </tr>
        <!-- <tr>
            <th scope="row"><label for="position">노출위치</label></th>
            <td>
                <select name="position" id="position" class="selectbox">
					<option value="">선택</option>
					<option value="main_visual" <?=($position=="main_visual")?"selected":"";?>>main_visual</option>
					<option value="main_bottom" <?=($position=="main_bottom")?"selected":"";?>>main_bottom</option>
                </select>
                <span class="frm_info"><?=$help_img?> 노출 위치를 선택해 주세요. 보기 : main_visual, main_bottom, login</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="sequence">진열순서</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="sequence" name="sequence" value="<?=$sequence?>" class="input_box_num_small"> 
                <span class="frm_info"><?=$help_img?> 진열 순서를 선택해 주세요. 예) 1 ~ 9 숫자가 적은 순으로 진열됩니다.</span>
            </td>
        </tr> -->
        <tr>
            <th scope="row"><label for="ban_use">주소</label></th>
            <td>
				<input type="text" style="width:100px;" name="zipcode" id="zipcode" title="우편번호" value="<?=$row[zipcode]?>">
							<a href="javascript:;" class="btnMid" onclick="javascript:openPostcode('zipcode', 'addr1', 'addr2');">우편번호 검색</a><br>
							<input type="text" style="width:42%; margin-top:5px;" name="addr1" id="addr1" title="주소" value="<?=$row[addr1]?>">
							<input type="text" style="width:42%; margin-top:5px;" name="addr2" id="addr2" title="상세주소" value="<?=$row[addr2]?>">
            </td>
        </tr>
       

		<tr>
            <th scope="row"><label for="ban_use">신청동기</label></th>
            <td>
				<input type="radio" name="motive" id="motive1" <? if ( $row['req_motive']=='동트는 강원 잡지를 보고') { echo "checked"; } ?>  value="동트는 강원 잡지를 보고"> <label for="motive1">동트는 강원 잡지를 보고</label><br>
				<input type="radio" name="motive" id="motive2" <? if ( $row['req_motive']=='인터넷 검색을 통해') { echo "checked"; } ?> value="인터넷 검색을 통해"> <label for="motive2">인터넷 검색을 통해</label><br>
				<input type="radio" name="motive" id="motive3" <? if ( $row['req_motive']=='홈페이지, 페이스북, 블로그를 통해') { echo "checked"; } ?> value="홈페이지, 페이스북, 블로그를 통해"> <label for="motive3">동트는 강원 홈페이지, 페이스북, 블로그를 보고</label><br>
				<input type="radio" name="motive" id="motive4" <? if ( $row['req_motive']=='주변 지인의 소개') { echo "checked"; } ?> value="주변 지인의 소개"> <label for="motive4">주변 지인의 소개</label>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="ban_use">그룹</label></th>
            <td>
				<select name="ggr" id="ggr" class="selectbox" style="width:140px;  height:30px">
				<option value="">그    룹</option>
				<?
					$sql2		= "SELECT * FROM sh_group $swhere ORDER BY no DESC";
					$row2		= $DB->dfetcharr($sql2);
			
				for($i=0;$i<sizeof($row2);$i++){
					$rows2			= $row2[$i];
					?>
				<option value="<?=$rows2['no']?>" <? if ( $row['ggr']==$rows2['no']) { echo "selected"; } ?>><?=$rows2['name']?></option>
				<? } ?>
			</select>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="ban_use">부수</label></th>
            <td>
				<input type="text" id="snum" name="snum" value="<?=$row[snum]?>"  class="input_box200">부
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="ban_use">발송형태</label></th>
            <td>
				<input type="text" id="stype" name="stype" value="<?=$row[stype]?>"  class="input_box200">
            </td>
        </tr>
		<? if (!$row[insertDttm]) {
		$row_insertDttm = date("Y-m-d H:i:s");
		} else { 
		$row_insertDttm = $row[insertDttm];
		}
		?>
		<tr>
            <th scope="row"><label for="ban_use">등록일</label></th>
            <td>
				<input type="text" id="stype" name="stype" value="<?=$row_insertDttm?>"  class="input_box200">
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="ban_use">수정일</label></th>
            <td>
				<input type="text" id="stype" name="stype" value="<?=$row[updateDttm]?>"  class="input_box200">
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="ban_link_type">기타</label></th>
            <td>
                <TEXTAREA name="etc" id="ban_text" class="smarteditor2" style="width:100%;height:350px;"><?=$row['etc']?></TEXTAREA>
            </td>
        </tr>

		

		
        </tbody>
        </table>
    </div>

    <div id="btn_confirm">

		<?if ($_GET['idx']) { ?>
        <input type="submit" value="신청 수정하기" id="btn_submit" class="button">
		<? }else { ?>
        <input type="submit" value="구독 신청하기" id="btn_submit" class="button">
		<? } ?>
		<input type="button" class="button_cancel" value="취소하기" onclick="history.back(-1);">
    </div>
    </form>

  <script type="text/javascript">
	var oEditors	= [];
	var rPath		= "<?=$sh["rPath"]?>"
	</script>	
	<script type="text/javascript" src="<?=$sh["rPath"]."/".SHOP_JS?>/smarteditor.js"></script>
	<!-- 스마트 에디터 자바스크립트 끝 -->

    <script>
	$(document).ready(function(){

		$('#division1').click(function(){//온라인 선택
			if (document.all.division[2].checked == true) {
				$('input[name="email"]').attr("required",true);
			}
		});
		$('#division2').click(function(){//오프라인 선택
			if (document.all.division[1].checked == true) {
				$('input[name="tel"]').attr("required",true);
				$('input[name="zipcode"]').attr("required",true);
				$('input[name="addr1"]').attr("required",true);
				$('input[name="addr2"]').attr("required",true);
			}
		});
		$('#division3').click(function(){//전체 선택
			if (document.all.division[0].checked == true) {
				$('input[name="tel"]').attr("required",true);
				$('input[name="email"]').attr("required",true);
				$('input[name="zipcode"]').attr("required",true);
				$('input[name="addr1"]').attr("required",true);
				$('input[name="addr2"]').attr("required",true);
			}
		});
	});

    // submit 폼체크
    function fregisterform_submit(f){

		// 에디터의 내용이 textarea에 적용된다.
		oEditors.getById["ban_text"].exec("UPDATE_CONTENTS_FIELD", []);

		//if (f.bankname.value.length < 1) {
		//	alert("은행명을 입력해 주세요.");
		//	f.bankname.focus();
		//	return false;
		//}    

        return true;
    }
    </script>

</div>
<!-- 배너 관리 끝 -->