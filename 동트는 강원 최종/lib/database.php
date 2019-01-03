<?php
if (!defined('_SHSHOP_')) exit; // 페이지 직접 접근 불가

class database{
	
	var $hostname;	// 데이터베이스 호스트주소
	var $username;	// 접속아이디
	var $password;	// 접속패스워드
	var $database;	// 데이타베이스명

	/**************************************************************************/
	/* 클래스 인스턴트를 생성하는 함수*/
	/**************************************************************************/
	function database(){
		//if (!defined('_SHSHOP_AUTH_')) exit;
		$this->hostname = MYSQL_HOST;
		$this->username = MYSQL_USER;
		$this->database = MYSQL_DB;	
		$this->password = MYSQL_PASSWORD;
		if(!$this->connect()) return $this->error();
		if(!$this->select()) return $this->error();
	}

	/**************************************************************************/
	/* 데이터베이스 연결하는 함수*/
	/**************************************************************************/
	function connect(){
		return mysql_connect($this->hostname,$this->username,$this->password);
	}

	/**************************************************************************/
	/* 데이터베이스 선택하는 함수*/
	/**************************************************************************/
	function select(){
		return mysql_select_db($this->database,$this->connect());
	}
	/**************************************************************************/
	/* 테이터베이스에 테이블의 존재여부를 체크하는 함수*/
	/**************************************************************************/
	function table_exist($table){
		$bool = false;
		$tb1_exist = mysql_list_tables($this->database);
		while($tables = mysql_fetch_array($tb1_exist)){			
			if($tables[0] == $table){
				$bool = true;
				break;
			}
		}
		return $bool;
	}

	/**************************************************************************/
	/* SQL 쿼리를 실행하는 함수*/
	/**************************************************************************/
	function query($sql){
		mysql_query(" set names utf8 ");
		$rs = mysql_query($sql);
		if(!$rs) return $this->error(); else return $rs;
	}
	
	//**************************************************************************/
	// 테이블의 필드명을 배열로 돌려주는 함수*/
	//**************************************************************************/
	function get_table_fields($table,$bFlag=GET_VALUE){
		$result = mysql_list_fields($this->database, $table);
		$columns = mysql_num_fields($result);
		for($i = 0; $i < $columns; $i++){
			$name  = mysql_field_name($result, $i);
			if($bFlag) $fields[] =  $name;
			else $fields[$name] = "" ;
		}
		return $fields;
	}

	//**************************************************************************/
	// 단일필드 검색 시 쿼리의 결과값을 돌려주는 함수
	//**************************************************************************/
	function result($sql){
		$rs = $this->query($sql);
		if($rs) return @mysql_result($rs,0,0);
	}

	//**************************************************************************
	// 자료의 카운트를 리턴하는 함수
	//**************************************************************************
	function count($table, $where="", $flag=false){
		$sql = "SELECT COUNT(*) FROM ".$table;
		if($where) $sql .= " ".$where;
		$rs = $this->query($sql);
		
		if($flag) return @mysql_num_rows($rs);
		else return @mysql_result($rs,0,0);
	}

	function numrows($rs){
		return @mysql_num_rows($rs);
	}
	
	function rows_count($sql){
		$rs = $this->query($sql);
		if($rs) return @mysql_num_rows($rs);
	}

	// **************************************************************************
	// 필드번호를 VALUE 값으로 자료를 패치하여 배열로 돌려주는 함수
	// **************************************************************************
	function fetchrow($sql){
		$rs = $this->query($sql);
		if($rs) return mysql_fetch_row($rs);
	}

	// **************************************************************************
	// MYSQL_FETCH_ARRAY (검색된 ROW 중 첫번째 ROW 자료를 가져옴)
	// **************************************************************************
	function fetcharr($sql){
		$rs = $this->query($sql);
		if($rs) return mysql_fetch_assoc($rs);
	}

	// **************************************************************************
	// MYSQL_FETCH_ARRAY (검색된 ROW 수만큼 자료를 가져옴)
	// **************************************************************************
	function dfetcharr($sql){
		$rs = $this->query($sql);
		$cnt = mysql_num_fields($rs);
		while($row = mysql_fetch_row($rs)){
			for($i=0;$i<$cnt;$i++){
				$field = mysql_field_name($rs, $i);
				$fieldarr[$field] = $row[$i];
			}
			$array[] = $fieldarr;
		}
		mysql_free_result($rs); return $array;
	}

	// **************************************************************************
	// MYSQL_FETCH_ARRAY (쿼리의 첫번째필드를 KEY 두번째필드를 VALUE로 된 1차원 배열)
	// **************************************************************************
	function efetcharr($sql) {
		if(!$data = $this->dfetcharr($sql)) return false;
		for ($i = 0 ; $i < count($data) ; $i++ ) {
			$row  = $data[$i];
			$keys = array_keys($row);
			if (count($row) == 1)
				$tmp[$row[$keys[0]]] = $row[$keys[0]];
			else
				$tmp[$row[$keys[0]]] = $row[$keys[1]];
		}
		return $tmp;
	}

	// **************************************************************************
	// 자동 인서트 함수 (연관배열의 키값이 테이블의 필드명과 같아야함)
	// **************************************************************************
	function insertTable($table,$data){
		$fields = $this->get_table_fields($table);
		$data	= array_keys_intersect($data,$fields);
		if (!$table or !is_array($data)) return false;
		$data = quote($data);
		$columns = implode(', ',array_keys($data));
		$values = implode("', '",array_values($data));
		$sql = "INSERT INTO $table ($columns) VALUES ('$values')";
		$this->query($sql);
		return mysql_insert_id();
	}

	// **************************************************************************
	// 자동 인서트 함수 (연관배열의 키값이 테이블의 필드명과 같아야함)
	// **************************************************************************
	function insertSet($table,$data){
		//$fields = $this->get_table_fields($table);
		//$data	= array_keys_intersect($data,$fields);
		//if (!$table or !is_array($data)) return false;
		//$data = quote($data);
		//$columns = implode(', ',array_keys($data));
		//$values = implode("', '",array_values($data));
		$sql = "INSERT INTO $table set $data";
		$this->query($sql);
		return mysql_insert_id();
	}

	// **************************************************************************
	// 자동 업데이트 함수 (연관배열의 키값이 테이블의 필드명과 같아야함)
	// **************************************************************************
	function updateTable($table,$data,$cond=""){
		$fields = $this->get_table_fields($table);
		$data = array_keys_intersect($data,$fields);
		if(!$table or !is_array($data)) return false;
		$data = quote($data);
		foreach ($data as $key=>$value)
			$aTmp[] = $key."='" .$value."'";
		$sql = "UPDATE $table SET ".implode(", ",$aTmp)." $cond";
		return $this->query($sql);
	}

	// **************************************************************************
	// UPDATE, DELETE 에 영향을 받은 행 갯수를 반환 (WHERE절이 없는경우 0)
	// **************************************************************************
	function affected_rows(){
		return mysql_affected_rows();
	}

	// **************************************************************************
	// 에러메시지를 출력하고 스크립트를 종료하는 함수
	// **************************************************************************
	function error(){
		$msg = base64_encode(mysql_error());
		echo mysql_error();
		//redirect("?fd=default&pg=temp&md=dberror&msg=".$msg);
		exit;
	}

	// **************************************************************************
	// 사용자 선택 스킨 가져오기
	// **************************************************************************
	function get_regulation_text($value){
		// 디비 접근 코드 미작성
		$val	= $value;
		return $val;
	}
	 
	// **************************************************************************
	// 샵 상단 디자인 설정 가져오기
	// **************************************************************************
	function get_cate_depth1_name($depth1){
		$row	= $this->result("SELECT cate_name FROM ".SHOP_CATEGORY_TABLE." WHERE depth1='".$depth1."' AND depth2='0' AND depth3='0' AND cate_use='2' ORDER BY position ASC ");
		return $row;
	}
	 
	// **************************************************************************
	// 샵 상단 디자인 설정 가져오기
	// **************************************************************************
	function get_shshop_category(){
		$row	= $this->dfetcharr("SELECT * FROM ".SHOP_CATEGORY_TABLE." WHERE depth2='0' AND depth3='0' AND cate_use='2' ORDER BY position ASC ");
		return $row;
	}
	 
	// **************************************************************************
	// 샵 비주얼 디자인 가져오기
	// **************************************************************************
	function get_shshop_visual(){
		$row	= $this->dfetcharr("SELECT * FROM ".SHOP_DESIGN_VISUAL_TABLE." WHERE visual_use='2' ORDER BY sequence ASC LIMIT 10 ");
		return $row;
	}
	 
	// **************************************************************************
	// 샵 은행정보 가져오기
	// **************************************************************************
	/*
	function get_shshop_bank(){
		$row	= $this->dfetcharr("SELECT * FROM ".SHOP_BANK_TABLE." WHERE bank_use='1' ORDER BY leader_bank_use DESC");
		return $row;
	}*/
	 
	// **************************************************************************
	// 샵 비주얼 디자인 상품 가져오기
	// **************************************************************************
	/*
	function get_main_goods_list($type, $limit){
		
		$table02	= SHOP_BEST_EVENT_GOODS_TABLE;
		$table03	= SHOP_GOODS_TABLE;

		if($type=="best" OR $type=="event"){
			$sql	= "SELECT a.*, b.no as goods_no, b.goods_name, b.goods_code, b.keyword, b.sale_price, b.save_point, b.stock, b.goods_icon, b.goods_feature FROM ".$table02." a 
					   LEFT OUTER JOIN ".$table03." b ON b.no=a.goods_no
					   WHERE a.display = '".$type."' AND b.sale_state<>'4' ORDER BY b.position ASC LIMIT $limit";
			$row	= $this->dfetcharr($sql);
		}else{
			$sql	= "SELECT a.*, no as goods_no FROM ".$table03." a 
					   WHERE a.sale_state<>'4' ORDER BY a.datetime DESC, a.position ASC LIMIT $limit";
			$row	= $this->dfetcharr($sql);

		}
		return $row;
	}*/

	// **************************************************************************
	// 상품분류 설정 정보 가져오기
	// **************************************************************************
	function get_category_info($cate_id){
		$row	= $this->fetcharr("SELECT * FROM ".SHOP_CATEGORY_TABLE." WHERE no='".$cate_id."'");
		return $row;
	}	

	// **************************************************************************
	// 상품 아이콘 정보 가져오기
	// **************************************************************************
	/*
	function get_goods_icon($goods_icon){
		$row	= $this->dfetcharr("SELECT SUBSTRING_INDEX( icon_img, '|', -1 ) icon_img FROM ".SHOP_GOODS_ICON_TABLE." WHERE no IN (".$goods_icon.")");
		return $row;
	}*/




	// **************************************************************************
	// 게시판 설정 정보 가져오기
	// **************************************************************************
	function get_board_set_info($board_id){
		$row	= $this->fetcharr("SELECT * FROM ".BOARD_SET_TABLE." WHERE ename='".$board_id."'");
		return $row;
	}

	// **************************************************************************
	// 회원가입 포인트 설정 정보 가져오기
	// **************************************************************************
	function get_member_join_point(){
		$row	= $this->result("SELECT member_join FROM ".SHOP_POINT_SET_TABLE." WHERE no='1'");
		return $row;
	}

	/***************************************************************************
	* myslq password get (mysql 4.0x 이하 16bytes,  4.1x 이상 41bytes)
	****************************************************************************/
	function get_mysql_password($value){
		$row	= $this->result("SELECT password('$value') as pass ");
		return $row;
	}

	/***************************************************************************
	* 회원정보 가져오기
	****************************************************************************/
	function get_member_info($mem_id){
		$row	= $this->fetcharr("SELECT * FROM ".MEM_TABLE." WHERE mem_id='$mem_id'");
		return $row;
	}


	/***************************************************************************
	* 샵 설정정보 가져오기
	****************************************************************************/
	function get_shop_set_info($table){
		$row	= $this->fetcharr("SELECT * FROM ".$table." WHERE no='1'");
		return $row;
	}

	/***************************************************************************
	* 주문상태 가져오기
	****************************************************************************/
	/*
	function order_state_info($mem_id_session){
		$sql	= "SELECT count(*) cnt,
					SUM(IF(tot_state='1', 1,0)) sum_01, 
					SUM(IF(tot_state='2', 1,0)) sum_02, 
					SUM(IF(tot_state='3', 1,0)) sum_03, 
					SUM(IF(tot_state='4', 1,0)) sum_04, 
					SUM(IF(tot_state='5', 1,0)) sum_05, 
					SUM(IF(tot_state='6', 1,0)) sum_06, 
					SUM(IF(tot_state='7', 1,0)) sum_07, 
					SUM(IF(tot_state='8', 1,0)) sum_08, 
					SUM(IF(tot_state='9', 1,0)) sum_09, 
					SUM(IF(tot_state='10', 1,0)) sum_10, 
					SUM(IF(tot_state='11', 1,0)) sum_11						
					FROM ".SHOP_ORDER_TABLE." WHERE mem_id='".$mem_id_session."' AND SUBSTRING(datetime, 1, 10) > DATE_ADD(NOW(),INTERVAL -1 MONTH)";
		$row	= $this->fetcharr($sql);
		return $row;
	}

	/***************************************************************************
	* 문자발송 내용 가져오기
	****************************************************************************/
	/*
	function sms_contents_info($where){
		$sql	= "SELECT *	FROM ".SHOP_SMS_CONTENTS_TABLE." WHERE ".$where;
		$row	= $this->fetcharr($sql);
		return $row;
	}


	/***************************************************************************
	* 게시판 다음글, 이전글 가져오기
	****************************************************************************/
	function get_prev_next_content($table, $no, $state){
		global $category, $sch_key, $sch_text, $refer, $PHP_SELF;


		$row	= $this->fetcharr("SELECT * FROM ".$table." WHERE no='".$no."'");

		if($cate)		$where[] = "a.category = '$cate'";
		if($sch_key){
			if($sch_key == "a.subject+content"){
				$where[] = "(a.subject LIKE '%$sch_text%' OR a.content LIKE '%$sch_text%')";
			}else{
				$where[] = "$sch_key LIKE '%$sch_text%'";
			}
		}
		if($where)		$swhere	= " AND " . implode(" AND ", $where);

		if($state == "prev"){
			$sql	= "SELECT no FROM ".$table." a WHERE a.num = '".$row[num]."' AND a.reply > '".$row[reply]."' $swhere ORDER BY a.num DESC, a.reply DESC LIMIT 0, 1";
			$prev	= $this->result($sql);
			if(!$prev){
				$sql	= "SELECT no FROM ".$table." a WHERE a.num < '".$row[num]."' $swhere ORDER BY a.num DESC, a.reply ASC LIMIT 0, 1";
				$prev	= $this->result($sql);
			}
			$result		= $prev;
		}

		if($state == "next"){
			$sql	= "SELECT no FROM ".$table." a WHERE a.num = '".$row[num]."' AND a.reply < '".$row[reply]."' $swhere ORDER BY a.num DESC, a.reply DESC LIMIT 0, 1";
			$next	= $this->result($sql);
			if(!$next){
				$sql	= "SELECT no FROM ".$table." a WHERE a.num > '".$row[num]."' $swhere ORDER BY a.num DESC, a.reply DESC LIMIT 0, 1";
				$next	= $this->result($sql);
			}
			$result		= $next;

		}
		
		return $result;
	}
	
} // end of class
?>