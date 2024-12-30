<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5>Top Sold Products</h5>
                <div class="table-responsive">
                    <table class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>#SKU</th>
                                <th>Photo</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                                <tr>
                                    <td>{{ $product->sku }}</td>
                                    <td>
                                        @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">
                                        @else
                                        <i class="fas fa-box" style="font-size: 24px; color: gray;"></i>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ $product->total_quantity }}</td> <!-- Display the Total Quantity Sold -->
                                    {{-- <td>{{ $product->price_usd }}</td> --}}
                                    {{-- <td>
                                        @foreach($product->orders as $order)
                                            <p>{{ $order->user->name }}</p> <!-- assuming there's a user relation -->
                                        @endforeach
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#SKU</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h5>Recent Customers</h5>
                <div class="table-responsive">
                    <table class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCustomers as $customer)
                            <tr>
                                <td>
                                    @if($customer->photo)
                                    <img src="{{ asset('storage/'.$customer->photo) }}" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">
                                    @else
                                    <i class="fas fa-user" style="font-size: 24px; color: gray;"></i>
                                    @endif
                                </td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone_no }}</td>
                                <td>{{ $customer->country }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td>
                                    <i class="fas fa-user" style="font-size: 24px; color: gray;"></i>
                                </td>
                                <td colspan="4" class="text-center">No customers found</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Country</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
