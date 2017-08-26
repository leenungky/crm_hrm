<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>    
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">       
	
		<div class="tab">
		  <button class="tablinks active" onclick="openCity(event, 'Profile')">Profile</button>
		</div>		

		<div id="Profile" class="tabcontent" style="display: block;"/>						
		  <div class="row">
		  	<div class="col-md-12">
		  		<label>
		  			<input type="radio" name="type" value="present">present not late
		  		</label>
		  		<label>
		  			<input type="radio" name="type" value="present_late">present late
		  		</label>
		  	</div>
		  </div>
		  <br/>
		  <div class="row">
		  	<div class="col-md-12">
		  		<div data-provide="calendar"></div>
		  	</div>
		  </div>
		  
		</div>
		
		
	</div>	    	
</div>
@include("footer")
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		var currentYear = new Date().getFullYear();
	    var arr_date = [];
	    arr_date["2017-01-01"] = 'present';
	    arr_date["2017-01-02"] = 'present_late';

		$('.calendar').calendar({
			 clickDay: function(e) { 
			 	if ($("input[name='type']").is(':checked')) {
			 		var valchk = $('input[name=type]:checked').val();
			 		if (valchk == 'present'){
			 			$(e.element).css('background-color', 'green');
			            $(e.element).css('color', 'white');
			            $(e.element).css('border-radius', '15px');		
			 		}else if (valchk == 'present_late'){
			 			$(e.element).css('background-color', 'red');
			            $(e.element).css('color', 'white');
			            $(e.element).css('border-radius', '15px');		
			 		}
			 	}else{
			 		alert("Pilih type absent")
			 	}
			 	
			 },
			customDayRenderer: function(element, date) {
				var dt = $.datepicker.formatDate('yy-mm-dd', date);
				// console.log(dt + "=" + arr_date[0]);				
				if(arr_date[dt]=="present"){								
					$(element).css('background-color', 'green');
			        $(element).css('color', 'white');
			        $(element).css('border-radius', '15px');		
				}else if(arr_date[dt]=="present_late"){								
					$(element).css('background-color', 'red');
			        $(element).css('color', 'white');
			        $(element).css('border-radius', '15px');		
				}	            
	        },
	        disabledDays: [	        	
	            new Date(currentYear,1,2),
	            new Date(currentYear,1,3),
	            new Date(currentYear,1,8),
	            new Date(currentYear,1,9),
	            new Date(currentYear,1,10),
	            new Date(currentYear,1,11),
	            new Date(currentYear,1,13),
	            new Date(currentYear,1,14),
	            new Date(currentYear,1,15)
	        ]
		});
	})
</script>