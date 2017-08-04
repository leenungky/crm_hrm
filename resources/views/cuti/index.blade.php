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
		<div class="row">	
			<div class="col-md-12">
			<a href="/cuti/add">Create</a>
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
				<table class="table">					
					<thead>
						<th>Nama</th>
			    		<th>Total hari</th>			    		
			    		<th>Mengurangi cuci?</th>			    		
						<th>Action</th>
					</thead>
					<tbody>		
						@foreach ($cuti as $key => $value)
							<tr>
								<td>{{$value->name}}</td><td>{{$value->days}}</td>
								<td>
									@if ($value->isdeduction==1)
										Yes
									@else
										No
									@endif
									</td>
								<td>
									<a href="/cuti/edit/{{$value->id}}">
										<span class="edit"> 
					    					<span class="glyphicon glyphicon-pencil"  rel="tooltip" title="delete"></span>
					    				</span>
				    				</a> | 
				    				<a href="/cuti/delete/{{$value->id}}" class="confirmation">
					    				<span class="delete">
				    						<span class="glyphicon glyphicon-remove"  rel="tooltip" title="delete"></span>
				    					</span>
				    				</a> 
								</td>
							</tr>
						@endforeach						
					</tbody>
				</table>
			</div>
		</div>
	 </div>	    	
</div>
</body>
</html>