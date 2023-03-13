@extends('layouts.admin')

@section('title', 'Create Edit')
    
@section('admin_content')

    
    <div class="row justify-content-center">
        <div class="col-xl-6 col-md-6">

			<div class="row">
		        <div class="col-xl-4">
		            <h3 class="mt-4">Category Edit</h3>
		        </div>
		        <div class="col-xl-4">
		            <div class="mt-4">
		                
		            </div>
		        </div>
		        <div class="col-xl-4 text-end">
		            <a href="{{ route('admin.category.index') }}" class="mt-4 btn btn-sm btn-danger">Back</a>
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

            <div class="card text-white mb-4">
	            <form method="POST" action="{{ route('admin.category.update', $category->id) }}">
	                @csrf
	                @method('put')
	                
	                <div class="card-body">
					  <div class="form-group">
					    <label for="cat_name" class="text-dark">Category Name <strong class="text-danger">*</strong></label>
					    <input type="text" value="{{ $category->cat_name }}" class="form-control" id="cat_name" name="cat_name">

					    @error('cat_name')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>
	                </div>

				  	<div class="card-footer">
				  		<a href="{{ route('admin.category.index') }}" class="btn btn-danger">Cancel</a>
				  		<button type="submit" class="btn btn-primary">Submit</button>
				  	</div>
				</form>
            </div>
        </div>
    </div>

    
@endsection
