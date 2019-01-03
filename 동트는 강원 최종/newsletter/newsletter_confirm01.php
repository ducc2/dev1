<?
$sh["rPath"]="..";
$board_id = "subscribe";
include_once($sh["rPath"]."/_common.php");

include_once($sh["rPath"]."/_head.php");

?>

	<script type="text/javascript">

	function goTelChk(){
			
			if ($("#pname2").val().length<1)
			{
				alert("이름을 입력해주세요");
				$('#pname2').focus();
				return false; 
			}

			if ($("#pphone2").val().length<3)
			{
				alert("핸드펀 번호를 입력해주세요");
				$('#pphone2').focus();
				return false; 
			}

			if ($("#pphone3").val().length<4)
			{
				alert("핸드펀 번호를 입력해주세요");
				$('#pphone3').focus();
				return false;
			}



		$.ajax({
			type:"post",
			url:"/newsletter/ajaxNewsletterReqChk.php",
			dataType:"text",
			data:{
				nm : $('#telChkForm').find('#pname2').val(),
				pphone1 : $('#telChkForm').find('#pphone1').val(),
				pphone2 : $('#telChkForm').find('#pphone2').val(),
				pphone3 : $('#telChkForm').find('#pphone3').val()
			},
			success:function(data){
				

				if(data==0){
					alert("신청 자료가 없습니다.");
				} else if(data){
					$('#telChkForm').find('#idx').val(data);
					$('#telChkForm').attr('action','/newsletter/newsletter_confirm02.php');
					$('#telChkForm').submit();
				}else if(parseInt(data) < 0){
					alert("해지된 신청건입니다.");
				}

				return false;
			},
			//error       : function(){
			//	alert("실패하였습니다.");
			//	return false;
			//}
			error	: function(request, status, error){
				alert("code:"+ request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
	}

	function goMailChk(){
			
			if ($("#pname1").val().length<1)
			{
				alert("이름을 입력해주세요");
				$('#pname1').focus();
				return false; 
			}

			if ($("#pemail").val().length<1)
			{
				alert("이메일을 입력해주세요");
				$('#ppemail').focus();
				return false; 
			}


			var email =$('#mailChkForm').find('#pemail').val();  
			var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;   
			  
			if(regex.test(email) === false) {  
				alert("잘못된 이메일 형식입니다.");  
				$('.email').val('');
				$('.email').focus();
				return false;  
			} 
		
		//alert($('#mailChkForm').find('#pemail').val());

		$.ajax({
			type:"post",
			url:"/newsletter/ajaxNewsletterReqChk.php",
			dataType:"text",
			data:{
				nm : $('#mailChkForm').find('#pname1').val(),
				mail : $('#mailChkForm').find('#pemail').val()
			},
			success:function(data){
				
				if(data==0){
					alert("신청 자료가 없습니다.");
				} else if(data){
					$('#mailChkForm').find('#phone').val(data);
					$('#mailChkForm').attr('action','/newsletter/newsletter_confirm02.php');
					$('#mailChkForm').submit();
				}else if(parseInt(data) < 0){
					alert("해지된 신청건입니다.");
				}

				return false;
			},
			//error       : function(){
			//	alert("실패하였습니다.");
			//	return false;
			//}
			error	: function(request, status, error){
				alert("code:"+ request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
	}

	$(function()
	{
	 $(document).on("keyup", "input:text[numberOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});
	 $(document).on("keyup", "input:text[datetimeOnly]", function() {$(this).val( $(this).val().replace(/[^0-9:\-]/gi,"") );});
	});
	</script>

	<div class="locationwrap">
		<div class="location">
			<a href="/" class="icon_set icon_home">home</a> &gt;
			<a href="#">Community</a> &gt;
			<span>정기구독신청</span>
		</div>
	</div><!--//locationwrap -->


	<!-- con_wrap -->
	<div class="con_wrap clearfix">
		<!-- container -->
		<div class="container" id="container">

		<!-- ============================ 내용시작 ============================ -->
			<div class="contents">
				<h2>정기구독신청</h2>

				<ul class="tabMenu">
					<li><a href="/newsletter/newsletter_apply01.php">정기구독신청</a></li>
					<li><a href="/newsletter/newsletter_confirm01.php" class="on">구독정보 확인 및 변경</a></li>
				</ul>

				<div class="confirmBox">

				<ul>
					<li>
					<div class="pass_box2">
						<form name="mailChkForm" id="mailChkForm" method="post" action="#">
						<input type="hidden" name="idx" id="phone"/>
						<fieldset>
						<legend>이름 / 이메일로 조회하기</legend>

							<h3>이름 / 이메일로 조회하기
							<em>온라인 조회</em></h3>
							<dl>
								<dt><label for="pname">이름</label></dt>
								<dd><input type="text" name="pname" id="pname1"></dd>
								<dt><label for="pphone">이메일</label></dt>
								<dd><input type="text" name="pemail" id="pemail" class="email"><br>
								(예시 : myid@abc.com)
								</dd>
							</dl>
							<button class="btnWrite" onclick="goMailChk();return false;">구독정보<br>확인하기</button>

						</fieldset>
						</form>
					</div>
					</li>
					<li>

					<div class="pass_box2">
						<form name="telChkForm" id="telChkForm" method="post" action="#">
						<input type="hidden" name="idx" id="idx"/>
						<fieldset>
						<legend>이름 / 전화번호로 조회하기</legend>

							<h3>이름 / 전화번호로 조회하기<em>온라인/오프라인 조회</em></h3>
							<dl>
								<dt><label for="pname">이름</label></dt>
								<dd><input type="text" name="pname" id="pname2"></dd>
								<dt><label for="pphone">전화번호</label></dt>
								<dd>
								<select name="pphone1" id="pphone1" title="전화번호선택">
									<option value="010">010</option>
									<option value="011">011</option>
									<option value="016">016</option>
									<option value="017">017</option>
									<option value="018">018</option>
									<option value="019">019</option>
									<option value="02">02</option>
									<option value="031">031</option>
									<option value="032">032</option>
									<option value="033">033</option>
									<option value="041">041</option>
									<option value="042">042</option>
									<option value="043">043</option>
									<option value="051">051</option>
									<option value="052">052</option>
									<option value="053">053</option>
									<option value="054">054</option>
									<option value="055">055</option>
									<option value="061">061</option>
									<option value="062">062</option>
									<option value="063">063</option>
									<option value="064">064</option>
									<option value="070">070</option>
									<option value="0505">0505</option>
								</select> -
								<input type="text" name="pphone2" id="pphone2" title="전화번호입력" style="ime-mode:disabled; width:50px" numberonly="true" maxlength=4> -
								<input type="text" name="pphone3" id="pphone3" title="전화번호입력" style="ime-mode:disabled; width:50px" numberonly="true" maxlength=4>
<br>
								(예시 : 010-1234-5678)
								</dd>
							</dl>
							<button class="btnWrite" onclick="goTelChk(); return false;">구독정보<br>확인하기</button>

						</fieldset>
						</form>
					</div>
					</li>
				</ul>

				</div><!--//confirmBox -->

			</div><!--// contents-->
		<!-- ============================ 내용종료 ============================ -->

		</div><!--// container -->
				<?
		include_once($sh["rPath"]."/_bottom.php");
		?>