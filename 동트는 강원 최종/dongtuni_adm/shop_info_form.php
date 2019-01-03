<?if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가?>


<!-- 샵 기본설정 시작  -->
<div id="cont_right">

    <form id="fregisterform" name="fregisterform" action="./shop_info_proc.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="state" value="update">
	<div class="form_div">
		<div class="location_title">SHOP정보</div>
		<div><span style="color: #FF3366;"> * </span>표시가 있는 부분은 필수 입력 사항입니다.</div>

        <table class="person-tb">
        <caption>SHOP정보</caption>
        <tbody>
        <tr>
            <th scope="row"><label for="company">회사명</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="company" name="company" value="<?=$shop_info[company]?>" required class="input_box"> 
                <span class="frm_info"><?=$help_img?> 쇼핑몰 한단에 노출됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="company_num">사업자등록번호</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="company_num" name="company_num" value="<?=$shop_info[company_num]?>" required class="input_box"> 
                <span class="frm_info"><?=$help_img?> 쇼핑몰 한단에 노출됩니다. 예) 123-12-85214</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="shop_name">쇼핑몰명</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="shop_name" name="shop_name" value="<?=$shop_info[shop_name]?>" required class="input_box"> 
                <span class="frm_info"><?=$help_img?> 쇼핑몰 한단 및 웹브라우저 제목표시줄에 노출됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="company_num2">통신판매신고번호</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="company_num2" name="company_num2" value="<?=$shop_info[company_num2]?>" required class="input_box"> 
                <span class="frm_info"><?=$help_img?> 쇼핑몰 한단에 노출됩니다. 통신판매번호 관리 관청에서 받은 번호를 적어주세요</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="tel1">전화번호</label><span style="color: #FF3366;"> * </span></th>
            <td>
				<input type="text" name="tel1" value="<?=$shop_info['tel1']?>" id="tel1" class="input_box_phone" required maxlength="4">-
				<input type="text" name="tel2" value="<?=$shop_info['tel2']?>" id="tel2" class="input_box_phone" required maxlength="4">-
				<input type="text" name="tel3" value="<?=$shop_info['tel3']?>" id="tel3" class="input_box_phone" required maxlength="4">
                <span class="frm_info"><?=$help_img?> 쇼핑몰 하단 및 고객센터에 노출됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="fax_tel1">팩스번호</label></th>
            <td>
				<input type="text" name="fax_tel1" value="<?=$shop_info['fax_tel1']?>" id="fax_tel1" class="input_box_phone" maxlength="4">-
				<input type="text" name="fax_tel2" value="<?=$shop_info['fax_tel2']?>" id="fax_tel2" class="input_box_phone" maxlength="4">-
				<input type="text" name="fax_tel3" value="<?=$shop_info['fax_tel3']?>" id="fax_tel3" class="input_box_phone" maxlength="4">
                <span class="frm_info"><?=$help_img?> 쇼핑몰 하단 및 고객센터에 노출됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row">주소<span style="color: #FF3366;"> * </span></th>
            <td>                
                <input type="text" name="zip1" value="<?=$shop_info['zip1'] ?>" id="zip1" required class="input_box" size="9" maxlength="5" readonly>
                <button type="button" class="button_small" onclick="execDaumPostcode();" readonly>주소 검색</button><br>
                <input type="text" name="addr1" value="<?=$shop_info['addr1'] ?>" id="addr1" required class="input_box" size="60">
                <label for="addr1">기본주소<br>
                <input type="text" name="addr2" value="<?=$shop_info['addr2'] ?>" id="addr2" required class="input_box" size="60">
                <label for="addr2">상세주소</label>
				<span class="frm_info"><?=$help_img?> 주소 전체는 쇼핑몰 하단 및 고객센터에 노출됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ceo_name">대표자명</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="ceo_name" name="ceo_name" value="<?=$shop_info[ceo_name]?>" required class="input_box"> 
                <span class="frm_info"><?=$help_img?> 쇼핑몰 한단에 노출됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="email">대표메일</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="email" name="email" value="<?=$shop_info[email]?>" required class="input_box" style="width:300px;"> 
                <span class="frm_info"><?=$help_img?> 쇼핑몰 하단 및 고객센터에 노출됩니다. 예) manager@sitename.com</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="privacy_manager">개인정보책임자</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="privacy_manager" name="privacy_manager" value="<?=$shop_info[privacy_manager]?>" required class="input_box"> 
                <span class="frm_info"><?=$help_img?> 쇼핑몰 하단 및 고객센터에 노출됩니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="privacy_manager_email">개인정보책임자메일</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="privacy_manager_email" name="privacy_manager_email" value="<?=$shop_info[privacy_manager_email]?>" required class="input_box" style="width:300px;"> 
                <span class="frm_info"><?=$help_img?> 쇼핑몰 하단 및 고객센터에 노출됩니다. 예) manager@sitename.com</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ssl_use">보안서버(SSL) 사용</label></th>
            <td>
				<input type="radio" name="ssl_use" id="ssl_use" value="0" <?=($shop_info[ssl_use]=="0")?"checked":"";?>>사용안함 &nbsp;
				<input type="radio" name="ssl_use" id="ssl_use" value="1" <?=($shop_info[ssl_use]=="1")?"checked":"";?>>사용 &nbsp;<p></p>
                <span class="frm_info"><?=$help_img?> <br>
				 - 보안서버(SSL) 사용을 선택해 주세요.<br>
				 - 보안서버(SSL)를 <span class="text_emphasis2">사용 하시려면 호스팅 업체에서 보안서버 신청이 되어 있어야 합니다.</span>
				</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ssl_use">보안서버 포트번호</label></th>
            <td>
                <input type="text" id="ssl_use_port" name="ssl_use_port" value="<?=$shop_info[ssl_use_port]?>" class="input_box" style="width:40px;"> 
                <span class="frm_info"><?=$help_img?> 호스팅업에서 발급 받은 보안서버 포트를 입력해주세요. 예) 443</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="base_delivery">기본배송료</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="base_delivery" name="base_delivery" value="<?=$shop_info[base_delivery]?>" required class="input_box_num" onKeyUp="checkMoneyUpdate(this);"> 원
                <span class="frm_info"><?=$help_img?> 입력하신 기본배송료는 장바구니 및 주문서에서 자동 계산합니다. 예) 3000(콤마 없이 입력)</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="free_delivery">무료배송조건</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="free_delivery" name="free_delivery" value="<?=$shop_info[free_delivery]?>" required class="input_box_num" onKeyUp="checkMoneyUpdate(this);"> 원 이상 구매시 
                <span class="frm_info"><?=$help_img?> 입력하신 무료배송조건은 장바구니 및 주문서에서 자동 계산합니다. 예) 30000(콤마 없이 입력)</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="receive_auto">자동상품 수령기간</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="receive_auto" name="receive_auto" value="<?=$shop_info[receive_auto]?>" required class="input_box_num"> 일
                <span class="frm_info"><?=$help_img?> 배송완료 후 자동 구매결정 처리를 위하여 필요합니다. 예) 7</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cart_save">장바구니 보관기간</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="cart_save" name="cart_save" value="<?=$shop_info[cart_save]?>" required class="input_box_num"> 일
                <span class="frm_info"><?=$help_img?> 사용자 장바구니 유효 보관 기간을 입력해 주세요. 예) 30</span>
            </td>
        </tr>
        <!-- <tr>
            <th scope="row"><label for="latest_goods">최근 본 상품 유지기간</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="latest_goods" name="latest_goods" value="<?=$shop_info[latest_goods]?>" required class="input_box_num"> 일
                <span class="frm_info"><?=$help_img?> 사용자 최근 상품 유지기간을 적어주세요 예) 30</span>
            </td>
        </tr> -->
        <tr>
            <th scope="row"><label for="point_use">적립금 사용조건</label><span style="color: #FF3366;"> * </span></th>
            <td>
                <input type="text" id="point_use" name="point_use" value="<?=$shop_info[point_use]?>" required class="input_box_num" onKeyUp="checkMoneyUpdate(this);"> 원 이상시 사용
                <span class="frm_info"><?=$help_img?> 상품 구매시 적립금 사용 조건을 입력해주세요. 예) 50000</span>
            </td>
        </tr>

        </tbody>
        </table>
    </div>

    <div id="btn_confirm">
        <input type="button" class="button_cancel" value="취소" onclick="history.back(-1);">
        <input type="submit" value="정보저장" id="btn_submit" class="button">
    </div>
    </form>

	<script>
		function execDaumPostcode() {
			new daum.Postcode({
				oncomplete: function(data) {
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
					document.getElementById('zip1').value = data.zonecode; //5자리 새우편번호 사용
					document.getElementById('addr1').value = fullAddr;

					// 커서를 상세주소 필드로 이동한다.
					document.getElementById('addr2').focus();
				}
			}).open();
		}
	</script>

    <script>
    // submit 폼체크
    function fregisterform_submit(f){

       
		if (f.company.value.length < 1) {
			alert("회사명을 입력해 주세요.");
			f.company.focus();
			return false;
		}
		
		if (f.company_num.value.length < 1) {
			alert("사업자등록번호를 입력해 주세요.");
			f.company_num.focus();
			return false;
		}
		
		if (f.shop_name.value.length < 1) {
			alert("쇼핑몰명을 입력해 주세요.");
			f.shop_name.focus();
			return false;
		}
		
		if (f.company_num2.value.length < 1) {
			alert("통신판매신고번호를 입력해 주세요.");
			f.company_num2.focus();
			return false;
		}
		
		if (f.tel1.value.length < 1) {
			alert("전화번호를 입력해 주세요.");
			f.tel1.focus();
			return false;
		}
		
		if (f.tel2.value.length < 1) {
			alert("전화번호를 입력해 주세요.");
			f.tel2.focus();
			return false;
		}
		
		if (f.tel3.value.length < 1) {
			alert("전화번호를 입력해 주세요.");
			f.tel3.focus();
			return false;
		}
		
		if (f.zip1.value.length < 1) {
			alert("주소를 입력해 주세요.");
			f.addr1.focus();
			return false;
		}

		if (f.addr1.value.length < 1) {
			alert("주소를 입력해 주세요.");
			f.addr1.focus();
			return false;
		}
		
		if (f.addr2.value.length < 1) {
			alert("주소를 입력해 주세요.");
			f.addr2.focus();
			return false;
		}
		
		if (f.ceo_name.value.length < 1) {
			alert("대표자명을 입력해 주세요.");
			f.ceo_name.focus();
			return false;
		}
		
		if (f.email.value.length < 1) {
			alert("대표메일를 입력해 주세요.");
			f.email.focus();
			return false;
		}
		
		if (f.privacy_manager.value.length < 1) {
			alert("개인정보책임자를 입력해 주세요.");
			f.privacy_manager.focus();
			return false;
		}
		
		if (f.privacy_manager_email.value.length < 1) {
			alert("개인정보 책임자 메일를 입력해 주세요.");
			f.privacy_manager_email.focus();
			return false;
		}
		
		if (f.base_delivery.value.length < 1) {
			alert("기본배송료를 입력해 주세요.");
			f.base_delivery.focus();
			return false;
		}
		
		if (f.free_delivery.value.length < 1) {
			alert("무료배송조건을 입력해 주세요.");
			f.free_delivery.focus();
			return false;
		}
		
		if (f.receive_auto.value.length < 1) {
			alert("자동상품 수령기간을 입력해 주세요.");
			f.receive_auto.focus();
			return false;
		}
		
		if (f.cart_save.value.length < 1) {
			alert("장바구니 보관기간을 입력해 주세요.");
			f.cart_save.focus();
			return false;
		}
		
		if (f.latest_goods.value.length < 1) {
			alert("최근 본 상품 유지기간을 입력해 주세요.");
			f.latest_goods.focus();
			return false;
		}
		
		if (f.point_use.value.length < 1) {
			alert("적립금 사용조건을 입력해 주세요.");
			f.point_use.focus();
			return false;
		}

        return true;
    }
    </script>

</div>
<!-- 샵 기본설정 끝 -->