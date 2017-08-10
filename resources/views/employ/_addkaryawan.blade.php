
					
					<div class="form-group">
					    <label for="email">NIK *</label>
						 <input type="text" class="form-control" id="nik" name="nik" placeholder="input nik" value="{{ old('nik') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Nama *</label>
						 <input type="text" class="form-control" id="nama" name="name_karyawan" placeholder="input nama" value="{{ old('name_karyawan') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Birth place *</label>
						 <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="input tempat lahir" value="{{ old('birth_place') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Birth date *</label>
						 <input type="text" class="form-control datepicker" id="birth_date" name="birth_date" placeholder="input tanggal lahir" value="{{ old('birth_date') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Gender *</label>
						 <select name="sex" class="form-control" required>
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
					    <label for="email">Department *</label>
						<div class="input-group">
					      <input type="text" name="department" class="form-control" placeholder="Search for..." value="{{old("department")}}">
					      <input type="hidden" name="department_id" class="form-control" value="{{old("department_id")}}">
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
						 		@if (old("jobtitle_id")=="$value->id")
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
						 		@if (old("branch_id")=="$value->id")
						 			<option value="{{$value->id}}" selected>{{$value->name}}</option>
						 		@else
						 			<option value="{{$value->id}}">{{$value->name}}</option>
						 		@endif						 		
						 	@endforeach							 	
						 </select>
					</div>										
					<div class="form-group">
					    <label for="email">Phone *</label>
						 <input type="text" class="form-control" id="phone" name="phone" placeholder="input phone" value="{{ old('phone') }}" required>
					</div>						
					<div class="form-group">
					    <label for="email">Address *</label>
						 <textarea name="address" class="form-control" placeholder="input address" required>{{ old('address') }}</textarea>
					</div>						
					<div class="form-group">
					    <label for="email">Email</label>
					    <input type="text" class="form-control" id="email" name="email" placeholder="input email" value="{{ old('email') }}">
					</div>
					<div class="form-group">
					    <label for="email">Nationality</label>
					    <input type="text" class="form-control" id="nationality" name="nationality" placeholder="input nationality" value="{{ old('nationality') }}">						 
					</div>
					<button type="button" class="btn btn-addkaryawan">Submit</button>
				