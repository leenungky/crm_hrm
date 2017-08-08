<html>
	<head>
		<link rel="stylesheet" href="{{ URL::asset('css/jquerysctipttop.css') }}" />	
		<link rel="stylesheet" href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" />		
		<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-dialog.min.css') }}" />	
	</head>
<body>
<div class="tree">
	<div class="container">
		<ul>
			<li><a href="#" id="root" class="right-click">root</a>								
				<ul>
					@foreach ($deptDB as $key => $value)				
						<li><a href="#" id="{{$value->id}}" class="right-click">{{$value->name}}</a>	
						<?php 					
							$helper->getDbTreeDepartment($ctrl, $value);										
						?>				
						</li>
					@endforeach														
				</ul>
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/tree.js') }}"></script>	
</body>
</html>
<script type="text/javascript">
	$( ".right-click" ).dblclick(function() {
		$("input[name='department']").val($(this).text());
		$("input[name='department_id']").val($(this).attr("id"));	  	
	  	$('#myModal').modal('hide');
	});
</script>
