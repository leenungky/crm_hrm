	<div class="form-group">
	    <label for="email">Relation</label>
		<select name="relation_id" class="form-control">						 	
		</select>
	</div>					
					<div class="form-group">
					    <label for="email">Nama</label>
						 <input type="text" class="form-control" id="nama" name="name_family" placeholder="input nama" value="{{ old('name') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Birth place</label>
						 <input type="text" class="form-control" id="birth_place" name="f_birth_place" placeholder="input tempat lahir" value="{{ old('birth_place') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Birth date</label>
						 <input type="text" class="form-control datepicker" id="f_birth_date" name="birth_date" placeholder="input tanggal lahir" value="{{ old('birth_date') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Gender</label>
						 <select name="sex" class="form-control" required>
						 	<option>Pilih Gender</option>
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
					    <label for="email">Education</label>
						 <input type="text" class="form-control" id="education" name="education" placeholder="input phone" value="{{ old('phone') }}" required>
					</div>						
					<div class="form-group">
					    <label for="email">Description</label>
						 <textarea name="description" class="form-control" placeholder="input description" required>{{ old('description') }}</textarea>
					</div>	
					<div class="form-group">
						<button class="btn btn-family">aa</button>
					</div>
					<br/>
					
						<table class="table tbl-family">
							<thead>
								<th>Relation</th>
								<th>Nama</th>
								<th>Action</th>
							</thead>
							<tbody class="body-family">
								<tr class="anak_1">
									<td>Anak1</td><td>Nungky</td><td>
										<a href="javascript:void(0)">
										<span class="edit"> 
					    					<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>
					    				</span>
				    				</a> | 
				    				<a href="javascript:void(0)" class="confirmation">
					    				<span class="f_delete" attr-id="1">
				    						<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
				    					</span>
				    				</a> 
									</td>
								</tr>								
								<tr class="anak_2">
									<td>Anak2</td><td>Asep</td><td>
										<a href="javascript:void(0)">
										<span class="edit"> 
					    					<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>
					    				</span>
				    				</a> | 
				    				<a href="javascript:void(0)" class="confirmation">
					    				<span class="f_delete" attr-id="2">
				    						<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
				    					</span>
				    				</a> 
									</td>
								</tr>
							</tbody>
						</table>
					
<script type="text/javascript">
	$(document).ready(function(){
		var arrFamily = [[]];
		$(document).on("click", ".f_delete", function(){
			var val = $(this).attr("attr-id");
			alert(val);
			$(".anak_" + val).remove();
		});

		$(".btn-family").click(function(){		
			var rowCount = $('.tbl-family tr').length;
			var strHtmlToTable = '<tr class="anak_' + (rowCount) + '">';
				strHtmlToTable = strHtmlToTable  + 	'<td>Anak2</td><td>Asep</td><td>';
				strHtmlToTable = strHtmlToTable  + 	'<a href="javascript:void(0)">';
				strHtmlToTable = strHtmlToTable  + 	'<span class="edit">';
				strHtmlToTable = strHtmlToTable  + 	'<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="edit"></span>';
				strHtmlToTable = strHtmlToTable  + 	'</span>';
				strHtmlToTable = strHtmlToTable  + 	'</a> | ';
				strHtmlToTable = strHtmlToTable  + 	'<a href="javascript:void(0)" class="confirmation"> ';
				strHtmlToTable = strHtmlToTable  + 	'<span class="f_delete" attr-id="'+ rowCount +'">';
				strHtmlToTable = strHtmlToTable  + 	'<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>';
				strHtmlToTable = strHtmlToTable  + 	'</span></a> </td>';
				strHtmlToTable = strHtmlToTable  + 	'</tr>';				    				
			$('.tbl-family > tbody:last-child').append(strHtmlToTable);			
		})
	})
</script>				