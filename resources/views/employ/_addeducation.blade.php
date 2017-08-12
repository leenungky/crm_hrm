<div id="modal_education" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
     <div class="modal-body-education">        
     	<div class="container">
      		<div class="form-group">
					<label for="email">Grade </label>
						 <input type="text" class="form-control" id="e_grade" name="e_grade" placeholder="input grade" value="{{ old('e_grade') }}" required>
					</div>
					<div class="form-group">
					    <label for="email">Major Study *</label>
						 <input type="text" class="form-control" id="e_major_study" name="e_major_study" placeholder="input major study" value="{{ old('e_major_study') }}" required>
					</div>
					<div class="form-group">
					    <label for="email">Scholl name/ Istitute *</label>
						 <input type="text" class="form-control" id="e_scholl_name" name="e_scholl_name" placeholder="input schooll name" value="{{ old('f_birth_date') }}" required>
					</div>
					<div class="form-group">
					    <label for="email">From *</label>
						 <input type="text" class="form-control" id="e_from" name="e_from" placeholder="input year from" value="{{ old('e_from') }}" required>
					</div>									
					<div class="form-group">
					    <label for="email">To *</label>
						 <input type="text" class="form-control" id="e_to" name="e_to" placeholder="input year to" value="{{ old('e_to') }}" required>
					</div>						
					<div class="form-group">
					    <label for="email">GPA/Last Value</label>
						<input type="text" class="form-control" id="e_gpa" name="e_gpa" placeholder="input GPA" value="{{ old('e_gpa') }}" required>
					</div>	
					<div class="form-group">
					    <label for="email">Description</label>
						 <textarea name="e_description" class="form-control" placeholder="input description"></textarea>
					</div>	
					<div class="form-group">
						<button class="btn btn-education">save</button>
					</div>
					
			</div>
	
      </div>
      <div class="modal-footer">        
        <button type="button"  class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	
<div class="row">
	<div class="col-md-12">
		<button class="btn btn-add-education">Add</button>
	</div>
</div>
<div class="row">	
	<div class="col-md-12">		
		<table class="table tbl-education">
			<thead>				
				<th>Name</th>
				<th>Grade</th>
				<th>Major Study</th>
				<th>From</th>
				<th>To</th>
				<th>GPA</th>
				<th>Description</th>
				<th>Action</th>
			</thead>
			<tbody class="body-education">	
				<tr class="education_0">
								<td>tolis</td>
									<td>A</td>
									<td>IPA</td>
									<td>2012</td>
									<td>2013</td>
									<td>2.5</td>
									<td>aa</td>
									<td>
										<a href="javascript:void(0)">
										<span class="e_edit" attr-id="0"> 
					    					<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>
					    				</span>
				    				</a> | 
				    				<a href="javascript:void(0)" class="confirmation">
					    				<span class="e_delete" attr-id="0">
				    						<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
				    					</span>
				    				</a> 
									</td>
								</tr>						
			</tbody>
		</table>
	</div>
</div>					
<script type="text/javascript">
	$(document).ready(function(){
		var arrFamily = [[]];
		$(document).on("click", ".e_delete", function(){
			var val = $(this).attr("attr-id");			
			$(".education_" + val).remove();
		});

		$(document).on("click", ".e_edit", function(){
			
			console.log("edit");
			$('#modal_education').modal('show'); 		
			$(".btn-education").addClass("btn-update-education");
			$(".btn-education").removeClass("btn-new-education");			

			var val = $(this).attr("attr-id");			
			$(".btn-education").attr("attr-id", val);			
			$('.education_' + val).each(function(){  				
				$("input[name='e_scholl_name']").val($(this).find('td').eq(0).text());								
				$("input[name='e_grade']").val($(this).find('td').eq(1).text());				
				$("input[name='e_major_study']").val($(this).find('td').eq(2).text());
				$("input[name='e_from']").val($(this).find('td').eq(3).text());
				$("input[name='e_to']").val($(this).find('td').eq(4).text());
				$("input[name='e_gpa']").val($(this).find('td').eq(5).text());				
				$("textarea[name='e_description']").val($.trim($(this).find('td').eq(6).text()));	
				$('#modal_education').modal('show'); 								
				    	
			});
		});					
$("input[name='e_scholl_name']").val("");								
			$("input[name='e_grade']").val("");				
			$("input[name='e_major_study']").val("");
			$("input[name='e_from']").val("");
			$("input[name='e_to']").val("");
			$("input[name='e_gpa']").val("")
		$(document).on("click",".btn-update-education", function(){								
			var val = $(this).attr("attr-id");	
			var isValidate = false;														
			isValidate = validate("e_gpa", 'required', isValidate, "gpa");
			isValidate = validate("e_to", 'required', isValidate, "to");
			isValidate = validate("e_from", 'required', isValidate, "from");
			isValidate = validate("e_scholl_name", "required", isValidate, "name");
			isValidate = validate("e_major_study", 'required', isValidate, "major study");
			isValidate = validate("e_grade", 'required', isValidate, "grade");
			if (isValidate){	
				return;
			}
			console.log($("textarea[name='e_description']").val());
			
			var strHtmlToTable = onSetHtmlEducation(val);			
			$(".education_" + val).html(strHtmlToTable);						
			$('#modal_education').modal('hide'); 
		});

		$(document).on("click",".btn-new-education", function(){					
			var isValidate = false;															
			isValidate = validate("e_gpa", 'required', isValidate, "gpa");
			isValidate = validate("e_to", 'required', isValidate, "to");
			isValidate = validate("e_from", 'required', isValidate, "from");
			isValidate = validate("e_scholl_name", "required", isValidate, "name");
			isValidate = validate("e_major_study", 'required', isValidate, "major study");
			isValidate = validate("e_grade", 'required', isValidate, "grade");
			if (isValidate){	
				return;
			}
			var rowCount = $('.tbl-education tr').length;
			console.log(rowCount);
			var sex = "";
			var strHtmlToTable = '<tr class="education_' + (rowCount) + '">';				
			strHtmlToTable = strHtmlToTable  + 	onSetHtmlEducation(rowCount);	
			strHtmlToTable = strHtmlToTable  + 	'</tr>';				
			$('.tbl-education > tbody:last-child').append(strHtmlToTable);						
			$('#modal_education').modal('hide'); 
		});

		$(".btn-add-education").click(function(){
			;				
			$("textarea[name='e_description']").val("");									
			$(".btn-education").addClass("btn-new-education");
			$(".btn-education").removeClass("btn-update-education");			
			$('#modal_education').modal('show'); 
		});
	});

function onSetHtmlEducation(rowCount){
	var strHtmlToTable = '<td>'+ $("input[name='e_scholl_name']").val() +'</td>';
	strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='e_grade']").val() +'</td>';
	strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='e_major_study']").val() +'</td>';				
	strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='e_from']").val() +'</td>';
	strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='e_to']").val() +'</td>';
	strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='e_gpa']").val() +'</td>';
	strHtmlToTable = strHtmlToTable  + 	'<td>'+ $.trim($("textarea[name='e_description']").val()) +'</td>';				
	strHtmlToTable = strHtmlToTable  + 	'<td><a href="javascript:void(0)">';
	strHtmlToTable = strHtmlToTable  + 	'<span class="e_edit" attr-id="'+ rowCount +'">';
	strHtmlToTable = strHtmlToTable  + 	'<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>';
	strHtmlToTable = strHtmlToTable  + 	'</span>';
	strHtmlToTable = strHtmlToTable  + 	'</a> | ';
	strHtmlToTable = strHtmlToTable  + 	'<a href="javascript:void(0)" class="confirmation"> ';
	strHtmlToTable = strHtmlToTable  + 	'<span class="e_delete" attr-id="'+ rowCount +'">';
	strHtmlToTable = strHtmlToTable  + 	'<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>';
	strHtmlToTable = strHtmlToTable  + 	'</span></a> </td>';
	return strHtmlToTable;				
}
</script>				