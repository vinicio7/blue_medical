
@extends('layouts.app')

@section('content')

<div class="container">
	 <div class="row">
	 		<div class="card">
	 		<div class="card-header">Lista de pacientes</div>
	 		<div class="card-body">
			    @if (session('status'))
			        <div class="alert alert-success" role="alert">
			            {{ session('status') }}
			        </div>
			    @endif
			    <div id="app" class="content">
			        <principal-component></principal-component>
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection
