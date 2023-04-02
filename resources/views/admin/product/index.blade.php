@extends('layouts.admin')

@section('title', 'Products')
    
@section('admin_content')

	<div class="row">
        <div class="col-xl-4">
            <h3 class="mt-4">Products</h3>
        </div>
        <div class="col-xl-4">
            <div class="mt-4">
                
            </div>
        </div>
        <div class="col-xl-4 text-end">
            <a href="{{ route('admin.product.create') }}" class="mt-4 btn btn-sm btn-danger">+Add</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card text-white mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.product.index') }}" method="get">

                        <table class="table table-striped">
                            <div class="row">
                                <div class="col-xl-7">
                                    <div class="form-group">
                                        <select name="per_page" onchange="submit()" id="per_page" class="custom-select">
                                            <option {{ request('per_page')==10?'selected':'' }} value="10">10</option>
                                            <option {{ request('per_page')==20?'selected':'' }} value="20">20</option>
                                            <option {{ request('per_page')==30?'selected':'' }} value="30">30</option>
                                            <option {{ request('per_page')==40?'selected':'' }} value="40">40</option>
                                            <option {{ request('per_page')==50?'selected':'' }} value="50">50</option>
                                            <option {{ request('per_page')==60?'selected':'' }} value="60">60</option>
                                            <option {{ request('per_page')==70?'selected':'' }} value="70">70</option>
                                            <option {{ request('per_page')==80?'selected':'' }} value="80">80</option>
                                            <option {{ request('per_page')==90?'selected':'' }} value="90">90</option>
                                            <option {{ request('per_page')==100?'selected':'' }} value="100">100</option>
                                        </select>
                                        <label for="per_page" class="text-dark">Per Page</label>
                                    </div>
                                </div>

                                <div class="col-xl-5">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <input type="search" value="{{ request('keyword') }}" name="keyword" class="custom-select w-100">
                                        </div>
                                        <div class="col-sm-5 text-start"> 
                                            <button onclick="click()" class="btn btn-success btn-sm">Search</button>
                                            <a href="{{ route('admin.product.index') }}" class="btn btn-danger btn-sm">Reset</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                              <thead>
                                <tr>
                                  <th scope="col">SL</th>
                                  <th scope="col">Thumbnail</th>
                                  <th scope="col">Product Name</th>
                                  <th scope="col">Product Code</th>
                                  <th scope="col">Category</th>
                                  <th scope="col">Sub-Category</th>
                                  <th scope="col">Child-Category</th>
                                  <th scope="col">Brand</th>
                                  <th scope="col">Qty</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Slider</th>
                                  <th scope="col">Today Deal</th>
                                  <th scope="col">Featured</th>
                                  <th scope="col">Trendy</th>
                                  <th scope="col">Date</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>

                              <tbody>
                                @if(!empty($products) && $products->count())
                                    @foreach ($products as $key => $product)
                                    <tr>
                                          <th scope="row">{{ ++$key }}</th>
                                          <td>
                                              <img src="{{ asset('storage/'.$product->thumbnail) }}" width="80" height="50" alt="">
                                          </td>
                                          <td>{{ Str::limit($product->p_name, 30) }}</td>
                                          <td>{{ $product->p_code }}</td>
                                          <td>{{ $product->category->cat_name }}</td>
                                          <td>{{ $product->subcat->subcat_name }}</td>
                                          <td>{{ $product->childcat->childcat_name }}</td>
                                          <td>{{ $product->brand->brand_name }}</td>
                                          <td>{{ $product->stock_qty }}</td>
                                          <td>
                                            @if($product->status ==1)
                                                <a title="Click to InActive" href="{{ route('admin.product.status.inactive', $product->id) }}"><span class='badge bg-success'>Active</span></a>
                                            @else
                                                <a href="{{ route('admin.product.status.active', $product->id) }}"><span class='badge bg-danger'>InActive</span></a>
                                            @endif
                                          </td>

                                          <td>
                                            @if($product->slider ==1)
                                                <a href=""><span class='badge bg-success'>Active</span></a>
                                            @else
                                                <a href=""><span class='badge bg-danger'>InActive</span></a>
                                            @endif
                                          </td>

                                          <td>
                                            @if($product->today_deal ==1)
                                                <a href=""><span class='badge bg-success'>Active</span></a>
                                            @else
                                                <a href=""><span class='badge bg-danger'>InActive</span></a>
                                            @endif
                                          </td>

                                          <td>
                                            @if($product->featured ==1)
                                                <a href=""><span class='badge bg-success'>Active</span></a>
                                            @else
                                                <a href=""><span class='badge bg-danger'>InActive</span></a>
                                            @endif
                                          </td>

                                          <td>
                                            @if($product->trendy ==1)
                                                <a href=""><span class='badge bg-success'>Active</span></a>
                                            @else
                                                <a href=""><span class='badge bg-danger'>InActive</span></a>
                                            @endif
                                          </td>

                                          <td>
                                            {{ date('Y-m-d', strtotime($product->date_time)) }}
                                          </td>

                                          <td colspan="2">
                                              <a href="{{ route('admin.product.edit', $product->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                              <a href="{{ route('admin.product.destroy', $product->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                          </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-danger text-center" colspan="10">Product not found!</td>
                                    </tr>
                                @endif
                              </tbody>
                        </table>

                        <div class="row">
                            <div class="col-xl-12">
                                {!! $products->appends(Request::all())->links() !!}
                            </div>
                        </div>  
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    
@endsection
