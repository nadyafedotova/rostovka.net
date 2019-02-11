@extends('user.markup.markup')

@section('category')
	<div class="container">
		<div class="card" style="margin: 5% 0%;">
      		<div class="card-header" style="text-align:center;">Бренды</div>
      		<div class="card-body">		
				<ul class="border col-md-12">
					<div class="row" style="padding: 15px 35px;"> 
					    @foreach($brands as $brand)
					       <div class="col-lg-3 col-md-3 col-xs-6">
					       	<li><a href="/brand/{{$brand -> name}}">{{ $brand -> name }} </a></li>
					       </div>
					    @endforeach
					</div>
				</ul>
			</div>
    	</div>
	</div>
@endsection

@section('category__Lib')
    <script type="text/javascript" src="{{asset('js/categoryData.js?version=2.1.8')}}"></script>
@endsection
