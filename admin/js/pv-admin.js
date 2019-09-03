$j = jQuery.noConflict();

$j(document).ready(function(){
	$j('.data-table').DataTable();
	viewReview();
	pvTabs();
	viewFeedback();
});

function viewReview(){
	var _trig = $j(".view-review");

	var _branch = $j("#branch");
	var _fname = $j("#fname");
	var _lname = $j("#lname");
	var _service = $j("#service");
	var _recommend = $j("#recommend");
	var _experience = $j("#experience");
	var _review = $j("#review");
	var _summary = $j("#review-summary");
	var _state = $j("#state");
	var _city = $j("#city");
	var _reviewerid = $j("#ReviewerID");
	var _reviewid = $j("#ReviewID");

	_trig.on("click", function () {

		_branch.val(($j(this).data('branch')));
		_lname.val(($j(this).data('lname')));
		_fname.val(($j(this).data('fname')));
		_summary.val(($j(this).data('summary')));
		_review.val(($j(this).data('review')));
		_state.val(($j(this).data('state')));
		_city.val(($j(this).data('city')));
		_reviewid.val(($j(this).data('reviewid')));
		_reviewerid.val(($j(this).data('reviewerid')));

		_service.find('option[value='+$j(this).data('service')+']').attr('selected',true);
		_recommend.find('option[value='+$j(this).data('recommend')+']').attr('selected',true);
		_experience.find('option[value='+$j(this).data('experience')+']').attr('selected',true);

	});
}
function viewFeedback(){
	var _trig = $j('.view-feedback');
	var _name = $j('.feedback_name');
	var _cont = $j('.feedback-container');

	_cont.empty();

	_trig.on('click',function(){
		_name.html('<b>'+$(this).data('name')+'</b>');
		_cont.load($j(this).data('url')+'/ajax-load.php?mode=feedback&id='+$j(this).data('id')+'&dir='+$j(this).data('dir'));
	});
}
function pvTabs(){
	$j('.tab_content').hide();
	$j('.tab_content:first').show();
	$j('ul.tabs li').click(function () {
		$j('.tab_content').hide();
		var activeTab = $(this).attr('rel');
		$j('#' + activeTab).fadeIn();
		$j('ul.tabs li').removeClass('active');
		$j(this).addClass('active');
		$j('.tab_drawer_heading').removeClass('d_active');
		$j('.tab_drawer_heading[rel^=\'' + activeTab + '\']').addClass('d_active');
	});
	$j('.tab_drawer_heading').click(function () {
		$j('.tab_content').hide();
		var d_activeTab = $(this).attr('rel');
		$j('#' + d_activeTab).fadeIn();
		$j('.tab_drawer_heading').removeClass('d_active');
		$j(this).addClass('d_active');
		$j('ul.tabs li').removeClass('active');
		$j('ul.tabs li[rel^=\'' + d_activeTab + '\']').addClass('active');
	});
	$j('ul.tabs li').last().addClass('tab_last');
}
