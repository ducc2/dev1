function shareContent(sns) {

	switch(sns){
		case "facebook":
			FB.init({
				appId            : '775821239418124',
				autoLogAppEvents : true,
				xfbml            : true,
				version          : 'v3.2'
			});

			FB.getLoginStatus(function(response) {
    			statusChangeCallback(response);
			});
		break;
		case "kakao":
			// Kakao는 띠로 ..
		break;
		case "naver":
			var url = encodeURI(encodeURIComponent(window.location.href));
			var title = encodeURI($('#content_title').html() );
			var shareURL = "https://share.naver.com/web/shareView.nhn?url=" + url + "&title=" + title;
			window.open(shareURL,'_blank');
			//document.location = shareURL;
		break;
	}
}


//Facebook
function shareFacebook() {
	FB.ui({
		method: 'share',
		href: window.location.href

	},function(response) {
		console.log(response);
		if (response && !response.error_message) {
			
			var url = "/v1/pet/api/kakao/callback";
			var datas = "channel_id="+channel_id+"&content_id="+content_id + "&user_id=" + user_id + "&share_type=facebook";

			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    			type: 'POST',
    			url: url,
    			data: datas,
    			dataType: 'json',
    			success: function(data){ 
    				console.log(data);
    			}
			});

		} else {
			console.log('실패');
		}
	});
}
//Facebook
function statusChangeCallback(response) {
	if (response.status === 'connected') {
    	shareFacebook();
    } else {
    	FB.login(function(data){
  			// console.log("statusChangeCallback");
  			// console.log(data);
		},{scope: 'public_profile,email',return_scopes: true});
    }
}


