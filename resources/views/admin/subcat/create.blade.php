@extends('layouts.admin')

@section('title', 'Create Sub-Category')
    
@section('admin_content')

    
    <div class="row justify-content-center">
        <div class="col-xl-4 col-md-4">

			<div class="row">
		        <div class="col-xl-8">
		            <h3 class="mt-4">Sub-Category Create</h3>
		        </div>
		        <div class="col-xl-4 text-end">
		            <a href="{{ route('admin.subcategory.index') }}" class="mt-4 btn btn-sm btn-danger">Back</a>
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
	            <form method="POST" action="{{ route('admin.subcategory.store') }}">
	                @csrf
	                <div class="card-body">
					  <div class="form-group mb-2">
					    <label for="cat_id" class="text-dark">Category <strong class="text-danger">*</strong></label>
					    <select class="custom-select w-100" id="cat_id" name="cat_id">
					    	<option selected disabled>Select</option>
					    	@foreach($categories as $category)
					    		<option value="{{ $category->id }}">{{ $category->cat_name }}</option>

					    	@endforeach
					    </select>

					    @error('cat_id')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

					  <div class="form-group">
					    <label for="subcat_name" class="text-dark">Sub-Category Name <strong class="text-danger">*</strong></label>
					    <input type="text" class="form-control" id="subcat_name" name="subcat_name">

					    @error('subcat_name')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

	                </div>

				  	<div class="card-footer">
				  		<a href="{{ route('admin.subcategory.index') }}" class="btn btn-danger">Cancel</a>
				  		<button type="submit" class="btn btn-primary">Submit</button>
				  	</div>
				</form>
            </div>
        </div>
    </div>

    
@endsection
