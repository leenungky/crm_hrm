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

<div id="modal_payroll_component" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">        
          <div class="row">             
                <div class="col-md-12">
                    <form method="post" action="" id="formsubmit">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">                  
                        <div class="form-group">
                            <label for="email">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="input nama component" value="{{ old('name') }}" required>
                        </div>                                      
                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="is_master" name="is_master" placeholder="input nama component" value="master">
                                Is Master
                            </label>
                        </div>                                      
                        <button type="submit" class="btn">Submit</button>
                        <button type="button"  class="btn" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
      </div>      
    </div>
  </div>
</div>
 
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
                    var id = $(this).attr("id");
                    onAdd(id);				
				}else  if (key=="edit"){	                    
                    var id = $(this).attr("id");                    
                    onEdit(id);					
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

    function onAdd(id){
        $.get( domain + "/payroll/new?id=" + id, function( result ) {                
            if (result.response.code == 200){ 
                $("#is_master").prop('checked', false);
                $("#formsubmit").attr("action", "/payroll/create/" + result.data);                          
                $('#modal_payroll_component').modal('show');
            }
        });       
        
    }

    function onEdit(id){
        $.get( domain + "/payroll/edit/" + id, function( result ) {                
            console.log(result);
            if (result.response.code == 200){ 
                $("input[name=name]").val(result.data.name);
                $("#formsubmit").attr("action", "/payroll/update/" + result.data.id);
                if (result.data.is_master=="1"){
                    $("#is_master").prop('checked', true);    
                }else{
                    $("#is_master").prop('checked', false);    
                }
                
                $('#modal_payroll_component').modal('show');
            }
        });       
    }

       
</script>
