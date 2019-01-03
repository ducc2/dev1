		
	var delayID = "";	
	var delayTime = 200;	// �쒕젅�대맆 �쒓컙 

	var searchInputID = "searchItem";		//�명뭼 諛뺤뒪 �꾩씠��
	var resultPanelID = "search_List";	//寃곌낵 由ъ뒪�� 遺�紐� �섎━癒쇳듃 �꾩씠��
	var searchGetListFileName = "/ext/getProductName.asp";	//�낅젰 寃곌낵 泥섎━�� �뚯씪 寃쎈줈, �대쫫
	var serchPageUrl = "/search/search_result.asp";	//寃��됯껐怨� �섏씠吏�
	var serachVariableName = "searchItem";	//蹂��섎챸

	var highlightHtml = '<span class="pcolor3"><@text@></span>';  // 媛뺤“�� �ㅼ썙�� HTML, �띿뒪�� �ㅼ뼱媛� 遺�遺� -->> <@text@>
	var searchItemHtml = '<li><a href="javascript:void(0);"><@text@></a></li>';	//由ъ뒪�� HTML, �띿뒪�� �ㅼ뼱媛� 遺�遺� -->> <@text@>
						//<li><a><span class="pcolor3">媛뺤“�� �ㅼ썙��</span>�섎㉧吏� �ㅼ썙��</a></li> - �뺥깭濡� ��
	

	jQuery(document).ready(function() {
		var panelObj = jQuery("#" + resultPanelID);
		var inputObj = jQuery("#" + searchInputID);

		//hidepanel();

		jQuery("*:not(#" + searchInputID + ", #" + resultPanelID + ")").click(function(){ hidepanel(); });
	
		inputObj.keydown(function(e){
			var position = panelObj.find("li.on").index();
			var resultLength = panelObj.find("li").length - 1;

			var pressCode = e.keyCode;

			//if ( pressCode == 37 || pressCode == 38 || pressCode == 39 || pressCode == 40 ) {
				if ( pressCode == 38 || pressCode == 40 ) {
				
				//if (pressCode == 37 || pressCode == 38 ) position--;
				//if (pressCode == 39 || pressCode == 40 ) position++;

				if ( pressCode == 38 ) position--;
				if ( pressCode == 40 ) position++;

				if ( position < 0 ) position = resultLength;
				if ( position > resultLength ) position = 0;

				panelObj.find("li").removeClass("on");
				panelObj.find("li:nth("+ position +")").addClass("on");
				inserttext(panelObj.find("li.on").text(), 1);
			}else if ( pressCode == 13 ){	// �뷀꽣�� - �꾩옱 �숈옉 �덊븿
			}else if ( ( pressCode == 8 ) || ( pressCode == 46 ) || ( pressCode >= 48 && pressCode <= 57 ) || ( pressCode >= 65 && pressCode <= 90 )   ){ // backspace, delete, �レ옄, �곷Ц
				getWord();
			}
		}).focus(function(){ 
			if ( inputObj.attr("data-val") == inputObj.val() && inputObj.val() != "" ) { inputObj.val(''); }
			//if ( inputObj.val() != "")	{ getWord(); } 
		}).blur(function(){
			if ( inputObj.val() == "" ) { inputObj.val(inputObj.attr("data-val")); }		
		});
		
		function getWord(){
			clearTimeout(delayID);
			delayID = setTimeout(function(){
				if ( inputObj.val() != ""){

					jQuery.ajax(searchGetListFileName + "?getword="+escape(inputObj.val()), {
						success: function(data){
							var addHtmlText ="" ;
							result_ajax = eval(data);
						
							for( var i = 0 ; i <=  result_ajax.length-1  ; i++ ){
								var pattern_temp = "^" + inputObj.val();
								var pattern = new RegExp(pattern_temp,'gi');
							
								var text =  result_ajax[i].name; 
								var matchText =  pattern.exec(text); //留ㅼ묶�� �⑥뼱

								var resultItem = text.replace(pattern, highlightHtml.replace("<@text@>", matchText));
								addHtmlText += searchItemHtml.replace("<@text@>", resultItem);
							}

							if (addHtmlText){
								panelObj.html('<ul>' + addHtmlText + '</ul>');
								panelObj.show();
								
								//�⑥뼱 �대┃, 留덉슦�� �ㅻ쾭�� 諛깃렇�쇱슫�쒖쿂由� -->>
								panelObj.find("li").hover(
									function(){ panelObj.find("li").removeClass("on"); jQuery(this).addClass("on"); },
									function(){ jQuery(this).removeClass("on"); }
								).click(function(){	
									inserttext(jQuery(this).text(), 0);  
									var searchText = jQuery(this).text();	
									if ( searchText == "" )	{ searchText = inputObj.val(); 	}
									if ( inputObj.val() != "" ) { 
										location.href = serchPageUrl + "?" +  serachVariableName + "=" + searchText;
									} 
								})
								// <<-- �⑥뼱 �대┃, 留덉슦�� �ㅻ쾭�� 諛깃렇�쇱슫�쒖쿂由� 

							}else if(addHtmlText == ""){
								hidepanel();
							}
						}	//success: function(
					})	//jQuery.ajax(
			
				}else{
					hidepanel();
				}
			}, delayTime);
		};

		function hidepanel(){
			var panelObj = jQuery("#" + resultPanelID);	
			var inputObj = jQuery("#" + searchInputID);
			panelObj.hide();
			panelObj.html('');
		};

		function inserttext(val, no){
			var panelObj = jQuery("#" + resultPanelID);
			var inputObj = jQuery("#" + searchInputID);
			if (val != ""){
				inputObj.val(val);
				if ( no == 0){ panelObj.hide(); panelObj.html(''); }
			}else{
				//inputObj.val(inputObj.val());
			}
		};

	});