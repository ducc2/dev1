
// *************************************************************
// 2차 상품분류 가져오기
// *************************************************************
var get_cate_depth2 = function() {
    var result = "";	
	$("#select2").html(result);
	$("#select3").html(result); 

    $.ajax({
        type: "POST",
        url: "../lib/ajax_cate_get_proc.php",
        data: {
            "state"  : "get_cate_depth2",
            "select1" : encodeURIComponent($("#select1").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });
	$("#select2").html(result);
    return result;
}

// *************************************************************
// 3차 상품분류 가져오기
// *************************************************************
var get_cate_depth3 = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_cate_get_proc.php",
        data: {
            "state"  : "get_cate_depth3",
            "select1" : encodeURIComponent($("#select1").val()),
            "select2" : encodeURIComponent($("#select2").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });
	$("#select3").html(result); //alert(result);
    return result;
}


// *************************************************************
// 2차 상품분류 가져오기
// *************************************************************
var get_cate_style2_depth2 = function() {
    var result = "";	
	$("#select2").html(result);
	$("#select3").html(result); 

    $.ajax({
        type: "POST",
        url: "../lib/ajax_cate_get_proc.php",
		dataType: "html",
        data: {
            "state"  : "get_cate_style2_depth2",
            "select1" : encodeURIComponent($("#select1").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });
	$("#select2").html(result);
    return result;
}

// *************************************************************
// 3차 상품분류 가져오기
// *************************************************************
var get_cate_style2_depth3 = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_cate_get_proc.php",
        data: {
            "state"  : "get_cate_style2_depth3",
            "select1" : encodeURIComponent($("#select1").val()),
            "select2" : encodeURIComponent($("#select2").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });
	$("#select3").html(result); //alert(result);
    return result;
}



// *************************************************************
// SHOPUP 2차 상품분류 가져오기
// *************************************************************
var get_cate_style_shopup_depth2 = function() {
    var result = "";	
	$("#shopup_select2").html(result);
	//$("#shopup_select3").html(result); 

    $.ajax({
        type: "POST",
        url: "../lib/ajax_cate_get_proc_shopup.php",
		dataType: "html",
        data: {
            "state"  : "get_cate_style2_depth2",
            "select1" : encodeURIComponent($("#shopup_select1").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });
	$("#shopup_select2").html(result);
    return result;
}

// *************************************************************
// SHOPUP 3차 상품분류 가져오기
// *************************************************************
var get_cate_style_shopup_depth3 = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_cate_get_proc_shopup.php",
        data: {
            "state"  : "get_cate_style2_depth3",
            "select1" : encodeURIComponent($("#shopup_select1").val()),
            "select2" : encodeURIComponent($("#shopup_select2").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });
	$("#shopup_select3").html(result); //alert(result);
    return result;
}

// *************************************************************
// 상품옵션 삭제
// *************************************************************
var get_goods_option_del = function(getUrl) {
    var result = "";
    $.ajax({
        type: "GET",
        url: getUrl,
        data: {
            "state"  : "get_cate_style2_depth3",
            "select1" : encodeURIComponent($("#select1").val()),
            "select2" : encodeURIComponent($("#select2").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });
	//$("#select3").html(result); //alert(result);
    return result;
}


// *************************************************************
// 상품옵션 삭제
// *************************************************************
var mem_info_get = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_admin_proc.php",
        data: {
            "md"  : "mem_info_get",
            "mem_id" : encodeURIComponent($("#mem_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });

	var getData		= result.split("@@");
	if(getData[0]=="false"){
		alert("등록된 회원이 없습니다.");
	}else{	
		$("#mem_no").val(getData[1]); 
		$("#mem_id").val(getData[2]); 
		$("#mem_name").val(getData[3]); 
	}
}



// *************************************************************
// 상품 요약정보(고시) 샘플 가져오기
// *************************************************************
var get_sample_goods_summary = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_admin_proc.php",
        data: {
            "md"  : "get_sample_goods_summary",
            "mem_id" : encodeURIComponent($("#mem_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },		
		error: function() {
			alert(data);
		},
    });
	oEditors.getById["goods_summary"].exec("PASTE_HTML", [result]); 
	//$("#goods_summary").val(result);
	//document.getElementById("goods_summary").value	= result;alert(document.getElementById("goods_summary").value);
}


// *************************************************************
// url의 프로그램 실행결과를 비동기식으로 리턴한다.
// *************************************************************
function getAjax(url){
	var xmlhttp;
	if(xmlhttp && xmlhttp.readyState!=0){
		xmlhttp.abort();
	}try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(e){
			xmlhttp = false;
		}
	}
	if(!xmlhttp && typeof XMLHttpRequest!=UD) _req = new XMLHttpRequest();
	if(xmlhttp){
		xmlhttp.open("GET", url, false);
		xmlhttp.send(null);
	}
	return result = xmlhttp.readyState == 4 ? xmlhttp.responseText : "";
}