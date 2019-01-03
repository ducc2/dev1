<? include "./inc/header.php"; ?>

<?
$query = "SELECT * from ".$tbname['apply']." where apply_idx=".$_GET['apply_idx'];
$result = mysqli_query($mysqli, $query);

/* numeric array */
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$query = "update ".$tbname['apply']." set apply_ok=1 where apply_idx=".$_GET['apply_idx'];
$result = mysqli_query($mysqli, $query);

?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="/crm_list.php">Home</a>
							</li>

							
							<li class="active">CRM 상세</li>
						</ul><!-- /.breadcrumb --><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						

						<div class="page-header">
							<h1>
								CRM 상세
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									해당 CRM의 상세정보를 보여줍니다.
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" name="rree" role="form" action="crm_ok.php" method="POST" enctype="multipart/form-data">
								<input type=hidden name=mode value="edit">
								<input type=hidden name=apply_idx value="<?=$_GET['apply_idx']?>">
								<input type=hidden name=page value="<?=$_GET['page']?>">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">이름 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="apply_name" placeholder="이름" class="col-xs-10 col-sm-5" value="<?=$row['apply_name']?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">연락처 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="apply_tel" placeholder="연락처" class="col-xs-10 col-sm-5" value="<?=$row['apply_tel']?>"/>&nbsp;
											<? if ($_SESSION['ss_user_grade']>3) { ?>
											<button class="btn btn-info" type="button" onclick="openWin('/sms.html?apply_idx=<?=$row['apply_idx']?>&apply_tel=<?=$row['apply_tel']?>',500,400)">
												SMS문자발송
											</button>
											<? } ?>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">이메일 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="apply_email" placeholder="이메일" class="col-xs-10 col-sm-5" value="<?=$row['apply_email']?>"/>
										</div>
									</div>

									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">작성일 </label>

										<div class="col-sm-9">
											<?=$row['apply_reg']?>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">상태 </label>

										<div class="col-sm-9">
											<select name="apply_status">
											<?
											$query2 = "SELECT * FROM ".$tbname['terms']." where terms_type='status'";
											$result2 = $mysqli->query($query2);

											while($row2 = $result2->fetch_array())
											{
												
												if ($row2[terms_idx]=="63") {
													$class="style='font-weight: bold;color:green'";
												} else if ($row2[terms_idx]=="62") {
													$class="style='font-weight: bold;color: black'";
												} else if ($row2[terms_idx]=="64") {
													$class="style='font-weight: bold;color: red'";
												} else if ($row2[terms_idx]=="65") {
													$class="style='font-weight: bold;color: orange'";
												} else if ($row2[terms_idx]=="66") {
													$class="style='font-weight: bold;color: 'purple'";
												} else if ($row2[terms_idx]=="58") {
													$class="style='font-weight: bold;color: blue'";
												} else if ($row2[terms_idx]=="67") {
													$class="style='font-weight: bold;color: firebrick'";
												} else if ($row2[terms_idx]=="68") {
													$class="style='font-weight: bold;color: bgreen'";
												} else if ($row2[terms_idx]=="69") {
													$class="style='font-weight: bold;color: pink'";
												} else if ($row2[terms_idx]=="55") {
													$class="style='font-weight: bold;color: #D51AC8'";
												} else {
													$class="style='font-weight: bold;'";
												} 

												
												?>
											<option value="<?=$row2['terms_idx']?>" <? if ($row['apply_status']==$row2['terms_idx']) { ?>selected<? } ?> <?=$class?>><?=$row2['terms_title']?></option>
											<? } ?>
											</select>
										</div>
									</div>
									<? if ($_SESSION['ss_user_grade']==4 || $_SESSION['ss_user_idx']==$row['apply_10']) { ?>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">유입 경로 표시</label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="apply_enter" placeholder="유입 경로 표시" class="col-xs-10 col-sm-5" value="<?=$row['apply_enter']?>"/>
										</div>
									</div>
									<? } ?>
										<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">예약 확인 시간 </label>

										<div class="col-sm-9">
											<input type="text" id="datepicker" name="apply_date" value="<?=$row['apply_date']?>" placeholder="예약 날짜">&nbsp;
											<select name='apply_3'>
											<?
											for ($i=9; $i<24; $i++)   {
											  for ($j=0; $j<2; $j++)   {
												  $selected="";
												  if ($i==9) { 
												  $to = "0".$i.":".($j*30);
												  } else {
												  $to = $i.":".($j*30);
												  }
												  if ($j==0) { 
													  if ($i==9) { 
														$to = "0".$i.":00";
													  } else {
														$to = $i.":00";
													  }
												  }
												  if ($row['apply_3']==$to)		{
													  $selected="selected";
												  }
												  echo "<option value='".$to."' $selected>".$to."</option>";
											  }
											}
											?>
											</select>
											&nbsp;
											
											<select name="apply_teacher">
													<option value="">상담사 선택</option>
													<?
													$query2 = "SELECT * FROM ".$tbname['users']." where user_grade in (3,4)";
													$result2 = $mysqli->query($query2);

													while($row2 = $result2->fetch_array())
													{?>
													<option value="<?=$row2['user_idx']?>" <? if ($row['apply_teacher']==$row2['user_idx']) { ?>selected<? } ?>><?=$row2['user_name']?></option>
													<? } ?>
											</select>&nbsp;
											<select name="apply_4">
											<option value="">원장님 선택</option>
													<option value="구진모원장" <? if ($row['apply_4']=='구진모원장') {?>selected<? } ?>>구진모원장</option>
													<option value="황인성원장" <? if ($row['apply_4']=='황인성원장') {?>selected<? } ?>>황인성원장</option>
													<option value="이지용원장" <? if ($row['apply_4']=='이지용원장') {?>selected<? } ?>>이지용원장</option>
													
													</select>&nbsp;
													<select name="apply_9">
													<option value="">수술 선택</option>
											<?
											$query2 = "SELECT * FROM ".$tbname['terms']." where terms_type='min'";
											$result2 = $mysqli->query($query2);

											while($row2 = $result2->fetch_array())
											{?>
											<option value="<?=$row2['terms_idx']?>" <? if ($row['apply_9']==$row2['terms_idx']) { ?>selected<? } ?>><?=$row2['terms_title']?></option>
											<? } ?>
											</select>&nbsp;
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">항목 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="apply_var" placeholder="항목" class="col-xs-10 col-sm-5" value="<?=$row['apply_var']?>"/>
										</div>
									</div>

									
									


									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">파일첨부1 </label>

										<div class="col-sm-9">
												<input type="file" id="form-field-1" name="upload" placeholder="답변" class="col-xs-10 col-sm-5" value="<?=$row['apply_1']?>"/>
												<a href="/lib/download.php?dir=upload&filename=<?=$row['apply_6']?>"><? if ($row['apply_6']) { ?>[첨부파일 다운로드] - <?=$row['apply_6']?><? } ?></a>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">파일첨부2 </label>

										<div class="col-sm-9">
											<input type="file" id="form-field-1" name="upload2" placeholder="답변" class="col-xs-10 col-sm-5" value="<?=$row['apply_1']?>"/>
											<a href="/lib/download.php?dir=upload&filename=<?=$row['apply_7']?>"><? if ($row['apply_7']) { ?>[첨부파일 다운로드] - <?=$row['apply_7']?><? } ?></a>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">상담내용 </label>

										<div class="col-sm-9">
											<? if ($_SESSION['ss_user_idx']==$row['apply_teacher'] || $_SESSION['ss_user_grade']==4) { ?>
											<textarea name="apply_content" style="width:80%; height:100px"><?=nl2br($row['apply_content'])?></textarea>
											<? }else { 
											if ($_SESSION['ss_user_grade']>2) {
											?>
											<?=$row['apply_content']?>
											<? 
											
												}
											} ?>
										</div>
									</div>
									
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">메모 </label>

										<div class="col-sm-9">
											<? if ($_SESSION['ss_user_idx']==$row['apply_teacher'] || $_SESSION['ss_user_grade']==4) { ?>
											<textarea name="apply_memo" style="width:80%; height:100px"><?=$row['apply_memo']?></textarea>
											<? }else { 
											if ($_SESSION['ss_user_grade']>2) {
											?>
											<?=$row['apply_memo']?>
											<? 
											
												}
											} ?>
										</div>
									</div>
									
									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">전화상담</label>

										<div class="col-sm-9">
											<table width=90% style="border-collapse:collapse; table-layout:fixed; word-break:break-all; ">
											<tr style="border:1px solid #cccccc; line-height:22px; background:#efefef"><td   width=40 align=center  style="border-right: 1px solid #cccccc;">번호</td><td width=50 align=center style="border-right: 1px solid #cccccc;">발송인</td><td style="border-right: 1px solid #cccccc; padding-left:10px;width:400px">문자내용</td><td width=130 align=center style="border-right: 1px solid #cccccc;">발송시간</td><td width=90 align=center>
											보낸번호</td></tr>
											<?
											$dquery = "SELECT * FROM ".$tbname['tel']." where apply_idx='".$row['apply_idx']."' ORDER by tel_reg desc";
											//print_r($row);

											$dresult = $mysqli->query($dquery);

											while($drow = $dresult->fetch_array())
											{	
												$nn++;

													$mquery = "SELECT * FROM ".$tbname['users']." where user_idx='".$drow['user_idx']."'";
													//echo $mquery;
													$mresult = mysqli_query($mysqli, $mquery);

													/* numeric array */
													$mrow = mysqli_fetch_array($mresult, MYSQLI_ASSOC);
												?>
											<tr style="border:1px solid #cccccc; line-height:22px"><td align=center  style="border-right: 1px solid #cccccc;"><?=$nn?></td><td align=center style="border-right: 1px solid #cccccc;"><?=$mrow['user_id']?></td><td style="border-right: 1px solid #cccccc; padding-left:10px; "><?=nl2br($drow['tel_content'])?></td><td align=center style="border-right: 1px solid #cccccc;"><?=$drow['tel_reg']?></td><td  align=center>
											<?=$drow['tel_to']?>
											</td></tr>
											<? } ?></table>

										</div>		
							
									</div>


									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">내용</label>

										<div class="col-sm-9">
											<table width=90% style="border-collapse:collapse; ">
											<?
											$dquery = "SELECT * FROM ".$tbname['comments']." where com_apply='".$row['apply_idx']."' ORDER by com_seq desc";
											//print_r($row);

											$dresult = $mysqli->query($dquery);

											while($drow = $dresult->fetch_array())
											{	
												$nn++;

													$mquery = "SELECT * FROM ".$tbname['users']." where user_idx='".$drow['com_users']."'";
													//echo $mquery;
													$mresult = mysqli_query($mysqli, $mquery);

													/* numeric array */
													$mrow = mysqli_fetch_array($mresult, MYSQLI_ASSOC);
												?>
											<tr style="border:1px solid #cccccc; line-height:22px"><td   width=40 align=center  style="border-right: 1px solid #cccccc;"><?=$nn?></td><td width=140 align=center style="border-right: 1px solid #cccccc;"><?=$mrow['user_id']?></td><td style="border-right: 1px solid #cccccc; padding-left:10px"><?=nl2br($drow['com_content'])?></td><td width=140 align=center style="border-right: 1px solid #cccccc;"><?=$drow['com_reg']?></td><td width=50 align=center>
											<?
											if ($mrow['user_idx']==$_SESSION['ss_user_idx'] || $_SESSION['ss_user_grade']==4) { ?>
											<a href="#none" onclick="comdel('<?=$drow['com_idx']?>','<?=$_GET['apply_idx']?>')">[삭제]</a>
											<? } ?>
											</td></tr>
											<? } ?></table>
											</form><br>
											<form method="post" action="comment_ok.php" name="fre">
											<input type=hidden name="com_apply" value="<?=$_GET['apply_idx']?>">
											<input type=hidden name="mode" value="new">
											
											<table width=90% style="border-collapse:collapse; ">
											<tr style="border:1px solid #cccccc;"><td width=90%><textarea name=com_content style="border:1px solid; width:100%; height:100px"></textarea></td><td align=center>
											<input type=button value="저장" onclick="freok()"></td></tr>
											</table>

										</div>		
							
									</div>
									<script>
									function freok() {
										if (!document.fre.com_content.value)
										{
											alert("내용을 입력해주세요");
											document.fre.com_content.focus();
											return false;
										} else {
											document.fre.submit();
										}

									}
									</script>

									<div class="space-4"></div>
									


									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<? if ($_SESSION['ss_user_grade']>1) { ?>
											<button class="btn btn-info" type="button" onclick="document.rree.submit()">
												<i class="ace-icon fa fa-check bigger-110"></i>
												확인
											</button>
											<? } ?>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="button" onclick="location.href='/crm_list.php?page=<?=$_GET['page']?>'">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												목록
											</button>
										</div>
									</div>

									
							
								</div><!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

<? include "./inc/tail.php"; ?>


 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
.ui-datepicker{ font-size: 12px; width: 240px; }
</style>

  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
    dateFormat: 'yy-mm-dd',
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

  function comdel(com_idx,com_apply) {
		if (confirm("정말로 삭제하시겠습니까?"))
		{
			location.href="comment_ok.php?mode=del&com_idx="+com_idx+"&com_apply="+com_apply;
		} else {
			return false;
		}

  } 
  </script>