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
		<div class="load-tree">						
		</div>
	 </div>	    	
</div>

@include('footer')			
</body>
</html>

<script type="text/javascript">	
	
    $('.load-tree').load(base_url + "/payroll/tree");
	 $.contextMenu({
            selector: '.right-click', 
            callback: function(key, options) {
                var m = "clicked: " + key;
                $(".modal-title").text(key + " payroll " + $(this).text());
                if (key=="add"){	
					$(".modal-body").load(base_url + "/payroll/new?id=" + $(this).attr("id"));
					$('#myModal').modal('show'); 
				}else  if (key=="edit"){	
					$(".modal-body").load(base_url + "/payroll/edit/" + $(this).attr("id"));
					$('#myModal').modal('show'); 
				}				
				else  if (key=="delete"){	
					var conf = confirm('Are you sure?');                    
					if (conf){
                        location.href = base_url + "/payroll/delete/" + $(this).attr("id");
						
					}
				}				
            },
            items: {
            	"add": {name: "Add"},
                "edit": {name: "Edit" },                
                "delete": {name: "Delete"},
                "sep1": "---------",
                "quit": {name: "Quit", icon: function(){
                    return 'context-menu-icon context-menu-icon-quit';
                }}
            }
        });

       
</script>
