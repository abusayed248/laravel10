@extends('layouts.admin')

@section('title', 'Edit Brand')
    
@section('admin_content')

    
    <div class="row justify-content-center">
        <div class="col-xl-4 col-md-4">

			<div class="row">
		        <div class="col-xl-8">
		            <h3 class="mt-4">Brand Edit</h3>
		        </div>
		        <div class="col-xl-4 text-end">
		            <a href="{{ route('admin.brand.index') }}" class="mt-4 btn btn-sm btn-danger">Back</a>
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
	            <form method="POST" action="{{ route('admin.brand.update', $brand->id) }}" enctype="multipart/form-data">
	                @csrf
	                @method('put')

	                <div class="card-body">

					  <div class="form-group mb-2">
					    <label for="brand_name" class="text-dark">Brand Name <strong class="text-danger">*</strong></label>
					    <input type="text" class="form-control" value="{{ $brand->brand_name }}" id="brand_name" name="brand_name">

					    @error('brand_name')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

					  @if(!empty($brand->brand_logo))
					  <div class="form-group mb-2">
					    <label for="brand_logo" class="text-dark form-label d-block">Existing Logo</label>
					    <img width="100%" height="220" src="{{ asset('storage/'.$brand->brand_logo) }}" alt="{{ $brand->brand_name }}" title="{{ $brand->brand_name }}">
					    <input type="hidden" value="{{ $brand->brand_logo }}" name="old_logo">
					  </div>
					  @endif

					   <div class="form-group mb-2">
					    <label for="brand_logo" class="text-dark">Brand Logo <strong class="text-danger">*</strong></label>
					    <input type="file" class="form-control dropify" id="brand_logo" name="brand_logo">

					    @error('brand_logo')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

					  <div class="form-group mb-2">
					    <label for="status" class="text-dark">Status</label>
					    <select class="custom-select w-100" id="status" name="status">
					    	<option selected disabled>Select</option>
					    	<option {{ $brand->status==1?'selected':'' }} value="1">Active</option>
					    	<option {{ $brand->status==0?'selected':'' }} value="0">Inactive</option>
					    </select>

					    @error('status')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

	                </div>

				  	<div class="card-footer">
				  		<a href="{{ route('admin.brand.index') }}" class="btn btn-danger">Cancel</a>
				  		<button type="submit" class="btn btn-primary">Submit</button>
				  	</div>
				</form>
            </div>
        </div>
    </div>

    
@endsection
