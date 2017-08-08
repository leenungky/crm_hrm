$(document).ready(function(){
	$('.load-tree').load(base_url + "/department/tree");
	$(".open-modal").click(function(){	
		$(".modal-title").text("Department");					
		$(".modal-body").load(base_url + "/department/tree");
		$('#myModal').modal('show'); 
	})	
	$(".browse-department").click(function(){
		$(".modal-title").text("Department");					
		$(".modal-body").load(base_url + "/department/tree");
		$('#myModal').modal('show'); 
	})
});