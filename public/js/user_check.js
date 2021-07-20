function userDoCheck(checkboxitem, ob)
{
    var info = [];
    if(!ob.data('parent')){
        id_parent = ob.data('num');
        is_checked = ob.prop('checked');

        info.push({'checkboxitem_id': ob.data('num'), 'checked': is_checked});

        $('input[data-parent="'+id_parent+'"]').each(function(index, value) {
            $(this).prop('checked', is_checked);
            info.push({'checkboxitem_id': $(this).data('num'), 'checked': is_checked});

        });
        $('#collapse_'+id_parent).collapse('show');
    }else{
        info.push({'checkboxitem_id': ob.data('num'), 'checked': ob.prop('checked')});

        id_parent = ob.data('parent');
        count_checked = $('input[data-parent="'+id_parent+'"]:checkbox:checked').length;
        count_all = $('input[data-parent="'+id_parent+'"]:checkbox').length;

        is_parent_checked = (count_checked == count_all);
        if($('input[data-num="'+id_parent+'"]').prop('checked')!=is_parent_checked){
            $('input[data-num="'+id_parent+'"]').prop('checked', is_parent_checked);
            info.push({'checkboxitem_id': id_parent, 'checked': is_parent_checked});
            $('#collapse_'+id_parent).collapse('show');
        }
    }

	$.ajax({
	    type: "POST",
	    url: ob.data('href'),
	    dataType: "json",
	    data: { myData : JSON.stringify({info})}
	})
	.done(function(data){
	    console.log(data);
	})
}
