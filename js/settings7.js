
$("button[name='add']").click(function(){
	var key1 = $(this).attr('add_key1');
	if(!key1)key1 = -1;
	key1 = parseInt(key1);
	key1++;
	$(this).attr('add_key1', key1);
	var content = `
				<td>
					<input class="form-control" type="text" name="sum[${key1}]" size="4" required  form="form_sim">
					<input type="hidden" name="action[${key1}]" action="action" value="2" form="form_sim">
					<input type="hidden" name="id[${key1}]" value="0" form="form_sim">
				</td>
				<td>
					<input class="form-control" type="text" name="comission[${key1}]" min="0" form="form_sim" required>
				</td>
				<td>
					<button class="btn btn-danger btn-xs" name="del" del_key1="${key1}" onclick="del_btn($(this));" data-toggle="modal" data-target="#myModal_del">Удалить</button>
				</td>
	`;
	
	$(`#add_row`).append(content);
	$(`#add_row`).after('<tr id="add_row1"></tr>');
	$(`#add_row`).attr('id', `add_ch${key1}`);
	$(`#add_row1`).attr('id', `add_row`);
	$("a[href='adm?update=1']").remove();
	
}); 

$("button[name='del']").click(function(){
	var key1 = $(this).attr('del_key1');
	var mark = $(`#add_ch${key1} :first-child :first-child`).val();
	var number = $(`#add_ch${key1} :nth-child(2) :first-child`).val();
	$('#del_info').html("Удаление комиссии: более "+mark+" BCR "+number+"%");
	$('#del_butt').attr("key1", key1);
});

function del_btn(this_btn){
	var key1 = this_btn.attr('del_key1');
	var mark = $(`#add_ch${key1} :first-child :first-child`).val();
	var number = $(`#add_ch${key1} :nth-child(2) :first-child`).val();
	$('#del_info').html("Удаление комиссии: более "+mark+" BCR "+number+"%");
	$('#del_butt').attr("key1", key1);
};

$('#del_butt').on('click', function () {
	var key1 = $(this).attr("key1");
	$('#myModal_del').modal('hide');
	$(`#add_ch${key1}`).css('display', 'none');//$(`#add_ch${key1}`).remove();
	$("a[href='adm?update=1']").remove();
	$(`#add_ch${key1} input[action='action']`).val('3');
});

$('#send_butt').on('click', function () {
	$('#myModal_save').modal('hide');
	$("#form_sim").submit();
});

$("table").find('input').change(function(){
	var key1 = $(this).parents("tr").attr('key1');
	
	if($(`#add_ch${key1} input[action='action']`).val() < 1){
		$(`#add_ch${key1} input[action='action']`).val('1');
	}
});
