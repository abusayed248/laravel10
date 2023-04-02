@extends('layouts.admin')

@section('title', 'Update Setting')
    
@section('admin_content')

    
    <div class="row justify-content-center">
        <div class="col-xl-8 col-md-4">

			<div class="row">
		        <div class="col-xl-8">
		            <h3 class="mt-4">Setting Update</h3>
		        </div>
		        <div class="col-xl-4 text-end">
		            <a href="{{ route('admin.home') }}" class="mt-4 btn btn-sm btn-danger">Dashoard</a>
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
	            <form method="POST" action="{{ route('admin.update.setting', $setting->id) }}" enctype="multipart/form-data">
	                @csrf
	                @method('put')

	                <div class="card-body">

	                	<div class="row">
	                		<div class="form-group mb-2 col-xl-4">
							    <label for="currency" class="text-dark form-label">Currency <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->currency }}" id="currency" name="currency">

							    @error('currency')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>
	                		<div class="form-group mb-2 col-xl-4">
							    <label for="phone_one" class="text-dark form-label">Phone Number <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->phone_one?:old('phone_one') }}" id="phone_one" name="phone_one">

							    @error('phone_one')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>

	                		<div class="form-group mb-2 col-xl-4">
							    <label for="phone_two" class="text-dark form-label">Another Phone Number <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->phone_two?:old('phone_two') }}" id="phone_two" name="phone_two">

							    @error('phone_two')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>
	                	</div>

	                	<div class="row">
	                		<div class="form-group mb-2 col-xl-4">
							    <label for="address" class="text-dark form-label">Address <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->address?:old('address') }}" id="address" name="address">

							    @error('address')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>

							<div class="form-group mb-2 col-xl-4">
							    <label for="main_email" class="text-dark form-label">Main Email <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->main_email?:old('main_email') }}" id="main_email" name="main_email">

							    @error('main_email')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>

	                		<div class="form-group mb-2 col-xl-4">
							    <label for="support_email" class="text-dark form-label">Support Email <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->support_email?:old('support_email') }}" id="support_email" name="support_email">

							    @error('support_email')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>
	                	</div>

	                	<div class="row">
	                		<div class="form-group mb-2 col-xl-4">
							    <label for="facebook" class="text-dark form-label">Facebook <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->facebook?:old('facebook') }}" id="facebook" name="facebook">

							    @error('facebook')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>

	                		<div class="form-group mb-2 col-xl-4">
							    <label for="twitter" class="text-dark form-label">Twitter <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->twitter?:old('twitter') }}" id="twitter" name="twitter">

							    @error('twitter')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>

	                		<div class="form-group mb-2 col-xl-4">
							    <label for="instagram" class="text-dark form-label">Instagram <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->instagram?:old('instagram') }}" id="instagram" name="instagram">

							    @error('instagram')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>
	                	</div>

	                	<div class="row">

	                		<div class="form-group mb-2 col-xl-6">
							    <label for="linkedin" class="text-dark form-label">linkedin <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->linkedin?:old('linkedin') }}" id="linkedin" name="linkedin">

							    @error('linkedin')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>

	                		<div class="form-group mb-2 col-xl-6">
							    <label for="youtube" class="text-dark form-label">youtube <strong class="text-danger">*</strong></label>
							    <input type="text" class="form-control" value="{{ $setting->youtube?:old('youtube') }}" id="youtube" name="youtube">

							    @error('youtube')
		                            <strong class="text-danger">
		                                <strong>{{ $message }}</strong>
		                            </strong>
		                        @enderror
							</div>
	                	</div>

						<div class="row">
							<div class="col-xl-6">
								@if(!empty($setting->logo))
								<div class="form-group mb-2">
									<label for="logo" class="text-dark form-label d-block">Existing Logo</label>
									<img width="100%" height="220" src="{{ asset('storage/'.$setting->logo) }}" alt="{{ $setting->logo }}" title="{{ $setting->logo }}">
									<input type="hidden" value="{{ $setting->old_logo }}" name="old_logo">
								</div>
								@endif
							</div>
							
							<div class="col-xl-6">
								@if(!empty($setting->favicon))
								<div class="form-group mb-2">
									<label for="favicon" class="text-dark form-label d-block">Existing favicon</label>
									<img width="100%" height="220" src="{{ asset('storage/'.$setting->favicon) }}" alt="{{ $setting->favicon }}" title="{{ $setting->favicon }}">
									<input type="hidden" value="{{ $setting->old_favicon }}" name="old_favicon">
								</div>
							@endif
							</div>

						</div>

						<div class="row">
							<div class="col-xl-6">
								<div class="form-group mb-2">
							    <label for="logo" class="text-dark form-label">Logo <strong class="text-danger">*</strong></label>
							    <input type="file" class="form-control dropify" data-height="150" id="logo" name="logo">

							    @error('logo')
						            <strong class="text-danger">
						                <strong>{{ $message }}</strong>
						            </strong>
						        @enderror
							</div>
							</div>

							<div class="col-xl-6">
								<div class="form-group mb-2">
							    <label for="favicon" class="text-dark form-label">Favicon <strong class="text-danger">*</strong></label>
							    <input type="file" class="form-control dropify" data-height="150" id="favicon" name="favicon">

							    @error('favicon')
						            <strong class="text-danger">
						                <strong>{{ $message }}</strong>
						            </strong>
						        @enderror
							</div>
							</div>

						</div>
	                </div>

				  	<div class="card-footer">
				  		<button type="submit" class="btn btn-primary">Update</button>
				  	</div>
				</form>
            </div>
        </div>
    </div>

    
@endsection
