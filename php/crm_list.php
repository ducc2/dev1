<? include "./inc/header.php"; ?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="/crm_list.php">Home</a>
							</li>

							
							<li class="active">CRM 목록</li>
						</ul><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						

						<div class="page-header">
							<h1>
								CRM 목록
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									전체 CRM 목록페이지입니다.
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<table id="simple-table" class="table  table-bordered table-hover">
											<thead>
											    <form name="crm_search" action="?" method="GET">
												<tr><td colspan=10><select name="s_key">
												<option value="">필터 선택</option>
												<option value="apply_enter">유입</option>
												<option value="apply_teacher">관리자</option>
												<option value="apply_reg">등록일</option>
												<option value="apply_name">이름</option>
												<option value="apply_tel">연락처</option>
												<option value="apply_var">항목</option>
												<option value="apply_status">상태</option>
												</select>&nbsp;<select name="apply_status">
												<option value="">상태 선택</option>
											<?
											$query2 = "SELECT * FROM ".$tbname['terms']." where terms_type='status'";
											$result2 = $mysqli->query($query2);

											while($row2 = $result2->fetch_array())
											{?>
											<option value="<?=$row2['terms_idx']?>" <? if ($row['apply_status']==$row2['terms_idx']) { ?>selected<? } ?>><?=$row2['terms_title']?></option>
											<? } ?>
											</select>&nbsp;<input type=text name=reg1 id= "date1" style="width:90px" readonly> ~ <input type=text name=reg2 style="width:90px" id= "date2" readonly>&nbsp;<input type=text name=s_val value="">&nbsp;<input type=submit value="검색">
											
												<? if ($_SESSION['ss_user_grade']>3) { ?>
												<a class='btn first' href="#" onclick="smsok();">[단체문자]</a>
												<? } ?>
												</td></tr>
												</form>
												<? if ($_SESSION['ss_user_grade']>1) { ?>
												<tr><td colspan=10>
												<a class='btn first' href="crm_insert.php?page=<?=$page?>">[CRM추가]</a>&nbsp;&nbsp;
												<? if ($_SESSION['ss_user_grade']==10) { ?>
												<a class='btn first' href="#" onclick="document.fee.submit();">[선택수정]</a>
												</td></tr>
												<? } 
												}
												?>

												<tr>
													<th class="center" width=65>
														<label class="pos-rel">
															<input type="checkbox" class="aller" name='all'/>
															<span class="lbl"></span>
														</label>
													</th>
													<th width=90>등록일</th>
													<th width=60>이름</th>
													<th width=120>연락처</th>
													<th width=100>항목</th>
													<th width=100>상태</th>
													<th width=90>유입</th>
													<th width=310>상담내용</th>
													<th>new</th>
													<th>관리</th>
													<!-- <th>
														<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
														Update
													</th> -->
												</tr>
											</thead>
											<form name="fee" method="post" action="crm_ok.php">
											<input type=hidden name=mode value="seledit">
											<tbody>
											<?
											//상담실장일 경우는 본인환자만 출력
											if ($_SESSION['ss_user_grade']==3) {

												$mycrm_sql = "and apply_teacher=".$_SESSION['ss_user_idx'];
											}

											if ($_GET['reg1'] && $_GET['reg2']) { 
												$mycrm_sql .= "and DATE_FORMAT(apply_reg,'%Y%m%d') >= ".$_GET['reg1']." AND DATE_FORMAT(apply_reg,'%Y%m%d') <=".$_GET['reg2']."";
											}
											

											if ($_GET['s_key']) { 
												
												if ($_GET['s_key']=="apply_teacher") {
														$sql_tem = "SELECT user_idx FROM ".$tbname['users']." where user_name='".$_GET['s_val']."'";
														$rst_tem = $mysqli->query($sql_tem);
														$cnt_tem = mysqli_fetch_array($rst_tem, MYSQLI_ASSOC);	

														$mycrm_sql .= " and ".$_GET['s_key']." = '".$cnt_tem['user_idx']."'";
												
												} else 

												$mycrm_sql .= " and ".$_GET['s_key']." like '%".$_GET['s_val']."%'";

											}

											if ($_GET['apply_status']) { 
												$mycrm_sql .= " and apply_status ='".$_GET['apply_status']."'";

											}

											

											 $sel_num = $per_pages; //한페이지에 출력할 게시물 개수
											 $page = "";
											 $sql = "SELECT count(*) as cnt FROM ".$tbname['apply']." where 1=1 ".$mycrm_sql;
											 $rst = $mysqli->query($sql);
											 $cnt = mysqli_fetch_array($rst, MYSQLI_ASSOC);
											 $total_count = $cnt['cnt']; //페이징할 총 글수
											 $total_page = ceil($total_count/$sel_num); //전체페이지 계산
											 if(!$_GET[page]){ $page = 1; } else { $page = $_GET[page]; } // 페이지가 없으면 1 페이지
											 $from_record = ($page - 1) * $sel_num; //시작열을 구함
											
											$write_pages = get_paging($group_pages, $page, $total_page, "?page=");  //함수를 실행

											$query = "SELECT * FROM ".$tbname['apply']." where 1=1 ".$mycrm_sql." ORDER by apply_idx desc limit {$from_record}, {$sel_num}";
											//echo $query;

											$result = $mysqli->query($query);
											
											$number=$total_count-($page-1)*$sel_num;

											while($row = $result->fetch_array())
											{
												$class="";
												if ($row[apply_status]=="63") {
													$class="class='green'";
												} else if ($row[apply_status]=="62") {
													$class="class='black2'";
												} else if ($row[apply_status]=="65") {
													$class="class='black'";
												} else if ($row[apply_status]=="66") {
													$class="class='purple'";
												} else if ($row[apply_status]=="58") {
													$class="class='blue'";
												} else if ($row[apply_status]=="67") {
													$class="class='brown'";
												} else if ($row[apply_status]=="68") {
													$class="class='bgreen'";
												} else if ($row[apply_status]=="69") {
													$class="class='pink'";
												} else if ($row[apply_status]=="64") {
													$class="class='bred'";
												} else if ($row[apply_status]=="55") {
													$class="class='purple'";
												} 
																						?>
											<input type=hidden name=check[] value="<?=$row['apply_idx']?>">
												<tr>
													<td class="center">
														<?=$number?>
														<label class="pos-rel">
															<input type="checkbox" class="ab" name='chk' value="<?=$row['apply_idx']?>"/>
															<span class="lbl"></span>
														</label>
														
													</td>
													<td>
														<a href="/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=<?=$page?>"><?=$row['apply_reg']?></a>
													</td>
													<td>
														<a href="/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=<?=$page?>"><?=$row['apply_name']?></a>
													</td>
													<td>
														<a href="/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=<?=$page?>"><?=$row['apply_tel']?><br><?=$row['apply_email']?></a>
													</td>
													<td>
														<a href="/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=<?=$page?>"><?=$row['apply_var']?></a>
													</td>
													<td>


											<?
											$query2 = "SELECT * FROM ".$tbname['terms']." where terms_type='status'";
											$result2 = $mysqli->query($query2);

											while($row2 = $result2->fetch_array())
											{
											if ($row['apply_status']==$row2['terms_idx']) { ?><span <?=$class?>><?=$row2['terms_title']?></span>
											<? } 
											}?>


													
													</td>
													<td>
														<a href="/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=<?=$page?>"><?=$row['apply_enter']?></a>
													</td>
													<td>
														<a href="/crm_detail.php?apply_idx=<?=$row['apply_idx']?>&page=<?=$page?>"><?=nl2br($row['apply_content'])?></a>
													</td>
													<td>
														<? if ($row['apply_ok']==0) { ?>
														<font color="red"><strong>[NEW]</strong></font>
														<? } ?>
													</td>
													
													<td >

													<select name="apply_teacher[]">
													<option value="">관리자선택</option>
													<?
													$query2 = "SELECT * FROM ".$tbname['users']." where user_grade in (3,4)";
													$result2 = $mysqli->query($query2);

													while($row2 = $result2->fetch_array())
													{?>
													<option value="<?=$row2['user_idx']?>" <? if ($row['apply_teacher']==$row2['user_idx']) { ?>selected<? } ?>><?=$row2['user_name']?></option>
													<? } ?>
													</select>

													<!-- <select name="apply_teacher">
													<option value="이희원" <? if ($row['apply_teacher']=='이희원') {?>selected<? } ?>>이희원</option>
													<option value="안덕화" <? if ($row['apply_teacher']=='안덕화') {?>selected<? } ?>>안덕화</option>
													<option value="김경민" <? if ($row['apply_teacher']=='김경민') {?>selected<? } ?>>김경민</option>
													<option value="수술실장" <? if ($row['apply_teacher']=='수술실장') {?>selected<? } ?>>수술실장</option>
													<option value="간호사" <? if ($row['apply_teacher']=='간호사') {?>selected<? } ?>>간호사</option>
													</select> -->
													
													<? if ($_SESSION['ss_user_grade']==4) { ?>
													<a href="#" onclick="delok('<?=$row['apply_idx']?>','<?=$page?>')">[삭제]</a>
													<? } ?>
													</td>
													
												</tr>
											<? 
												$number--;
												} ?>
												<tr><td colspan=10>
												<?=$write_pages?>
												</td></tr>
												<style>
											.bred{color:red}
											.green{color:green}
											.purple{color:purple}
											.blue{color:blue}
											.bgreen { color:green; font-weight:bold; }
											.pink { color:pink; }
											.brown { color:brown; }
											td a { color:black; }
											</style>
											</tbody>
										</table>
									</div><!-- /.span -->
								</div><!-- /.row -->

								
						

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

<? include "./inc/tail.php"; ?>

<script>
function delok(appidx,page) {

	if (confirm("정말로 삭제하시겠습니까?"))
	{
		location.href='/crm_ok.php?mode=del&apply_idx='+appidx+'&page='+page;
	}

}

function smsok() {
	
	var str = "";  
    $("input:checkbox:checked").each(function (index) { 
		if ($(this).val())
		{
			str += $(this).val() + ",";
		}
        });  
	
	//alert(str);

	openWin('/sel_sms.html?check='+str,500,400)

}

$( document ).ready( function() {
        $( '.aller' ).click( function() {
          $( '.ab' ).prop( 'checked', this.checked );
        } );
      } );



</script>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
.ui-datepicker{ font-size: 12px; width: 240px; }
</style>

  <script>
  $( function() {
    $( "#date1" ).datepicker({
    dateFormat: 'yymmdd',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    dayNames: ['일','월','화','수','목','금','토'],
    dayNamesShort: ['일','월','화','수','목','금','토'],
    dayNamesMin: ['일','월','화','수','목','금','토'],
    showMonthAfterYear: true,
    changeMonth: true,
    changeYear: true,
    yearSuffix: '년'
  });

  $( "#date2" ).datepicker({
    dateFormat: 'yymmdd',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
    dayNames: ['일','월','화','수','목','금','토'],
    dayNamesShort: ['일','월','화','수','목','금','토'],
    dayNamesMin: ['일','월','화','수','목','금','토'],
    showMonthAfterYear: true,
    changeMonth: true,
    changeYear: true,
    yearSuffix: '년'
  });
  } );

  </script>