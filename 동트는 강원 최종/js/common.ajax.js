var mem_id_check = function() {

    var result	= "";
	var data	= "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_proc.php",
		dataType: "json",
		//contentType: "application/json; charset=utf-8",
        data: {
            "state"  : "member_id_check",
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
	$("#msg_mem_id").html(result.html);
    return result;
}


var mem_nick_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_proc.php",
		dataType: "json",
        data: {
            "state"  : "member_nick_check",
            "mem_nick": ($("#mem_nick").val()),
            "mem_id": encodeURIComponent($("#mem_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
	$("#msg_mem_nick").html(result.html);
    return result;
}


var mem_email_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_proc.php",
		dataType: "json",
        data: {
            "state"  : "member_email_check",
            "mode"  : $("#state").val(),
            "mem_email1": $("#mem_email1").val(),
            "mem_email2": $("#mem_email2").val(),
            "mem_id": encodeURIComponent($("#mem_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
	$("#msg_mem_email").html(result.html);
    return result;
}


var mem_hp_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_proc.php",
		dataType: "json",
        data: {
            "state"  : "member_hp_check",
            "mem_hp1": $("#mem_hp1").val(),
            "mem_hp2": $("#mem_hp2").val(),
            "mem_hp3": $("#mem_hp3").val(),
            "mem_id": encodeURIComponent($("#mem_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
	$("#msg_mem_hp").html(result.html);
    return result;
}

// 상품 옵션2 값 가져오기
var get_goods_option2 = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_proc.php",
		dataType: "json",
        data: {
            "state"  : "get_goods_option2",
            "goods_no": $("#goods_no").val(),
            "option1": $("#option1").val()
        },
        cache: false,
        async: false,
        success: function(data){
            result = data;
        }
    });
	$("#option2").html("<option value=''>선택</option>"+result);
    return result;
}


// 추천인 검사
var mem_recommend_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: "../lib/ajax_proc.php",
		dataType: "json",
        data: {
            "state"  : "member_recommend_check",
            "mem_recommend": $("#mem_recommend").val(),
            "mem_id": encodeURIComponent($("#mem_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
	$("#msg_mem_recommend").html(result.html);
    return result;
}