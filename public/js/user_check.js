function userDoCheck(checkboxitem, ob)
{
	if (ob.prop('checked'))
		checked = 1;
	else
		checked = 2;

    var info = [];
    info.push({name: 'checkboxitem_id' , value : checkboxitem});
    info.push({name: 'checked' , value : checked});
    info.push({name: 'parent_id' , value : ob.data('parent_id')});

    var data_to_send =[];
    data_to_send.push({info});

	$.ajax({
	    type: "POST",
	    url: ob.data('href'),
	    dataType: "json",
	    data: {data_to_send}
	})
	.done(function(data){
	    console.log(data);
	})
}
