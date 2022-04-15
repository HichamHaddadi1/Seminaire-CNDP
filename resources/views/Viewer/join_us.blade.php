@extends('layouts.viewer_layout')


@section('viewer_content')
<link rel="stylesheet" href="\css\joinus.css">
<link rel="stylesheet" href="\css\contactstylemain.css">
<style>
  .nav-link{
    color:white;
  }

</style>
<section class="wrapper">
    <div class="container text-center">
    
    <div class="row">
   <div class="col-md-4 left_card"><div class="card text-white card-has-bg " style="background-image:url('/img/student.jpg');">
           <img class="card-img d-none" src="https://source.unsplash.com/600x900/?tech,street" alt="">
          <div class="card-img-overlay d-flex flex-column">
           
           <div class="card-body">
             <!-- <small class="card-meta mb-2">Become A</small>
              <h4 class="card-title mt-0 "><a class="text-white" herf="#">Viewer</a></h4>-->
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio laborum beatae dolorem ipsa dolores. Reprehenderit, eum quod sapiente nostrum cum quos</p>
            </div>
            <div class="card-footer">
              <a href="{{route('userRegister')}}" class="nav-link btn btn-primary" style="font-size: 12px"> Register as User </a>
            </div>
          </div>
        </div></div>
     

       <div class="col-md-4 right_card"><div class="card text-white card-has-bg click-col" style="background-image:url('/img/teacher.jpg');">
           <img class="card-img d-none" src="https://source.unsplash.com/600x900/?tree,nature" alt="Goverment Lorem Ipsum Sit Amet Consectetur dipisi?">
          <div class="card-img-overlay d-flex flex-column">
           <div class="card-body">
             <!-- <small class="card-meta mb-2">Become A</small>
              <h4 class="card-title mt-0 "><a class="text-white" herf="#">Streamer</a></h4>-->
             <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio laborum beatae dolorem ipsa dolores. Reprehenderit, eum quod sapiente nostrum cum quos</p>
            </div>
            <div class="card-footer">
              <a href="{{route('register')}}" class="nav-link btn btn-primary" style="font-size: 12px"> Register as Seminarist </a>
            </div>
          </div>
        </div></div>
   
    
  </div>
    
  </div>
  </section>



@endsection