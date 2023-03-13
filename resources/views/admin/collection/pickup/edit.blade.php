@extends('layouts.admin')

@section('title', 'Edit Pickup-Point')
    
@section('admin_content')

    
    <div class="row justify-content-center">
        <div class="col-xl-4 col-md-4">

			<div class="row">
		        <div class="col-xl-8">
		            <h3 class="mt-4">Pickup-Point Edit</h3>
		        </div>
		        <div class="col-xl-4 text-end">
		            <a href="{{ route('admin.pickup.index') }}" class="mt-4 btn btn-sm btn-danger">Back</a>
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
	            <form method="POST" action="{{ route('admin.pickup.update', $pickup->id) }}">
	                @csrf
	                @method('put')

	                <div class="card-body">

					  <div class="form-group mb-3">
					    <label for="pickup_name" class="text-dark">Pickup-Point Name <strong class="text-danger">*</strong></label>
					    <input type="text" value="{{ $pickup->pickup_name }}" placeholder="Pickup-Point name..." class="form-control" id="pickup_name" name="pickup_name">

					    @error('pickup_name')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

					  <div class="form-group mb-3">
					    <label for="pickup_phone" class="text-dark">Pickup-Point Phone <strong class="text-danger">*</strong></label>
					    <input type="text" value="{{ $pickup->pickup_phone }}" placeholder="Pickup-Point phone..." class="form-control" id="pickup_phone" name="pickup_phone">

					    @error('pickup_phone')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

					  <div class="form-group mb-3">
					    <label for="pickup_address" class="text-dark">Pickup-Point Address <strong class="text-danger">*</strong></label>
					    <input type="text" value="{{ $pickup->pickup_address }}" class="form-control" placeholder="Pickup-Point address..." id="pickup_address" name="pickup_address">

					    @error('pickup_address')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

	                </div>

				  	<div class="card-footer">
				  		<a href="{{ route('admin.pickup.index') }}" class="btn btn-danger">Cancel</a>
				  		<button type="submit" class="btn btn-primary">Submit</button>
				  	</div>
				</form>
            </div>
        </div>
    </div>

    
@endsection
