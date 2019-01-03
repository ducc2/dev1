<? include "./inc/header.php"; ?>


			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="/crm_list.php">Home</a>
							</li>

							
							<li class="active">CRM 등록</li>
						</ul><!-- /.breadcrumb --><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						

						<div class="page-header">
							<h1>
								CRM 등록
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									CRM을 등록합니다.
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" action="crm_ok.php" method="POST" enctype="multipart/form-data">
								<input type=hidden name=mode value="new">
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
											<input type="text" id="form-field-1" name="apply_tel" placeholder="연락처" class="col-xs-10 col-sm-5" value="<?=$row['apply_tel']?>"/>
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


									<!--<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">관리 </label>

										<div class="col-sm-9">
											<select name="apply_teacher">
													<option value="이희원" <? if ($row['apply_teacher']=='이희원') {?>selected<? } ?>>이희원</option>
													<option value="안덕화" <? if ($row['apply_teacher']=='안덕화') {?>selected<? } ?>>안덕화</option>
													<option value="김경민" <? if ($row['apply_teacher']=='김경민') {?>selected<? } ?>>김경민</option>
													<option value="수술실장" <? if ($row['apply_teacher']=='수술실장') {?>selected<? } ?>>수술실장</option>
													<option value="간호사" <? if ($row['apply_teacher']=='간호사') {?>selected<? } ?>>간호사</option>
													</select>
										</div>
									</div>

									<div class="space-4"></div>-->

									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">상태 </label>

										<div class="col-sm-9">
											<select name="apply_status">
											<?
											$query2 = "SELECT * FROM ".$tbname['terms']." where terms_type='status'";
											$result2 = $mysqli->query($query2);

											while($row2 = $result2->fetch_array())
											{?>
											<option value="<?=$row2['terms_idx']?>" <? if ($row['apply_status']==$row2['terms_idx']) { ?>selected<? } ?>><?=$row2['terms_title']?></option>
											<? } ?>
											</select>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">유입 경로 표시</label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="apply_enter" placeholder="유입" class="col-xs-10 col-sm-5" value="<?=$row['apply_enter']?>"/>
										</div>
									</div>

										<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">예약 확인 시간 </label>
										<div class="col-sm-9">

<input type="text" id="datepicker" name="apply_date" >
	
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
.ui-datepicker{ font-size: 12px; width: 240px; }
</style>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
  </script>

											&nbsp;


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
											<select name="apply_4">
											<option value="">원장님 선택</option>
													<option value="구진모원장" <? if ($row['apply_4']=='구진모원장') {?>selected<? } ?>>구진모원장</option>
													<option value="황인성원장" <? if ($row['apply_4']=='황인성원장') {?>selected<? } ?>>황인성원장</option>
													<option value="이지용원장" <? if ($row['apply_4']=='이지용원장') {?>selected<? } ?>>이지용원장</option>
													
													</select>&nbsp;
											<select name="apply_teacher">
													<option value="">상담사 선택</option>
													<?
													$query2 = "SELECT * FROM ".$tbname['users']." where user_grade in (2,3)";
													$result2 = $mysqli->query($query2);

													while($row2 = $result2->fetch_array())
													{?>
													<option value="<?=$row2['user_idx']?>" <? if ($row['apply_teacher']==$row2['user_idx']) { ?>selected<? } ?>><?=$row2['user_name']?></option>
													<? } ?>
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

									
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">내용 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="apply_8" placeholder="항목" class="col-xs-10 col-sm-5" value="<?=$row['apply_8']?>"/>

											<textarea name="cms_content" id="ir1" rows="10" cols="100" style="width:766px; height:412px; display:none;"></textarea>
										</div>
									</div>

									<div class="space-4"></div>


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

									



									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												확인
											</button>

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