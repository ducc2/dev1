var ajaxFileUpPrc ;

function uploadChk(getType,fileName) {

	//로그인 했으면
	if(userChk.login) {
		if (userChk.channel) {
			if (getType == "close"){
				$("#"+fileName).val("");
			//파일 업로드 시작
			}else {
				//파일 업로드
				$("#uploadFile:hidden").trigger('click');
			}
		//채널이 없으면
		}else {
			toastMsg("채널을 만드세요.","warning");
			return false;
		}
	//로그인 안했으면
	}else {
		toastMsg("로그인하세요.","warning");
		return false;
	}
}
//파일 업로드
function fileUpload() {

	$('#commonProgress').hide();

	//upload file
	var file = $("#uploadFile")[0].files[0];
	var mode = $('#mode').val();


	if ( !fileSizeChk(file) ) {
    	toastMsg("첨부파일 사이즈는 200MB 이내로 등록 가능합니다.","danger");
    	return false;
    }
    //모달
    getModalOpen('commonModal');

    $('#commonFileName').html(file.name);

	//Form
	var formdata = new FormData();
		formdata.append("channelFile", file);
		formdata.append("mode",mode);
		formdata.append("_token", $('meta[name="csrf-token"]').attr('content'));

	switch(mode) {
		case 'modify':
			formdata.append("content_id",$('#content_id').val() );
			break;
	}

	//var ajax = new XMLHttpRequest();
	ajaxFileUpPrc = new XMLHttpRequest();
	if(document.getElementById("uploadFile").files.length != 0){
		//$('#commonProgress').show();
		ajaxFileUpPrc.upload.addEventListener("progress", fileProgressHandler, false);
	}
	ajaxFileUpPrc.addEventListener("load", fileCompleteHandler, false);
	ajaxFileUpPrc.addEventListener("error", fileErrorHandler, false);
	ajaxFileUpPrc.addEventListener("abort", fileAbortHandler, false);

	// Create some variables we need to send to our PHP file
	var url = "/channel/upload";
	ajaxFileUpPrc.open("POST", url, true);
	// Send the data to PHP now... and wait for response to update the status div
	ajaxFileUpPrc.send(formdata);
}

function fileUploadCancel() {

	if ( confirm("업로드를 취소하시겠습니까 ?") == true ) {
		//console.log("Ajax Cancel");
		ajaxFileUpPrc.abort();
		$('#uploadFile').val('');
		document.getElementById('commonModal').style.display = "none";
	}

}

//게시하기
function submitContent(getType) {
	var flag = '';
	var msg = '';
	var reward = '';
	var content_title = $('#content_title').val(); //타이틀
	var content_desc = $('#content_desc').val(); //내용
	var content_id = $('#content_id').val(); //내용

	switch(getType) {
		case 'save': //등록 저장
			flag = 1;
			msg = '정상적으로 저장되었습니다.';
			reward = 1;
			if (!checkParams(content_title,"제목을 입력해주세요.") ) throw new Error([ "제목을 입력해주세요." ]); //채널명이 없을 경우 ..
			if (!checkParams(content_desc,"내용을 입력해주세요.") ) throw new Error([ "내용을 입력해주세요." ]); //채널명이 없을 경우 ..
			if (!checkParams(content_id,"영상 혹은 이미지를 입력해주세요.") ) throw new Error([ "영상 혹은 이미지를 입력해주세요." ]); //채널명이 없을 경우 ..
			break;
		case 'tempSave': //등록 - 임시 저장
			flag = 0;
            msg = '정상적으로 저장되었습니다.';
            if (!checkParams(content_id,"영상 혹은 이미지를 입력해주세요.") ) throw new Error([ "영상 혹은 이미지를 입력해주세요." ]); // 2019-01-22 박지연 추가
			break;
		case 'modify': //수정 - 저장 이미 게시한 콘텐츠
			if (!checkParams(content_title,"제목을 입력해주세요.") ) throw new Error([ "제목을 입력해주세요." ]); //채널명이 없을 경우 ..
			if (!checkParams(content_desc,"내용을 입력해주세요.") ) throw new Error([ "내용을 입력해주세요." ]); //채널명이 없을 경우 ..
			flag = 1;
			msg = '정상적으로 수정되었습니다.';
			break;
		case 'tempModify': //수정 - 임시 저장 게시 안한 이미지 혹은 영상 수정 가능
			if (!checkParams(content_title,"제목을 입력해주세요.") ) throw new Error([ "제목을 입력해주세요." ]); //채널명이 없을 경우 ..
			if (!checkParams(content_desc,"내용을 입력해주세요.") ) throw new Error([ "내용을 입력해주세요." ]); //채널명이 없을 경우 ..
			if (!checkParams(content_id,"영상 혹은 이미지를 입력해주세요.") ) throw new Error([ "영상 혹은 이미지를 입력해주세요." ]); //채널명이 없을 경우 ..
			flag = 0;
			msg = '정상적으로 수정되었습니다.';
			break;

	}


	if(!userChk.login) throw new Error([ "Login" ])


	var url = "/channel/modify";
	var datas = $('#contentAddForm').serialize() + '&reward='+reward+'&flag=' + flag;
	//var datas = "content_id="+content_id+"&content_title="+content_title+"&content_tag="+content_tag+"&content_desc="+content_desc;

	ajaxSubmit(url,datas,msg);

}
function ajaxSubmit(url,datas,msg) {
    showSpinner();
	$.ajax({
		type : 'post',
		url : url,
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data : datas,
		dataType : 'json',
		success : function (data) {
            hiddenSpinner();
			//console.log(data);
			//return false;
			$('#submitAlertMsg').html(msg);
			confirmModal("submitAlert",'');
			if(data >0) {
				toastMsg(data+'CENT를 받았습니다.','success');
				//location.replace('');
			}
		}
	});
}


function fileProgressHandler(event) {
	$('#progressFileSize').html( formatBytes(event.loaded) ); //현재 파일 전송 크기
	$('#progressFileTotalSize').html( formatBytes(event.total) ); //총 파일 크기
    var percent = (event.loaded/event.total) * 100;
    //$('#commonProgress').val(Math.round(percent));
    $('#commonStatus').html( Math.round(percent) + " % 업로드...." );
}

function fileCompleteHandler(event) {
    var percent = 100;

    $('#commonProgress').val(Math.round(percent));

    var result = $.parseJSON(event.target.responseText);

    //성공이면
    if (result.err) {

        $('#content_id').val(result.id);
        $('.imgLi').toggle();
        $('.ajaxLoading').show();
        if (result.type == "img") {
            $('#content_imgUpload').show();
            $('#content_imgUpload').attr("src", "https://s3.ap-northeast-2.amazonaws.com/ohwe" + result.thumnail);
        }else {
        	//썸네일 이미지면 ..
        	$('#content_imgUpload').show();
            $('#content_imgUpload').attr("src", "https://s3.ap-northeast-2.amazonaws.com/ohwe" + result.thumnail);
        	//동영상 태그
            //$('#content_videoUpload').show();
            //$("#content_videoUpload").html('<source src="https://s3.ap-northeast-2.amazonaws.com/ohwe' + result.thumnail + '" type="video/mp4"></source>' );


        }
        document.getElementById('commonModal').style.display = "none";
    }else {
    	toastMsg(result.msg);
    	//$('#submitAlertMsg').html("잘못된 확장자 또는 파일입니다.");
    	//confirmModal("submitAlert",'');
    	document.getElementById('commonModal').style.display = "none";
    }
    //$('#status').html( event.target.responseText );
    //$('#fileSubmit').show();
    if ($.parseJSON(event.target.responseText).err == true) {

    }
    //$('#commonProgress').hide();
}

function fileErrorHandler(event) {
    $('#status').html( "업로드 실패" );
}

function fileAbortHandler(event) {
    $('#status').html( "업로드 중단" );
}

function formatBytes(bytes) {
    if(bytes < 1024) return bytes + " Bytes";
    else if(bytes < 1048576) return(bytes / 1024).toFixed(3) + " KB";
    else if(bytes < 1073741824) return(bytes / 1048576).toFixed(3) + " MB";
    else return(bytes / 1073741824).toFixed(3) + " GB";

};
