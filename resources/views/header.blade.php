 <script type="text/javascript">
    var base_url = "{{config('config.url')}}";
    $(document).ready(function(){
        $(document).idleTimeout({
            inactivity: 3000000, 
            noconfirm: 900000,      
            sessionAlive:900000,
            redirect_url :base_url + "/user/logout"
        });
    });
</script>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <div>
      <ul class="nav navbar-nav">        
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Employee
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/employ/list">Data</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Absence<i class="glyphicon glyphicon-chevron-right"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="/working/list">Working Time</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/empermition/list">Permition</a></li>
                    
                </ul>
            </li>   
            <li role="separator" class="divider"></li>
            <li><a href="/payrollemploy/list">Payroll</a></li>            
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Master Data
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="#">Karyawan Attribute<i class="glyphicon glyphicon-chevron-right"></i></a>
                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="/department/list">Department</a></li>                           
                        <li role="separator" class="divider"></li>
                        <li><a href="/jobtitle/list">Job Title</a></li> 
                        <li role="separator" class="divider"></li>
                        <li><a href="/family/list">Family Relation</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/education/list">Education</a></li>   
                        <li role="separator" class="divider"></li>
                        <li><a href="/branch/list">Cabang</a></li>
                    </ul>
                </li>                         
                <li role="separator" class="divider"></li>  
                <li class="dropdown-submenu">
                    <a tabindex="-1" href="#">Payroll<i class="glyphicon glyphicon-chevron-right"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/payroll/list">Payroll Component</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/masteremploy/list">Payroll Employee</a></li>                        
                    </ul>
                </li>   
          </ul>
        </li>        
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Setting
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
                <li class="dropdown-submenu">
                    <li><a href="/pcat/list">Payroll Category</a></li>
                </li>                                   
          </ul>
        </li>        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> {{\Auth::user()->first_name}} {{\Auth::user()->lasts_name}} <img src="{{URL::asset('img/user.png')}}" class="user" /><span  class="glyphicon glyphicon-log-in"></span></a>
            <ul class="dropdown-menu">
            <li><a href="/user/logout">logout</a></li>            
        </ul>          
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="row">
        <div class="col-md-12">
            <div class="status-barang">{{ucwords(str_replace("_"," ",$type))}}</strong></div>
        </div>          
    </div> 