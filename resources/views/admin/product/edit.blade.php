@extends('layouts.admin')

@section('title', 'Edit Product')
    
@section('admin_content')

<style>
	.images {
	    position: relative;
	}

	.remove-files {
	    position: absolute;
	    right: 60px;
	    top: 0;
	}
</style>

<!-- Stylesheet -->

    <div class="row justify-content-center">
        <div class="col-xl-12 col-md-4">

			<div class="row">
		        <div class="col-xl-8">
		            <h3 class="mt-4">Product Edit</h3>
		        </div>
		        <div class="col-xl-4 text-end">
		            <a href="{{ route('admin.product.index') }}" class="mt-4 btn btn-sm btn-danger">Back</a>
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
	            <form method="POST" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data">
	                @csrf
	                @method('put')

	                <input type="hidden" name="old_thumbnail" value="{{ $product->thumbnail }}">

	                <div class="card-body">
	                	<div class="row">
	                		<div class="col-xl-8">
	                			<div class="row mb-3">
	                				<div class="form-group col-xl-6">
									    <label for="p_name" class="text-dark form-label">Product Name <strong class="text-danger">*</strong></label>
									    <input type="text" value="{{ $product->p_name }}" placeholder="Product name..." class="form-control" id="p_name" name="p_name">

									    @error('p_name')
				                            <strong class="text-danger">
				                                <strong>{{ $message }}</strong>
				                            </strong>
				                        @enderror
									</div>

									<div class="form-group col-xl-6">
										<label for="p_code" class="text-dark form-label">Product Code <strong class="text-danger">*</strong></label>
										<input type="text" value="{{ $product->p_code }}" placeholder="Product code..." class="form-control" id="p_code" name="p_code">

										@error('p_code')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>
	                			</div>
	                			
	                			<div class="row mb-3">
									<div class="form-group col-xl-6">
										<label for="subcat_id" class="text-dark form-label">Category/Subcategory <strong class="text-danger">*</strong></label>
										<select class="form-control" id="subcat_id" name="subcat_id">
											@foreach($categories as $category)
											@php
											$subcats = App\Models\Subcategory::where('cat_id', $category->id)->get();
											@endphp

											<option class="text-primary" disabled value="{{ $category->id }}">{{ $category->cat_name }}</option>
											@foreach($subcats as $subcat)
												<option {{ $product->subcat_id==$subcat->id?'selected':'' }} class="text-danger" value="{{ $subcat->id }}">-- {{ $subcat->subcat_name }}</option>
											@endforeach
											@endforeach
										</select>

										@error('subcat_id')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>

									<div class="form-group col-xl-6">
										<label for="childcat_id" class="text-dark form-label">Child-Category</label>
										<select class="form-control" id="childcat_id" name="childcat_id">
											@foreach($childcats as $childcat)
											<option value="{{ $childcat->id }}" {{ $product->childcat_id==$childcat->id?'selected':'' }}>{{ $childcat->childcat_name }}</option>
											@endforeach
										</select>
									</div>

								</div>
	                			
	                			<div class="row mb-3">
									<div class="form-group col-xl-4">
										<label for="brand_id" class="text-dark form-label">Brand</label>
										<select class="form-control" id="brand_id" name="brand_id">
											<option disabled selected>Select One</option>
											@foreach($brands as $brand)
												<option {{ $product->brand_id==$brand->id?'selected':'' }} value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
											@endforeach
										</select>

										@error('brand_id')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>

									<div class="form-group col-xl-4">
										<label for="warehouse_id" class="text-dark form-label">Warehouse <strong class="text-danger">*</strong></label>
										<select class="form-control" id="warehouse_id" name="warehouse_id">
											<option disabled selected>Select One</option>
											@foreach($warehouses as $warehouse)
												<option {{ $product->warehouse_id==$warehouse->id?'selected':'' }} value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
											@endforeach
										</select>

										@error('warehouse_id')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>

									<div class="form-group col-xl-4">
										<label for="pickup_id" class="text-dark form-label">Pickup-Points <strong class="text-danger">*</strong></label>
										<select class="form-control" id="pickup_id" name="pickup_id">
											<option disabled selected>Select One</option>
											@foreach($pickups as $pickup)
												<option {{ $product->pickup_id==$pickup->id?'selected':'' }} value="{{ $pickup->id }}">{{ $pickup->pickup_name }}</option>
											@endforeach
										</select>

										@error('pickup_id')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>
								</div>
	                			
	                			<div class="row mb-3">
									<div class="form-group col-xl-4">
										<label for="unit" class="text-dark form-label">Unit <strong class="text-danger">*</strong></label>
										<input type="text" value="{{ $product->unit }}" class="form-control" placeholder="unit..." id="unit" name="unit" />

										@error('unit')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>

									<div class="form-group col-xl-4">
										<label for="tags" class="text-dark form-label">Tags</label>
										<input value="{{ $product->tags }}" type="text" data-role="tagsinput" class="form-control tags" placeholder="tag..." id="tags" name="tags[]" />
									</div>

									<div class="form-group col-xl-4">
										<label for="size" class="text-dark form-label">Size <strong class="text-danger">*</strong></label>
										<input type="text" value="{{ $product->size }}" data-role="tagsinput" class="form-control size" placeholder="size..." id="size" name="size[]" />

										@error('size')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>
								</div>
	                			
	                			<div class="row mb-3">
									<div class="form-group col-xl-4">
										<label for="purchage_price" class="text-dark form-label">Purchage Price <strong class="text-danger">*</strong></label>
										<input type="number" value="{{ $product->purchage_price }}" min="1" class="form-control" placeholder="purchage_price..." id="purchage_price" name="purchage_price" />

										@error('purchage_price')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>

									<div class="form-group col-xl-4">
										<label for="regular_price" class="text-dark form-label">Regular Price <strong class="text-danger">*</strong></label>
										<input type="number" min="1" class="form-control" placeholder="regular_price..." value="{{ $product->regular_price }}" id="regular_price" name="regular_price" />

										@error('regular_price')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>

									<div class="form-group col-xl-4">
										<label for="discount_price" class="text-dark form-label">Discount Price</label>
										<input type="number" min="1" value="{{ $product->discount_price }}" value="{{ old('discount_price') }}"class="form-control" placeholder="Discount Price..." id="discount_price" name="discount_price" />
									</div>
								</div>
	                			
	                			<div class="row mb-3">
									<div class="form-group col-xl-4">
										<label for="colors" class="text-dark form-label">Colors <strong class="text-danger">*</strong></label>
										<input type="text" value="{{ $product->colors }}" data-role="tagsinput" class="form-control colors" placeholder="colors..." id="colors" name="colors[]" />

										@error('colors')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>

									<div class="form-group col-xl-4">
										<label for="video" class="text-dark form-label">Youtube video embebed code</label>
										<input type="text" value="{{ $product->video }}" class="form-control" placeholder="Youtube video embeded code..." id="video" name="video" />
									</div>

									<div class="form-group col-xl-4">
										<label for="stock_qty" class="text-dark form-label">Stock Qty <strong class="text-danger">*</strong></label>
										<input type="number" min="1" value="{{ $product->stock_qty }}" class="form-control" placeholder="Stock Quantity..." id="stock_qty" name="stock_qty" />

										@error('stock_qty')
										    <strong class="text-danger">
										        <strong>{{ $message }}</strong>
										    </strong>
										@enderror
									</div>
								</div>

								<div class="form-group">
									<label for="description" class="text-dark form-label">Description <strong class="text-danger">*</strong></label>
									<textarea class="form-control description" placeholder="Product description..." id="description" name="description">{{ $product->description }}</textarea>

									@error('description')
									    <strong class="text-danger">
									        <strong>{{ $message }}</strong>
									    </strong>
									@enderror
								</div>
		                	</div>

		                	<div class="col-xl-4">
		                		@if(!empty($product->thumbnail))
		                		<div class="form-group mb-3">
									<label class="text-dark form-label">Existing Thumbnail</label>
									<img height="200" width="100%" src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->p_slug }}">
									<input type="hidden" value="{{ $product->thumbnail }}" name="old_thumbnail">
								</div>
								@endif

		                		<div class="form-group mb-3">
									<label for="thumbnail" class="text-dark form-label">Thumbnail <strong class="text-danger">*</strong></label>
									<input type="file" class="form-control dropify" id="thumbnail" name="thumbnail">

									@error('thumbnail')
									    <strong class="text-danger">
									        <strong>{{ $message }}</strong>
									    </strong>
									@enderror
								</div>

								<div class=" mb-3">  
				                    <table class="table table-bordered" id="dynamic_field">
					                    <div class="card-header">
					                      <h4 class="card-title">More Images (Click Add For More Image)</h4>
					                    </div>
				                    	@php
				                    		$images = json_decode($product->images);
				                    	@endphp

					                    <div class="row py-3">
					                    	@foreach($images as $image)
						                    <div class="col-xl-4 images">
					                    		<img height="80" width="80" src="{{ asset('storage/products/images/'.$image) }}" alt="">
					                    		<input type="hidden" name="old_images[]" value="{{ $image }}">
	                            				<button type="button" class="remove-files" style="border: none;">X</button>
						                    </div> 
						                    @endforeach
					                    </div>
				                    	

										<tr>  
										  <td><input type="file" accept="image/*" name="images[]" class="form-control name_list" /></td>  
										  <td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>  
										</tr>  
				                    </table>    
				                </div>

								<div class="m-1 row mb-3">
									<div class="card p-3 col-xl-4">
										<label class="form-label" for="slider">Slider</label>
								  		<input type="checkbox" {{ $product->slider==1?'checked':'' }} name="slider" data-toggle="switchbutton" value="1" data-onstyle="success" data-offstyle="danger">
									</div>
									<div class="card p-3 col-xl-4">
										<label class="form-label" for="trendy">Trendy</label>
								  		<input type="checkbox" name="trendy" {{ $product->trendy==1?'checked':'' }} data-toggle="switchbutton" value="1" data-onstyle="success" data-offstyle="danger">
									</div>

									<div class="card p-3 col-xl-4">
										<label class="form-label" for="trendy">Today Deal</label>
								  		<input type="checkbox" name="today_deal" {{ $product->today_deal==1?'checked':'' }} data-toggle="switchbutton" value="1" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

								<div class="m-1 row">
									<div class="card p-3 col-xl-6">
										<label class="form-label" for="slider">Featured</label>
								  		<input type="checkbox" name="featured" {{ $product->featured==1?'checked':'' }} data-toggle="switchbutton" value="1" data-onstyle="success" data-offstyle="danger">
									</div>
									<div class="card p-3 col-xl-6">
										<label class="form-label" for="trendy">Status</label>
								  		<input type="checkbox" name="status" {{ $product->status==1?'checked':'' }} data-toggle="switchbutton" value="1" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
		                	</div>
		                </div>
	                </div>

				  	<div class="card-footer">
				  		<a href="{{ route('admin.product.index') }}" class="btn btn-danger">Cancel</a>
				  		<button type="submit" class="btn btn-primary">Submit</button>
				  	</div>
				</form>
            </div>
        </div>
    </div>

    
@endsection

@push('script')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@1/dist/tinymce-jquery.min.js"></script>

{{-- switch button --}}
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>

<script>
	//ajax request send for collect childcategory
	$("#subcat_id").change(function(){
		var id = $(this).val();
		$.ajax({
		   url: "{{ url("admin/get-child-category/") }}/"+id,
		   type: 'get',
		   success: function(data) {
		        $('select[name="childcat_id"]').empty();
		           $.each(data, function(key,data){
		              $('select[name="childcat_id"]').append('<option value="'+ data.id +'">'+ data.childcat_name +'</option>');
		        });
		   }
		});
	});


	// add more image load on ajax
	$(document).ready(function(){      
       var postURL = "<?php echo url('addmore'); ?>";
       var i=1;  


       $('#add').click(function(){  
            i++;  
            $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="file" accept="image/*" name="images[]" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
       });  

       $(document).on('click', '.btn_remove', function(){  
            var button_id = $(this).attr("id");   
            $('#row'+button_id+'').remove();  
       });  
     }); 

	//edit product imahe remove by cros btn
	$('.remove-files').on('click', function(){
	  $(this).parents(".images").remove();
	});
</script>

<script type="text/javascript">

	// taginputs
	$('.colors', 'size', 'colors').val();	

	// tinymce
	$('.description').tinymce({
		height: 500,
		menubar: false,
		plugins: [
		   'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
		   'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
		   'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
		],
		toolbar: 'undo redo | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist checklist outdent indent | removeformat | code table help'
	});

	// switch button
	document.getElementById('chkToggle2').switchButton();

</script>

@endpush