@extends('layouts.admin')

@section('title', 'Edit Child-Category')
    
@section('admin_content')

    
    <div class="row justify-content-center">
        <div class="col-xl-4 col-md-4">

			<div class="row">
		        <div class="col-xl-8">
		            <h3 class="mt-4">Child-Category Edit</h3>
		        </div>
		        <div class="col-xl-4 text-end">
		            <a href="{{ route('admin.childcategory.index') }}" class="mt-4 btn btn-sm btn-danger">Back</a>
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
	            <form method="POST" action="{{ route('admin.childcategory.update', $childcat->id) }}">
	                @csrf
	                @method('put')

	                <div class="card-body">
					  <div class="form-group mb-2">
					    <label for="subcat_id" class="text-dark">Category <strong class="text-danger">*</strong></label>
					    <select class="custom-select w-100" id="subcat_id" name="subcat_id">
					    	@foreach($categories as $category)
					    	@php
					    	$subcats = \App\Models\Subcategory::where('cat_id', $category->id)->get();
					    	@endphp
					    		<option class="text-danger" disabled value="{{ $category->id }}">{{ $category->cat_name }}</option>

					    		@foreach($subcats as $subcat)
									<option {{ $subcat->id == $childcat->subcat_id?'selected':'' }} value="{{ $subcat->id }}">--{{ $subcat->subcat_name }}</option>
					    		@endforeach
					    	@endforeach
					    </select>

					    @error('subcat_id')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

					  <div class="form-group">
					    <label for="childcat_name" class="text-dark">Child-Category Name <strong class="text-danger">*</strong></label>
					    <input value="{{ $childcat->childcat_name }}" type="text" class="form-control" id="childcat_name" name="childcat_name">

					    @error('childcat_name')
                            <strong class="text-danger">
                                <strong>{{ $message }}</strong>
                            </strong>
                        @enderror
					  </div>

	                </div>

				  	<div class="card-footer">
				  		<a href="{{ route('admin.childcategory.index') }}" class="btn btn-danger">Cancel</a>
				  		<button type="submit" class="btn btn-primary">Submit</button>
				  	</div>
				</form>
            </div>
        </div>
    </div>

    
@endsection
