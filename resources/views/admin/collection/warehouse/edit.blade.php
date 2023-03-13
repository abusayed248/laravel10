@extends('layouts.admin')

@section('title', 'Edit Warehouse')
    
@section('admin_content')

    
    <div class="row justify-content-center">
        <div class="col-xl-4 col-md-4">

			<div class="row">
		        <div class="col-xl-8">
		            <h3 class="mt-4">Warehouse Edit</h3>
		        </div>
		        <div class="col-xl-4 text-end">
		            <a href="{{ route('admin.warehouse.index') }}" class="mt-4 btn btn-sm btn-danger">Back</a>
		        </div>
		    </div>

		    @if(Session::has('error'))
			<div class="row">
		        <div class="col-xl-12">
                    <div class="alert alert-danger mt-4" role="alert">
					  {{ Session::get('error') }}
					</div>
		        </div>
		    </div>
			@endif

            <div class="card mb-4">
	            <form method="POST" action="{{ route('admin.warehouse.update', $warehouse->id) }}">
	                @csrf
	                @method('put')

	                <div class="card-body">

					  <div class="form-group mb-3">
					    <label for="warehouse_name" class="text-dark">Warehouse Name <strong class="text-danger">*</strong></label>
					    <input type="text" value="{{ $warehouse->warehouse_name }}" placeholder="Warehouse name..." class="form-control" id="warehouse_name" name="warehouse_name">

					    @error('warehouse_name')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

					  <div class="form-group mb-3">
					    <label for="warehouse_phone" class="text-dark">Warehouse Phone <strong class="text-danger">*</strong></label>
					    <input type="text" value="{{ $warehouse->warehouse_phone }}" placeholder="Warehouse phone..." class="form-control" id="warehouse_phone" name="warehouse_phone">

					    @error('warehouse_phone')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

					  <div class="form-group mb-3">
					    <label for="warehouse_address" class="text-dark">Warehouse Address <strong class="text-danger">*</strong></label>
					    <input type="text" value="{{ $warehouse->warehouse_address }}" class="form-control" placeholder="Warehouse address..." id="warehouse_address" name="warehouse_address">

					    @error('warehouse_address')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

	                </div>

				  	<div class="card-footer">
				  		<a href="{{ route('admin.warehouse.index') }}" class="btn btn-danger">Cancel</a>
				  		<button type="submit" class="btn btn-primary">Submit</button>
				  	</div>
				</form>
            </div>
        </div>
    </div>

    
@endsection
