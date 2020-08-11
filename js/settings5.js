$('a[akcion=1]').each(function() {
        $(this).on('click', function () {
            user_id = $(this).html();
			$.get('../ajax/user_info.php?user_id='+user_id, function(data) {
				var user = jQuery.parseJSON(data);
				var bankomats = jQuery.parseJSON(user[16]);
				var link_card = '<a href=?card_id='+user[0]+'>'+user[1]+'</a>';
				var link_ip = '<a href=https://yandex.ru/search/?text='+user[22]+' target=_blank>'+user[22]+'</a>';
				//alert(data);
				//$('#user_info1').html(data);
				$('#user_info tr:nth-child(2) td:nth-child(2)').html(user[0]);
				$('#user_info tr:nth-child(3) td:nth-child(2)').html(link_card);
				$('#user_info tr:nth-child(4) td:nth-child(2)').html(link_ip);
				$('#user_info tr:nth-child(5) td:nth-child(2)').html(user[2]+'/'+user[3]);
				$('#user_info tr:nth-child(6) td:nth-child(2)').html(user[5]);
				$('#user_info tr:nth-child(7) td:nth-child(2)').html(user[6]);
				$('#user_info tr:nth-child(8) td:nth-child(2)').html(user[7]);
				$('#user_info tr:nth-child(9) td:nth-child(2)').html(user[8]);
				$('#user_info tr:nth-child(10) td:nth-child(2)').html(user[9]);
				$('#user_info tr:nth-child(11) td:nth-child(2)').html(user[10]);
				$('#user_info tr:nth-child(12) td:nth-child(2)').html(user[11]);
				$('#user_info tr:nth-child(13) td:nth-child(2)').html(user[16]);
				$('#user_info tr:nth-child(14) td:nth-child(2)').html(user[17]+' '+user[18]+' '+user[19]);
				$('#user_info tr:nth-child(15) td:nth-child(2)').html(user[20]);
				$('#user_info tr:nth-child(16) td:nth-child(2)').html(user[26]);
				$('#user_info tr:nth-child(17) td:nth-child(2)').html(user[27]);
				$('#user_info tr:nth-child(18) td:nth-child(2)').html(user[28]);
				$('#user_info tr:nth-child(19) td:nth-child(2)').html(user[30]);
                $('#user_info tr:nth-child(20) td:nth-child(2)').html(user[24]);
			});
        });
    });
    
    function user_info(this_html){
		user_id = this_html.html();

		$.get('../ajax/user_info.php?user_id='+user_id, function(data) {
			var user = jQuery.parseJSON(data);
			var bankomats = jQuery.parseJSON(user[16]);
			var link_card = '<a href=?card_id='+user[0]+'>'+user[1]+'</a>'
			var link_ip = '<a href=https://yandex.ru/search/?text='+user[22]+' target=_blank>'+user[22]+'</a>';
			$('#user_info tr:nth-child(2) td:nth-child(2)').html(user[0]);
			$('#user_info tr:nth-child(3) td:nth-child(2)').html(link_card);
			$('#user_info tr:nth-child(4) td:nth-child(2)').html(link_ip);
			$('#user_info tr:nth-child(5) td:nth-child(2)').html(user[2]+'/'+user[3]);
			$('#user_info tr:nth-child(6) td:nth-child(2)').html(user[5]);
			$('#user_info tr:nth-child(7) td:nth-child(2)').html(user[6]);
			$('#user_info tr:nth-child(8) td:nth-child(2)').html(user[7]);
			$('#user_info tr:nth-child(9) td:nth-child(2)').html(user[8]);
			$('#user_info tr:nth-child(10) td:nth-child(2)').html(user[9]);
			$('#user_info tr:nth-child(11) td:nth-child(2)').html(user[10]);
			$('#user_info tr:nth-child(12) td:nth-child(2)').html(user[11]);
			$('#user_info tr:nth-child(13) td:nth-child(2)').html(user[16]);
			$('#user_info tr:nth-child(14) td:nth-child(2)').html(user[17]+' '+user[18]+' '+user[19]);
			$('#user_info tr:nth-child(15) td:nth-child(2)').html(user[20]);
			$('#user_info tr:nth-child(16) td:nth-child(2)').html(user[26]);
			$('#user_info tr:nth-child(17) td:nth-child(2)').html(user[27]);
			$('#user_info tr:nth-child(18) td:nth-child(2)').html(user[28]);
			$('#user_info tr:nth-child(19) td:nth-child(2)').html(user[30]);
			$('#user_info tr:nth-child(20) td:nth-child(2)').html(user[24]);
		});
	}
	
	//проверка новых транзакций
	setInterval(function(){
		$.get('../ajax/user_info.php?trans_all='+window.trans_all, function(data) {
			var trans_new = jQuery.parseJSON(data);
			if(trans_new[0] != 'n'){
				//window.trans_all = window.trans_all + trans_new.length - 1;
				for(i = 0; i <= trans_new.length-2; i++){
						var html_inc =
						`<tr>
							<td>${trans_new[i]['id']} <span class="label label-danger">new</span></td>
							<td><a onclick="user_info($(this))" href="javascript:;" data-toggle="modal" data-target="#myModal_info" name="butt_issuse">${trans_new[i]['fromid']}</a></td>
							<td><a onclick="user_info($(this))" href="javascript:;" data-toggle="modal" data-target="#myModal_info" name="butt_issuse">${trans_new[i]['toid']}</a></td>
							<td>${trans_new[i]['sum']}</td>
							<td>${trans_new[i]['timestamp']}</td>
							<td>${trans_new[i]['comment']}</td>
							<td>${trans_new[i]['iswithdraw']}</td>
							<td>${trans_new[i]['bankomat']}</td>
						  </tr>`;
						$(html_inc).insertAfter('#transaction tr:nth-child(3)');
						console.log("trans_new[i][id]: "+trans_new[i]['id']);
				}
				i--;
				window.trans_all = trans_new[i]['id'];
				console.log("window.trans_all: "+window.trans_all);	
			}
		});
		
	}, 300000);
