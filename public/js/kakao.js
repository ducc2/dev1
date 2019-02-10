Kakao.init('02a51dc0b1b510d78290f53d8dbc1151');

Kakao.Link.createDefaultButton({

	container: '#kakao-link-btn',
    objectType: 'feed',
	content: {
		title: content_title,
		description: kakaoTag,
		imageUrl: content_img,
		link: {
			webUrl: document.location.href,
			mobileWebUrl: document.location.href
		}
	},
	social: {
		likeCount: likeCnt,
		commentCount: 0,
		sharedCount: 0
	},buttons: [
		{
			title: '웹으로 보기',
			link: {
				mobileWebUrl: document.location.href,
				webUrl: document.location.href
			}
		},
		{
			title: '앱으로 보기',
			link: {
				mobileWebUrl: document.location.href,
				webUrl: document.location.href
			}
		}
	],serverCallbackArgs: '{"channel_id":'+channel_id+',"content_id":' + content_id + ',"user_id":' + user_id + ',"share_type":"kakao"}'// 콜백 파라미터 설정
	
});

//카카오 스토리
function kakaoStory() {
	Kakao.Story.share({
		text: kakaoTag,
		url: document.location.href
	});
}