@extends('main')
@section('icerik')
    <style>
        .social{
            color: inherit;
            float: left;
            display: block;
            margin-left: 36px;
            text-align: center;
        }
    </style>
   <div class="content">
      <main aria-role="main" style="text-align: center;">
         <img style="width:7rem;display:inline-block;border-radius:100%;box-shadow:0 0 0 .3618em rgba(0,0,0,.05);" src="{{url('/')}}/img/{{$user->resim}}">
         <h1>{{$user->name}}</h1>
         <p>{{$user->about}}</p><br>
         <div>
 
 

            @php($virgul = explode(",",$user->social))
            @for ($i = 0; $i < count($virgul); $i++)
               @php($nokta = explode(":",$virgul[$i]))
               @if ($nokta[0] == "mail")
                  <a href="mailto:{{ $nokta[1] }}" target="_blank"  class="social">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                     </svg>
                  </a>
               @endif
               @if ($nokta[0] == "github")
                  <a href="https://github.com/{{ $nokta[1] }}" target="_blank" class="social">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                     </svg>
                  </a>
               @endif
               @if ($nokta[0] == "linkedin")
                  <a href="https://www.linkedin.com/in/{{ $nokta[1] }}" target="_blank" class="social">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                        <rect x="2" y="9" width="4" height="12"></rect>
                        <circle cx="4" cy="4" r="2"></circle>
                     </svg>
                  </a>
               @endif
               @if ($nokta[0] == "stackoverflow")
                  <a href="https://www.stackoverflow.com/users/{{ $nokta[1] }}" target="_blank" class="social">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18.986 21.865v-6.404h2.134V24H1.844v-8.539h2.13v6.404h15.012zM6.111 19.731H16.85v-2.137H6.111v2.137zm.259-4.852l10.48 2.189.451-2.07-10.478-2.187-.453 2.068zm1.359-5.056l9.705 4.53.903-1.95-9.706-4.53-.902 1.936v.014zm2.715-4.785l8.217 6.855 1.359-1.62-8.216-6.853-1.35 1.617-.01.001zM15.751 0l-1.746 1.294 6.405 8.604 1.746-1.294L15.749 0h.002z"/>
                     </svg>
                  </a>
               @endif
            @endfor
         </div>
      </main>
   </div>
@endsection
