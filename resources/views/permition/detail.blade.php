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
		  <button class="tablinks" onclick="openCity(event, 'Permition')">Leave Permition</button>
		  <button class="tablinks" onclick="openCity(event, 'Education')">Pendidikan</button>
		</div>		

		<div id="Profile" class="tabcontent" style="display: block;"/>						
		  <h3></h3><br/>
		  @include("permition._detailkaryawan")
		</div>
		
		<div id="Permition" class="tabcontent">
		  <h3></h3><br/>		  

		  @include("permition._list")		  
		</div>		
	</div>	    	
</div>@include("footer")
</body>
</html>