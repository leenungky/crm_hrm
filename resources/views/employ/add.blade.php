<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
     @include('head')
     <style type="text/css" media="print">
     	   @media print {
			    @page { margin: 0px 6px; }
  				body  { margin: 0px 6px; }   					  
			}
     </style>
</head>
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">       
		@include('header')		
		<br/>
		@if (count($errors))     
			<div class="row">				
				<div class="col-md-12 alert alert-danger">		
				    <ul>
				        @foreach($errors->all() as $error) 		            				            
				            <li>{{$error}}</li>
				        @endforeach 
				    </ul>
			    </div>
		    </div>
		@endif 
		<br/>
		<div class="row">				
			<div class="col-md-12">		
				<form method="post" action="/employ/create" class="formsubmit">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">					
					<div class="form-group">
					    <label for="email">NIK *</label>
						 <input type="text" class="form-control" id="nik" name="nik" placeholder="input nik" value="{{ old('nik') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Nama</label>
						 <input type="text" class="form-control" id="nama" name="name" placeholder="input nama" value="{{ old('name') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Tempat Lahir</label>
						 <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="input tempat lahir" value="{{ old('birth_place') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Tempat Lahir</label>
						 <input type="text" class="form-control" id="birth_date" name="birth_date" placeholder="input tempat lahir" value="{{ old('birth_date') }}" required>
					</div>					
					<div class="form-group">
					    <label for="email">Jenis Kelamin</label>
						 <select name="sex" class="form-control" required>
						 	<option>Pilih Jenis Kelamin</option>
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
					    <label for="email">Phone</label>
						 <input type="text" class="form-control" id="phone" name="phone" placeholder="input phone" value="{{ old('phone') }}" required>
					</div>						
					<div class="form-group">
					    <label for="email">Alamat</label>
						 <textarea name="address" class="form-control" placeholder="input alamat" required>{{ old('address') }}</textarea>
					</div>										
					<button type="submit" class="btn">Submit</button>
				</form>
			</div>
		</div>
	</div>	    	
</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){	
		$( "input[name=name]" ).focus();
	});
</script>