<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
     @include('head')
</head>
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">       
		@include('header')		
		<div class="tab">
		  <button class="tablinks active" onclick="openCity(event, 'Karyawan')">Karyawan</button>
		  <button class="tablinks" onclick="openCity(event, 'Family')">Family</button>
		  <button class="tablinks" onclick="openCity(event, 'Education')">Pendidikan</button>
		</div>		
		<div id="Karyawan" class="tabcontent" style="display: block;"
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
		  <h3>Karyawan</h3>
		  @include("employ._editkaryawan")
		</div>
		<div id="Family" class="tabcontent">
		  <h3>Family</h3>
		  @include("employ._editfamily")
		</div>
		<div id="Education" class="tabcontent">
		  <h3>Pendidikan</h3>
		  @include("employ._editeducation")
		</div>		
		<div class="row">				
			<div class="col-md-12">		
				<button type="button" class="btn btn-editkaryawan">Submit</button>	
			</div>
		</div>
	</div>	    	
</div>
@include('footer')
</body>
</html>


<script type="text/javascript">
	$(document).ready(function(){				
		$( "input[name=nik]" ).focus();
		$(".btn-editkaryawan").click(function(){
			var isValidate = false;
			isValidate = validateArea("address", "required", isValidate);
			isValidate = validate("phone", "required", isValidate);
			isValidate = validateSelect("sex", "required", isValidate);
			isValidate = validate("birth_date", 'required', isValidate);
			isValidate = validate("birth_place", 'required', isValidate);
			isValidate = validate("name_karyawan", 'required', isValidate, "name");
			isValidate = validate("nik", 'required', isValidate);

			if (isValidate){	
				return;
			}
			var arrFamily = [];			 			
			$('.body-family tr').each(function(index, tr) {
			    var lines = $('td', tr).map(function(index, td) {			    	
			        return $(td).text();
			    });	
			    var arrData = [lines[0], lines[1], lines[2], lines[3], lines[4], lines[5], lines[6]];
			    arrFamily.push(arrData);			    
			});
			var strFamily = JSON.stringify(arrFamily);
			console.log(strFamily);
			
			var arrEduction = [];
			$('.body-education tr').each(function(index, tr) {
			    var lines = $('td', tr).map(function(index, td) {			    	
			        return $(td).text();
			    });	
			    var arrData = [lines[0], lines[1], lines[2], lines[3], lines[4], lines[5], lines[6]];
			    arrEduction.push(arrData);			    
			});
			var strEducation = JSON.stringify(arrEduction);
			
			var postdata = { 
				_token : "{{ csrf_token() }}",
				nik: $("input[name='nik']").val(), 
				name: $("input[name='name_karyawan']").val(),
				birth_place: $("input[name='birth_place']").val(),
				birth_date: $("input[name='birth_date']").val(),
				department_id: $("input[name='department_id']").val(),
				jobtitle_id: $("select[name='jobtitle_id']").val(),			
				branch_id:	$("select[name='branch_id']").val(),
				sex: $("select[name='sex']").val(),
				phone: $("input[name='phone']").val(),
				address: $("textarea[name='address']").val(),
				email: $("input[name='email']").val(),
				nationality: $("input[name='nationality']").val(),
				family: strFamily,
				education: strEducation
			}
				
			$.post( base_url + "/employ/update/{{$employ->id}}", postdata).done(function( data ) {
				if (data.response.code==200){
					$(".info-notify-add-karyawan").html(data.response.message);
					$(".info-notify-add-karyawan").show();
					location.href="/employ/list";

				}else{
					$(".info-notify-add-karyawan").hide();
					$(".error-notify-add-karyawan").html(data.response.message);
					$(".error-notify-add-karyawan").show();
				}
		    	console.log(data)
		  	});
		})
	});
	


</script>
