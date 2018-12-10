$(document).ready(function() {
	$('input#input_text, textarea#textarea1').characterCounter();


	function show(id){
		$('#comments_section_'+id).css('display', 'block');
	}
	function showcomment(id){
		$('#comments_box_'+id).css('display', 'block');
	}
	function showcomment2(id){
		$('#comments_box2_'+id).css('display', 'block');
	}

});
