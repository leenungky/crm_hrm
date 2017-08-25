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
     <style type="text/css">
     	.ui-accordion2-header{
     		height: 50px;
     	}

     	.ui-accordion2-header .title{
     		width: 75%;
    		position: absolute;
     	}
     	.ui-accordion2-header .tools{
		    position: absolute;
		    right: 10px;
		    top: 10px;
		    width: 20%;
		}

		
		.ui-accordion2-header .tools a {
		    width: auto;
		    display: inline;
		}
     </style>

</head>
<body >
    <?php use App\Http\Helpers\Helpdesk; ?>
 
 <div id="contents">
    <div class="container container-fluid">            	
		@include('header')		
		<br/>					
		<div class="row">	
			<div class="col-md-12">
			<a href="/pcat/add">Create</a>
			</div>
		</div>
		<br/>
		 @if(Session::has('message'))
            <div class="row">               
                <div class="col-md-12 alert alert-warning">      
                    <ul>
                        <li>{!! Session::get('message') !!}</li>                      
                    </ul>
                </div>
            </div>
            <br/>
        @endif  		        
		<div class="row">
			<div class="col-md-12">				
				<div id="accordion"  class="ui-accordion2-group">
					@foreach ($paycatDB as $key => $value)
						<h3 class="ui-accordion2-header" data-sectionid="{{$value->id}}">
							<span class="title">		            				
		        				<strong>{{$value->name}}</strong> | {{$value->formula}}
		        			</span>
		        			<div class="tools">		            				
		            				<a href="#" class="edit">Edit</a> | 
		            				<a href="#" class="delete">Delete</a> |
		            				<a href="#" class="newactivity">New Employee</a> 
		        			</div>
		    			</h3>							
						<div>
							<table class="table">
								<thead>
									<th>Nik</th>
									<th>Name</th>
									<th>Action</th>
								</thead>
								<tbody>		
									@if (isset($paycat_employe[$value->id]))							
										@foreach ($paycat_employe[$value->id] as $key1 => $value1)
											<tr>
												<td>{{$value1->nik}}</td>
												<td>{{$value1->name}}</td>
												<td>						
													<a href="/pcat/editemployee?id={{$value1->employee_id}}&catid={{$value->id}}">						
									    					<span class="glyphicon glyphicon-pencil"></span>
								    				</a> |						
								    				<a href="/pcat/deleteemployee/{{$value1->id}}" class="confirmation">
									    				<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
								    				</a> 
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>    
						</div>
					@endforeach

				</div>
	 		</div>	    	
		</div>
	</div>
</div>
@include("footer");
</body>
</html>
<script type="text/javascript">
	 $(function() {
		$("#accordion").accordion({
		    alwaysOpen: false,
		    active: false,
		    autoheight: false,
		    clearStyle: true
		}).find('.tools a').click(function(ev){
		    ev.preventDefault();
		    ev.stopPropagation();
		    var $obj = $(this);
		    var sectionid = $obj.closest('h3').attr('data-sectionid');
		    if ($obj.hasClass('newactivity')){
		    	$(".modal-body").load(base_url + "/pcat/newemployee?id=" + sectionid);
				$('#myModal').modal('show'); 
		    } else if ($obj.hasClass('edit')){
		    	location.href = base_url + "/pcat/edit/" + sectionid;
		    } else if ($obj.hasClass('delete')){
		    	var confir =  confirm('Are you sure?'); 
		    	if (confir){
		    			location.href = base_url + "/pcat/delete/" + sectionid;	
		    	}
		        
		    }
		});
	});

</script>



