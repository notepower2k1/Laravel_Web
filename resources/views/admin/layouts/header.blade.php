<header>


  <nav class="navbar navbar-light bg-light">
       

    <div class="container-fluid">
        <a href="/"> <img src="{{ asset('storage/logo.png') }}" alt="Groover Brand Logo" class="app-brand-logo"></a>
      <div class="d-flex">

        
        @if(request()->is('/'))
         <a href="./book/create" class="btn btn-danger fas fa-upload"> Đăng sách </a>       
         @else
        <div></div>
        @endif
    
      </div>
    </div>
  </nav>
    
       
         
      
   

   
</header>   