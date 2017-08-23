<div class="alert alert-danger danger-notify-add-karyawan" style="display: none">  
</div>

<div class="form-group">
					    <label for="email">NIK *</label>
						 <input type="text" class="form-control" id="nik" name="nik" placeholder="input nik" value="{{$employ->nik}}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Nama *</label>
						 <input type="text" class="form-control" id="name_karyawan" name="name_karyawan" placeholder="input nama" value="{{$employ->name}}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Birth place *</label>
						 <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="input tempat lahir" value="{{$employ->birth_place}}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Birth date *</label>
						 <input type="text" class="form-control datepicker" id="birth_date" name="birth_date" placeholder="input tanggal lahir" value="{{$employ->birth_date}}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Gender *</label>
						 <select name="sex" class="form-control" required>
						 	<option>Pilih Gender</option>
						 	@if ($employ->sex=="L")
						 		<option value="L" selected=>Laki-Laki</option>
						 	@else
						 		<option value="L">Laki-Laki</option>
						 	@endif

						 	@if ($employ->sex=="P")
						 		<option value="P" selected>Perempuan</option>						 	
						 	@else
						 		<option value="P">Perempuan</option>						 	
						 	@endif
						 	
						 </select>
					</div>		
					<div class="form-group">
					    <label for="email">Department</label>
						<div class="input-group">
					      <input type="text" name="department" class="form-control" placeholder="Search for..." value="{{$employ->department_name}}">
					      <input type="hidden" name="department_id" class="form-control" value="{{$employ->department_id}}">
					      <span class="input-group-btn">
					        <button class="btn browse-department" type="button">Browse</button>
					      </span>
					    </div>
					</div>
					<div class="form-group">
					    <label for="email">Job Titile</label>
						 <select name="jobtitle_id" class="form-control">
						 	<option>Pilih Job Title</option>
						 	@foreach ($jobtitle as $key => $value)
						 		@if ($employ->jobtitle_id=="$value->id")
						 			<option value="{{$value->id}}" selected>{{$value->name}}</option>
						 		@else
						 			<option value="{{$value->id}}">{{$value->name}}</option>
						 		@endif						 		
						 	@endforeach						 	
						 </select>
					</div>		
					<div class="form-group">
					    <label for="email">Branch</label>
						 <select name="branch_id" class="form-control">
						 	<option>Pilih Branch</option>
						 	@foreach ($branch as $key => $value)
						 		@if ($employ->branch_id=="$value->id")
						 			<option value="{{$value->id}}" selected>{{$value->name}}</option>
						 		@else
						 			<option value="{{$value->id}}">{{$value->name}}</option>
						 		@endif						 		
						 	@endforeach	
						 	
						 </select>
					</div>										
					<div class="form-group">
					    <label for="email">Phone *</label>
						 <input type="text" class="form-control" id="phone" name="phone" placeholder="input phone" value="{{$employ->phone}}" required>
					</div>						
					<div class="form-group">
					    <label for="email">Address *</label>
						 <textarea name="address" class="form-control" placeholder="input address" required>{{$employ->address}}</textarea>
					</div>						
					<div class="form-group">
					    <label for="email">Email</label>
					    <input type="text" class="form-control" id="email" name="email" placeholder="input email" value="{{$employ->email}}">
					</div>
					<div class="form-group">
					    <label for="email">Nationality</label>
					    <input type="text" class="form-control" id="nationality" name="nationality" placeholder="input nationality" value="{{$employ->nationality}}">						 
					</div>