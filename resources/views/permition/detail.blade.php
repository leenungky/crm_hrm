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
		  <button class="tablinks active" onclick="openCity(event, 'Permition')">Leave Permition</button>
		  <button class="tablinks" onclick="openCity(event, 'OfiiceHour')">Ofiice Hour</button>
		  <button class="tablinks" onclick="openCity(event, 'Education')">Pendidikan</button>
		</div>		
		<div id="Permition" class="tabcontent" style="display: block;"
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
		  <h3>{{$employ->nik}} - {{$employ->name}}</h3><br/>
		  @include("permition._list")
		</div>
		
		<div id="OfiiceHour" class="tabcontent">
		  <h3>{{$employ->nik}} - {{$employ->name}}</h3><br/>
		  
		</div>		
		<br/>
		<div class="row">				
			<div class="col-md-12">		
				<button type="button" class="btn btn-editleave btn-primary">Submit</button>
				<a href="/empermition/list" class="btn btn-primary">Back</a>
			</div>
		</div>
	</div>	    	
</div>
@include('footer')
</body>
</html>


<script type="text/javascript">
	$(document).ready(function(){						
		$(".btn-editleave").click(function(){
			var arrPermitionLeave = [];			 			
			$('.body-permition-leave tr').each(function(index, tr) {
			    var lines = $('td', tr).map(function(index, td) {			    	
			        return $(td).text();
			    });	
			    var arrData = [lines[0], lines[1], lines[2], lines[3], lines[4], lines[5], lines[6], lines[7], lines[8], lines[9]];
			    arrPermitionLeave.push(arrData);			    
			});
			console.log(arrPermitionLeave);
			var strPermitionLeave = JSON.stringify(arrPermitionLeave);
			// console.log(strFamily);
			
			// var arrEduction = [];
			// $('.body-education tr').each(function(index, tr) {
			//     var lines = $('td', tr).map(function(index, td) {			    	
			//         return $(td).text();
			//     });	
			//     var arrData = [lines[0], lines[1], lines[2], lines[3], lines[4], lines[5], lines[6]];
			//     arrEduction.push(arrData);			    
			// });
			// var strEducation = JSON.stringify(arrEduction);
			
			var postdata = { 
				_token : "{{ csrf_token() }}",
				id: {{$employ->id}}, 
				nik: {{$employ->nik}}, 
				// name: $("input[name='name_karyawan']").val(),
				// birth_place: $("input[name='birth_place']").val(),
				// birth_date: $("input[name='birth_date']").val(),
				// department_id: $("input[name='department_id']").val(),
				// jobtitle_id: $("select[name='jobtitle_id']").val(),			
				// branch_id:	$("select[name='branch_id']").val(),
				// sex: $("select[name='sex']").val(),
				// phone: $("input[name='phone']").val(),
				// address: $("textarea[name='address']").val(),
				// email: $("input[name='email']").val(),
				// nationality: $("input[name='nationality']").val(),
				 permition_leave: strPermitionLeave,
				// education: strEducation
			}
				
			$.post( base_url + "/empermition/update/{{$employ->id}}", postdata).done(function( data ) {
				if (data.response.code==200){					
					location.href="/empermition/list";
				}else{
					
				}
		    	console.log(data)
		  	});
		})
	});
	


</script>
