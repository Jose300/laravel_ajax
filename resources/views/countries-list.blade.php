@extends('layout')

@section('contenido')

<!--PAGE CONTENT-->
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Listado de Paises</title>
	</head>
	<body>
	
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">Listado de Paises</div>
						<div class="card-body">
							<table class="table table-hover table-condensed" id="countries-table">
								<thead>
									<th><input type="checkbox" name="main_checkbox"><label></label></th>
									<th>#</th>
									<th>País</th>
									<th>Ciudad Capital</th>
									<th>Actions <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Eliminar Todos</button></th>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="card">
						<div class="card-header">Agregar Nuevo País</div>
						<div class="card-body">
							<form action="{{ route('add.country') }}" method="POST" id="add-country-form">
								@csrf
								<div class="form-group">
									<label for="">País</label>
									<input type="text" class="form-control" name="country_name" placeholder="Enter Country name">
									<span class="text-danger error-text country_name_error"></span>
								</div>

								<div class="form-group">
									<label for="">Capital</label>
									<input type="text" class="form-control" name="capital_city" placeholder="Enter Capital City">
									<span class="text-danger error-text capital_city_error"></span>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-block btn-success">GUARDAR</button>
								</div>
								

							</form>
						</div>
					</div>
				</div>


			</div>
		</div>

		@include('edit-country-modal');

	</body>
	</html>

@endsection