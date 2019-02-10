<? include "./inc/header.php"; ?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="/crm_list.php">Home</a>
							</li>

							
							<li class="active">관리자 상세</li>
						</ul><!-- /.breadcrumb --><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						

						<div class="page-header">
							<h1>
								관리자 추가
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									해당 관리자의 상세정보를 보여줍니다.
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" action="adm_ok.php" method="POST">
								<input type=hidden name=mode value="new">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">아이디 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="user_id" placeholder="이름" class="col-xs-10 col-sm-5" value="<?=$row['user_id']?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">비밀번호 </label>

										<div class="col-sm-9">
											<input type="password" id="form-field-1" name="user_pw" placeholder="이름" class="col-xs-10 col-sm-5" value="<?=$row['user_pw']?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">이름 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="user_name" placeholder="이름" class="col-xs-10 col-sm-5" value="<?=$row['user_name']?>"/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">연락처 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="user_phone" placeholder="연락처" class="col-xs-10 col-sm-5" value="<?=$row['user_phone']?>"/>-을 포함해주세요
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">이메일 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-1" name="user_email" placeholder="이메일" class="col-xs-10 col-sm-5" value="<?=$row['user_email']?>"/>
										</div>
									</div>

									<!-- <div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">레벨 </label>

										<div class="col-sm-9">
											<select name="user_level">
													<option value="1" <? if ($row['user_level']=='1') {?>selected<? } ?>>1</option>
													<option value="2" <? if ($row['user_level']=='2') {?>selected<? } ?>>2</option>
													
													</select>
										</div>
									</div> -->

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">등급 </label>

										<div class="col-sm-9">
											<select name="user_grade">
													<option value="1" <? if ($row['user_grade']=='1') {?>selected<? } ?>>코디</option>
													<option value="2" <? if ($row['user_grade']=='2') {?>selected<? } ?>>간호사</option>
													<option value="3" <? if ($row['user_grade']=='3') {?>selected<? } ?>>수술실장</option>
													<option value="4" <? if ($row['user_grade']=='4') {?>selected<? } ?>>상담실장</option>
													<option value="5" <? if ($row['user_grade']=='5') {?>selected<? } ?>>수간호사</option>
													<option value="10" <? if ($row['user_grade']=='10') {?>selected<? } ?>>최고관리자</option>
													
													</select>
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
											<button class="btn" type="button" onclick="location.href='/adm_list.php?page=<?=$_GET['page']?>'">
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


