jQuery('.ar-table').DataTable({
	'paging'      : true,
	'lengthChange': true,
	'searching'   : true,
	'ordering'    : true,
	'info'        : true,
	'autoWidth'   : true
});

jQuery('.ar-status').click(function(e){
	e.preventDefault();
	type = jQuery(this).data('type');
	id = jQuery(this).data('id');
	emp = jQuery(this).data('emp');
	if(confirm('Are you sure to '+type+' ?')){
		jQuery.ajax({
			url: '/hrms/includes/ajaxfunctions.php?action=requeststatus&id='+id+'&type='+type+'&emp='+emp,
			dataType : 'JSON',
			success: function(res){
				alert(res.msg);
				if(res.result == 'success'){
					location.reload();
				}
			},
			error: function(err){
				console.log(err);
			}
		});
	}
});
