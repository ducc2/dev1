
App = {
 
	init: function() {
	/**
	 * jQuery toast lib 
	 * @param : -
	 * @return : -
	*/		
		$.toast.config.align = 'center';
    	$.toast.config.width = 400;
	},

	/**
	 * json RPC Ajax
	 * @param : url,datas
	 * @return : JSON data;
	*/
	ajaxFun:function(url,datas,method) {
		//데이터 체크 
		if(!datas) throw new Error([ 'Empty datas !'  ]);
		if(!url) throw new Error([ 'Empty url !'  ]);
		
		$.ajax({
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    		type: 'POST',
    		url: url,
    		data: datas,
    		dataType: 'json',
    		success: function(data){ 
    			App.ajaxSuccess(data,method);
    		},
    		error: function (jqXHR, exception) {
        		var msg = '';
        		if (jqXHR.status === 0) {
            		msg = 'Not connect.\n Verify Network.';
        		}else if (jqXHR.status == 404) {
            		msg = 'Requested page not found. [404]';
        		}else if (jqXHR.status == 500) {
            		msg = 'Internal Server Error [500].';
        		}else if (exception === 'parsererror') {
            		msg = 'Requested JSON parse failed.';
        		}else if (exception === 'timeout') {
            		msg = 'Time out error.';
        		}else if (exception === 'abort') {
            		msg = 'Ajax request aborted.';
        		}else {
            		msg = 'Uncaught Error.\n' + jqXHR.responseText;
        		}
        		if (!App.checkParam(null,msg) ) throw new Error([ msg ]);
        		
    		},
		});
	},
	/*
	 * Ajax Success
	 * @param : data,method
	*/
	ajaxSuccess: function(data,method) {
		console.log(data);
		var t = 'success';
		switch(method) {
			// json RPC Send 
			case "send":
				//console.log(data);
				var msg = "";
				if(data.err == "" || data.err ==null) {
					msg = "금액 : " + data.details[0].amount + " 전송 \n 수수료 : " + data.details[0].fee + " \n주소 : " + data.details[0].address;
				}else {
					msg = "전송 실패";
					t = 'danger';
					console.log(data.err);
				}
				//App.desktopNotify(msg);
				App.toastMsg(msg,t);
				break;
			//잔액 조회
			case "balance":
				break;
			//주소 조회
			case "address":
				break;
			//거래 내역 조회
			case "listTransactions":
				break;
			//거래 조회 (단일)
			case "getTransaction":
				break;
			default:
				break;
		}
	},
	/**
	 * json RPC Sendfrom
	 * @param : to,from,amount
	 * @return : txhash;
	*/
	sendfrom: function() {
		var to = $('#to').val();
		var amount = $('#amount').val();
		if (!App.checkParam(to,"이메일 혹은 지갑 주소를 넣어주세요.") ) throw new Error([ 'to address check - sendfrom:toAddress'  ]);
		if (!App.checkParam(amount,"금액을 입력해주세요.") ) throw new Error([ 'to amount check - sendfrom:amount'  ]);
		/* 여기서 회원 이메일 검증 필요 */
		/* 여기서 회원 잔액 검증 필요 */
		var datas = $('#sendForm').serialize();
		App.ajaxFun("/wallet/rpc/sendfrom",datas,"send");

	},	
	/**
	 * json RPC Get balance
	 * @param : account
	 * @return : balance;
	*/
	getBalance: function(account) {	
		if (!App.checkParam(account,"Email Check.") ) throw new Error([ 'Email check - getBalance:account '  ]);
		App.ajaxFun("/v1/api/rpc/userbalance/" + account,account,"balance");
	},
	/**
	 * json RPC Get address
	 * @param : account
	 * @return : address;
	*/
	userAddress: function(account) {
		if (!App.checkParam(account,"Email Check.") ) throw new Error([ 'Email check - userAddress:account'  ]);
		App.ajaxFun("/v1/api/rpc/useraddress/" + account,account,"address");
	},
	/**
	 * json RPC Get transaction
	 * @param : txhash
	 * @return : array;
	*/
	getTransaction: function(txhash) {
		if (!App.checkParam(txhash,"txhash Check.") ) throw new Error([ 'txhash check - getTransaction:txhash'  ]);
		App.ajaxFun("/v1/api/rpc/transactionDetail/" + txhash,txhash,"getTransaction");
	},
	/**
	 * json RPC list transactions
	 * @param : account
	 * @return : list
	*/
	listTransactions: function(account) {
		if (!App.checkParam(account,"Email Check.") ) throw new Error([ 'Email check - listTransactions:account'  ]);
		App.ajaxFun("/v1/api/rpc/listTransactions/" + account,account,"listTransactions");
	},
	/**
	 * QR Code Generate
	 * @param : address,width,height
	 * @return : -;
	*/
	qrCode:function(address,w=150,h=150) {
		
		var qrcode = new QRCode(document.getElementById("qrcode"), {
			text: address,
			width: w,
			height: h,
			colorDark : "#000000",
			colorLight : "#ffffff",
			correctLevel : QRCode.CorrectLevel.H
		});
	},
	/**
	 * Check
	 * @param : param,msg
	 * @return : bool;
	*/
	checkParam:function(param,msg) {
		if (param == "" || param == null) {
			App.toastMsg(msg,"danger");
			return false;
		}else {
			return true;
		}
	},

	viewAmount:function() {
		var returnAmount = $('#returnAmount').val();
	},
	/**
	 * jQuery toast msg 
	 * @param : msg,type
	 * @return : null;
	*/
	toastMsg:function(msg,t) {
		$.toast(msg, {
			//sticky: true, //close msg
			duration: 4500,
			type: t //danger,info,success
		});
	},
	desktopNotify:function(msg) {
		if (!("Notification" in window)) {
			App.toastMsg(msg,"success");
		}else if (Notification.permission === "granted") {
			var notification = new Notification(msg);
		}else if (Notification.permission !== 'denied') {
			Notification.requestPermission(function (permission) {
				if(!('permission' in Notification)) {
					Notification.permission = permission;
				}

				if (permission === "granted") {
					var notification = new Notification(msg);
				}else {
					App.toastMsg(msg,"success");
				}
			});
		}
	}
};