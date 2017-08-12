<div id="modal-family" class="modal fade" role="dialog">
  <div class="modal-dialog"> <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<h4 class="modal-title">Modal Family</h4>
      	</div>
      	<div class="modal-body-family">        
			<div class="container">
		      	<div class="form-group">
				    <label for="email">Relation</label>
					<select name="family_relation_id" class="form-control">
						<option value="">Pilih Family Relation</option>
						@foreach ($family_relation as $key => $value)
							@if (old("family_id")=="$value->id")
								<option value="{{$value->id}}" selected>{{$value->name}}</option>
							@else
								<option value="{{$value->id}}">{{$value->name}}</option>
							@endif						 		
						@endforeach							 	
					</select>
				</div>					
				<div class="form-group">
				    <label for="email">Nama *</label>
					<input type="text" class="form-control" id="nama" name="f_name" placeholder="input nama" value="{{ old('f_name') }}" required>
				</div>					
				<div class="form-group">
				    <label for="email">Birth place *</label>
					 <input type="text" class="form-control" id="birth_place" name="f_birth_place" placeholder="input tempat lahir" value="{{ old('f_birth_place') }}" required>
				</div>					
				<div class="form-group">
				    <label for="email">Birth date *</label>
					 <input type="text" class="form-control datepicker" id="f_birth_date" name="f_birth_date" placeholder="input tanggal lahir" value="{{ old('f_birth_date') }}" required>
				</div>					
				<div class="form-group">
				    <label for="email">Gender *</label>
						<select name="f_sex" class="form-control" required>
						 	<option value="">Pilih Gender</option>
						 	@if (old("sex")=="L")
						 		<option value="L" selected=>Laki-Laki</option>
						 	@else
						 		<option value="L">Laki-Laki</option>
						 	@endif

						 	@if (old("sex")=="P")
						 		<option value="P" selected>Perempuan</option>						 	
						 	@else
						 		<option value="P">Perempuan</option>						 	
						 	@endif
						 	
						</select>
				</div>							
				<div class="form-group">
				    <label for="email">Education *</label>
						<input type="text" class="form-control" id="education" name="f_education" placeholder="input last education" value="{{ old('phone') }}" required>
				</div>						
				<div class="form-group">
				    <label for="email">Description *</label>
					<textarea name="f_description" class="form-control" placeholder="input description" required>{{ old('f_description') }}</textarea>
				</div>	
				<div class="form-group">
					<button class="btn btn-family">Save</button>
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
		<button class="btn btn-add-family">Add</button>
	</div>
</div>
<div class="row">	
	<div class="col-md-12">		
						<table class="table tbl-family">
							<thead>
								<th>Relation</th>
								<th>Name</th>
								<th>Birth place</th>
								<th>Birth date</th>
								<th>Jenis Kelamin</th>
								<th>Education</th>
								<th>Description</th>
								<th>Action</th>
							</thead>
							<tbody class="body-family">
								<tr class="family_0"><td>ibu</td>
									<td>a</td>
									<td>b</td>
									<td>2015-12-12</td>
									<td>Perempuan</td>
									<td>SD</td>
									<td>aa</td>
									<td>
										<a href="javascript:void(0)">
										<span class="f_edit" attr-id="0"> 
					    					<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>
					    				</span>
				    				</a> | 
				    				<a href="javascript:void(0)">
					    				<span class="f_delete" attr-id="0">
				    						<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
				    					</span>
				    				</a> 
									</td>
								</tr>
								<tr class="family_1"><td>Bapak</td>
									<td>a</td>
									<td>b</td>
									<td>2015-12-12</td>
									<td>Laki-Laki</td>
									<td>SD</td>
									<td>aa</td>
									<td>
										<a href="javascript:void(0)">
										<span class="f_edit" attr-id="1"> 
					    					<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>
					    				</span>
				    				</a> | 
				    				<a href="javascript:void(0)">
					    				<span class="f_delete" attr-id="1">
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
		$(document).on("click", ".f_delete", function(){
			var conf = confirm('Are you sure?'); 
			if (conf){
				var val = $(this).attr("attr-id");			
				$(".family_" + val).remove();
			}
		});

		$(document).on("click", ".f_edit" ,function(){
			console.log("edit");
			$(".btn-family").addClass("btn-update-family");
			$(".btn-family").removeClass("btn-new-family");			

			var val = $(this).attr("attr-id");			
			$(".btn-family").attr("attr-id", val);
			$('.family_' + val).each(function(){  
				jselected("family_relation_id", $(this).find('td').eq(0).text());
				$("input[name='f_name']").val($(this).find('td').eq(1).text());
				$("input[name='f_birth_place']").val($(this).find('td').eq(2).text());
				$("input[name='f_birth_date']").val($(this).find('td').eq(3).text());
				$("input[name='f_sex']").val($(this).find('td').eq(4).text());
				$("input[name='f_education']").val($(this).find('td').eq(5).text());
				$("input[name='f_description']").val($(this).find('td').eq(6).text());	
				jselected("f_sex", $(this).find('td').eq(4).text());			
				$('#modal-family').modal('show'); 		    	
		    });			
		});

		$(document).on("click", ".btn-update-family",  function(){	
			var val = $(this).attr("attr-id");	
			var isValidate = false;						
			isValidate = validate("f_education", 'required', isValidate, "education");
			isValidate = validateSelect("f_sex", "required", isValidate, "jenis kelamin");						
			isValidate = validate("f_birth_place", 'required', isValidate, "birth place");
			isValidate = validate("f_birth_date", 'required', isValidate, "birth date");
			isValidate = validate("f_name", "required", isValidate, "name");
			isValidate = validateSelect("family_relation_id", "required", isValidate, "family");
			isValidate = validate("f_name", 'required', isValidate);
			if (isValidate){	
				console.log("======masuk validate");
				return;
			}	
			var strHtmlToTable = onSetHtmlFamily(val);			
			$(".family_" + val).html(strHtmlToTable);
			$('#modal-family').modal('hide');

		});

		$(document).on("click", ".btn-new-family",  function(){		
			var isValidate = false;						
			isValidate = validate("f_education", 'required', isValidate, "education");
			isValidate = validateSelect("f_sex", "required", isValidate, "jenis kelamin");						
			isValidate = validate("f_birth_place", 'required', isValidate, "birth place");
			isValidate = validate("f_birth_date", 'required', isValidate, "birth date");
			isValidate = validate("f_name", "required", isValidate, "name");
			isValidate = validateSelect("family_relation_id", "required", isValidate, "family");
			isValidate = validate("f_name", 'required', isValidate);
			if (isValidate){	
				console.log("======masuk validate");
				return;
			}
			var rowCount = $('.tbl-family tr').length;
			console.log(rowCount);
			var sex = "";			
			var strHtmlToTable = '<tr class="family_' + (rowCount) + '">';	
			var strHtmlToTable = strHtmlToTable + onSetHtmlFamily(rowCount);
			var strHtmlToTable = strHtmlToTable + '</tr>';
			$('.tbl-family > tbody:last-child').append(strHtmlToTable);		
			$('#modal-family').modal('hide');
		})

		$(".btn-add-family").click(function(){
			$(".btn-family").addClass("btn-new-family");
			$(".btn-family").removeClass("btn-update-family");
			jselected("family_relation_id", "");
				$("input[name='f_name']").val("");
				$("input[name='f_birth_place']").val("");
				$("input[name='f_birth_date']").val("");
				$("input[name='f_sex']").val("");
				$("input[name='f_education']").val("");
				$("input[name='f_description']").val("");	
				jselected("f_sex", "");	
			$('#modal-family').modal('show'); 
		});
	})	

	function onSetHtmlFamily(rowCount){					
				var strHtmlToTable  = '<td>'+ $("select[name='family_relation_id'] option:selected").text() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='f_name']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='f_birth_place']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='f_birth_date']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("select[name='f_sex'] option:selected").text()+'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("input[name='f_education']").val() +'</td>';
				strHtmlToTable = strHtmlToTable  + 	'<td>'+ $("textarea[name='f_description']").val() +'</td>';
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