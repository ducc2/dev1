<? include "./inc/header.php"; ?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="/crm_list.php">Home</a>
							</li>

							
							<li class="active">관리자 목록</li>
						</ul><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						

						<div class="page-header">
							<h1>
								관리자 목록
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									전체 관리자 목록페이지입니다.
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
											<? if ($_SESSION['ss_user_grade']==10) { ?>
												<tr><td colspan=6><a class='btn first' href="adm_insert.php?page=<?=$page?>">[관리자추가]</a></td></tr>
											<? } ?>
												<tr>
													<th class="detail-col">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</th>
													<th>등록일</th>
													<th>이름</th>
													<th>아이디</th>
													<th>권한</th>
													<th>관리</th>
													<!-- <th>
														<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
														Update
													</th> -->
												</tr>
											</thead>

											<tbody>
										<?
											 $sel_num = $per_pages; //한페이지에 출력할 게시물 개수
											 $page = "";
											 $sql = "SELECT count(*) as cnt FROM ".$tbname['users'];
											 $rst = $mysqli->query($sql);
											 $cnt = mysqli_fetch_array($rst, MYSQLI_ASSOC);
											 $total_count = $cnt['cnt']; //페이징할 총 글수
											 $total_page = ceil($total_count/$sel_num); //전체페이지 계산
											 if(!$_GET[page]){ $page = 1; } else { $page = $_GET[page]; } // 페이지가 없으면 1 페이지
											 $from_record = ($page - 1) * $sel_num; //시작열을 구함
											
											$write_pages = get_paging($sel_num, $page, $total_page, "?page=");  //함수를 실행

											$query = "SELECT * FROM ".$tbname['users']." ORDER by user_idx desc limit {$from_record}, {$sel_num}";
											$result = $mysqli->query($query);

											while($row = $result->fetch_array())
											{	
											?>
												<tr>
													<td class="center">
														<label class="pos-rel">
															<input type="checkbox" class="ace" />
															<span class="lbl"></span>
														</label>
													</td>
													<td>
														<a href="/adm_detail.php?user_idx=<?=$row['user_idx']?>&page=<?=$page?>"><?=$row['user_reg']?></a>
													</td>
													<td>
														<a href="/adm_detail.php?user_idx=<?=$row['user_idx']?>&page=<?=$page?>"><?=$row['user_name']?></a>
													</td>
													<td>
														<a href="/adm_detail.php?user_idx=<?=$row['user_idx']?>&page=<?=$page?>"><?=$row['user_id']?></a>
													</td>
													<td>
														<? if ($row['user_grade']=='1') {?>코디<? } ?>
														<? if ($row['user_grade']=='2') {?>간호사<? } ?>
														<? if ($row['user_grade']=='3') {?>수술실장<? } ?>
														<? if ($row['user_grade']=='4') {?>상담실장<? } ?>
														<? if ($row['user_grade']=='5') {?>수간호사<? } ?>
														<? if ($row['user_grade']=='10') {?>최고관리자<? } ?>
														
													</td>
													<td>
													<? if ($row['user_grade']<10) { ?>
														<a href="#" onclick="delok('<?=$row['user_idx']?>','<?=$page?>')">[삭제]</a>
													<? } ?>
													</td>
													
												</tr>
											<? } ?>
												<tr><td colspan=6>
												<?=$write_pages?>
												</td></tr>


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
		location.href='/adm_ok.php?mode=del&user_idx='+appidx+'&page='+page;
	}

}
</script>