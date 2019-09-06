$j = jQuery.noConflict();

$j(document).ready(function(){
	$j('.data-table').DataTable();
});

$j(document).on('click', '.view-intake',function(){
	var _id = $j(this).attr('id');
	var _to = $j(this).attr('data-to-' + _id);
	var _from = $j(this).attr('data-from-' + _id);
	var _msg = $j(this).attr('data-msg-' + _id);
	var _date = $j(this).attr('data-date-' + _id);

	$j("#data-to").val(_to);
	$j("#data-from").val(_from);
	$j("#data-msg").val(_msg);
	$j("#data-date").val(_date);
})