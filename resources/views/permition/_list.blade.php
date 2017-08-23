<div id="modal-permition-leave" class="modal fade" role="dialog">
  <div class="modal-dialog"> <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Leave Permition</h4>
      	</div>
      	<div class="modal-body-family">        
			<div class="container">
				<div class="form-group">
				    <label for="email">Propose Date</label>
					<input type="text" class="form-control datepicker" id="nama" name="propose" placeholder="input propose date" value="{{ old('f_name') }}" required>
				</div>					
		      	<div class="form-group">
				    <label for="email">Alasan</label>
					<textarea class="form-control" placeholder="Input Alasan" name="reason">{{old("reason")}}</textarea>
				</div>					
				<div class="form-group">
				    <label for="email">From</label>
					<input type="text" class="form-control datepicker" id="dari" name="dari" placeholder="input from" value="{{ old('dari') }}" required>
				</div>					
				<div class="form-group">
				    <label for="email">To</label>
					 <input type="text" class="form-control datepicker" id="sampai" name="sampai" placeholder="input sampai" value="{{ old('sampai') }}" required>
				</div>					
				<div class="form-group">
				    <label for="email">Long Day</label>
					 <input type="text" class="form-control" id="day" name="day" placeholder="input long day" value="{{ old('day') }}" required>
				</div>					
				<div class="form-group">
				    <label for="email">Checked By</label>
					 <input type="text" class="form-control" id="checked_by" name="checked_by" placeholder="input long day" value="{{ old('checked_by') }}" required>
				</div>					
				<div class="form-group">
				    <label for="email">Checked Date</label>
						<input type="text" class="form-control datepicker" id="education" name="checked_date" placeholder="input last checked_date" value="{{ old('checked_date') }}" required>
				</div>						
				<div class="form-group">				
				    <label for="email">Approved By</label>
					 <input type="text" class="form-control" id="approved_by" name="approved_by" placeholder="input approved by" value="{{ old('approved_by') }}" required>
				</div>					
				<div class="form-group">
				    <label for="email">Approved Date</label>
					<input type="text" class="form-control datepicker" id="approved_date" name="approved_date" placeholder="input approved date" value="{{ old('approved_date') }}" required>
				</div>						
				<div class="form-group">
				    <label for="email">Description *</label>
					<textarea name="description" class="form-control" placeholder="input description" required>{{ old('f_description') }}</textarea>
				</div>	
				<div class="form-group">
					<button class="btn btn-permition-leave">Save</button>
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
	<div class="col-md-12"
>		<button class="btn btn-add-permition-leave">Add</button>
	</div>
</div>
<div class="row">	
	<div class="col-md-12">		
						<table class="table tbl-permition-leave">
							<thead>
								<th>porpose</th
>								<th>reason</th>
								<th>From</th>
								<th>To</th>
								<th>Day</th>
								<th>Checked By</th>
								<th style="display: none;">Checked Date</th>
								<th>Approved By</th>
								<th style="display: none;">Approved Date</th>
								<th>Description</th>
								<th>Action</th>
							</thead>
							<tbody class="body-permition-leave">
								@foreach ($dbemploy_permition as $key => $value)
									<tr class="permition-leave_{{$key}}">
									<td>{{$value->propose}}</td>
									<td>{{$value->reason}}</td>
									<td>{{$value->dari}}</td>
									<td>{{$value->sampai}}</td>
									<td>{{$value->day}}</td>
									<td>{{$value->checked_by}}</td>
									<td style="display: none;">{{$value->checked_date}}</td>
									<td>{{$value->approved_by}}</td>
									<td style="display: none;">{{$value->approved_date}}</td>
									<td>{{$value->description}}</td>
									<td>
										<a href="javascript:void(0)">
										<span class="f_edit" attr-id="{{$key}}"> 
					    					<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>
					    				</span>
				    				</a> | 
				    				<a href="javascript:void(0)">
					    				<span class="f_delete" attr-id="{{$key}}">
				    						<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
				    					</span>
				    				</a> 
									</td>
								</tr>									
								@endforeach
								
								
							</tbody>
						</table>
</div>
</div>	
					
<script type="text/javascript">
	$(document).ready(function(){		
		var arrFamily = [[]];
		$(document).on("click", ".f_delete", function(){
			var conf = confirm('Are you sure?'); 
			if (conf){
				var val = $(this).attr("attr-id");			
				$(".permition-leave_" + val).remove();
			}
		});

		$(document).on("click", ".f_edit" ,function(){
			console.log("edit");
			$(".btn-permition-leave").addClass("btn-update-permition-leave");
			$(".btn-permition-leave").removeClass("btn-new-permition-leave");			

			var val = $(this).attr("attr-id");			
			$(".btn-permition-leave").attr("attr-id", val);
			$('.permition-leave_' + val).each(function(){  								
				$("input[name='propose']").val($(this).find('td').eq(0).text());
				$("textarea[name='reason']").val($(this).find('td').eq(1).text());
				$("input[name='dari']").val($(this).find('td').eq(2).text());
				$("input[name='sampai']").val($(this).find('td').eq(3).text());
				$("input[name='day']").val($(this).find('td').eq(4).text());
				$("input[name='checked_by']").val($(this).find('td').eq(5).text());				
				$("input[name='checked_date']").val($(this).find('td').eq(6).text());				
				$("input[name='approved_by']").val($(this).find('td').eq(7).text());	
				$("input[name='approved_date']").val($(this).find('td').eq(8).text());	
				$("textarea[name='description']").val($(this).find('td').eq(9).text());					
				$('#modal-permition-leave').modal('show'); 		    	
		    });			
		});

		$(document).on("click", ".btn-update-permition-leave",  function(){	
			var val = $(this).attr("attr-id");	
			var isValidate = false;						
			var isValidate = false;						
			isValidate = validate("day", "required", isValidate, "name");
			isValidate = validate("sampai", 'required', isValidate, "sampai");
			isValidate = validate("dari", 'required', isValidate, "dari");			
			isValidate = validateArea("reason", "required", isValidate)			
			isValidate = validate("propose", 'required', isValidate, "birth place");			
			if (isValidate){	
				console.log("======masuk validate");
				return;
			}
			var strHtmlToTable = onSetHtmlFamily(val);			
			$(".permition-leave_" + val).html(strHtmlToTable);
			$('#modal-permition-leave').modal('hide');

		});

		$(document).on("click", ".btn-new-permition-leave",  function(){		
			var isValidate = false;						
			isValidate = validate("day", "required", isValidate, "name");
			isValidate = validate("sampai", 'required', isValidate, "education");
			isValidate = validate("dari", 'required', isValidate, "education");
			isValidate = validateArea("reason", "required", isValidate)			
			isValidate = validate("propose", 'required', isValidate, "birth place");			
			if (isValidate){	
				console.log("======masuk validate");
				return;
			}
			var rowCount = $('.tbl-permition-leave tr').length;
			console.log(rowCount);
			var sex = "";			
			var strHtmlToTable = '<tr class="permition-leave_' + (rowCount) + '">';	
			var strHtmlToTable = strHtmlToTable + onSetHtmlFamily(rowCount);
			var strHtmlToTable = strHtmlToTable + '</tr>';
			$('.tbl-permition-leave > tbody:last-child').append(strHtmlToTable);		
			$('#modal-permition-leave').modal('hide');
		})

		$(".btn-add-permition-leave").click(function(){
			$(".btn-permition-leave").addClass("btn-new-permition-leave");
			$(".btn-permition-leave").removeClass("btn-update-permition-leave");			
				$("input[name='propose']").val("");
				$("textarea[name='reason']").val("");
				$("input[name='dari']").val("");
				$("input[name='sampai']").val("");
				$("input[name='day']").val("");
				$("input[name='checked_by']").val("");	
				$("input[name='checked_date']").val("");	
				$("input[name='approved_by']").val("");	
				$("input[name='approved_date']").val("");	
				$("input[name='description']").val("");					
			$('#modal-permition-leave').modal('show'); 
		});
	})	

	function onSetHtmlFamily(rowCount){					
				var strHtmlToTable  = '<td>'+ $("input[name='propose']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("textarea[name='reason']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='dari']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='sampai']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='day']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='checked_by']").val()+'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td style="display: none;">'+ $("input[name='checked_date']").val()+'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='approved_by']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td style="display: none;">'+ $("input[name='approved_date']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("textarea[name='description']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td><a href="javascript:void(0)">';
				strHtmlToTable = strHtmlToTable  + 	'<span class="f_edit" attr-id="'+ rowCount +'">';
				strHtmlToTable = strHtmlToTable  + 	'<span class="glyphicon glyphicon-pencil" rel="tooltip" title="edit"></span>';
				strHtmlToTable = strHtmlToTable  + 	'</span>';
				strHtmlToTable = strHtmlToTable  + 	'</a> | ';
				strHtmlToTable = strHtmlToTable  + 	'<a href="javascript:void(0)" class="confirmation"> ';
				strHtmlToTable = strHtmlToTable  + 	'<span class="f_delete" attr-id="'+ rowCount +'">';
				strHtmlToTable = strHtmlToTable  + 	'<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>';
				strHtmlToTable = strHtmlToTable  + 	'</span></a> </td>';
				
				return 	strHtmlToTable;		    				
							
	}
</script>				