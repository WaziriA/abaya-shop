<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5>Recent Sales</h5>
                <div class="table-responsive">
                    <table class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                
                                <th>Photo</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                            <tr>
                                
                                <td>
                                    @foreach ($sale->products->take(1) as $product)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; margin-right: 5px;">
                                    @endforeach
                                    @if ($sale->products->count() > 1)
                                        <i class="bi bi-three-dots" title="More products available" style="font-size: 24px; color: #007bff; cursor: pointer;"></i>
                                    @endif
                                </td>
                                <td>
                                    @foreach ($sale->products->take(1) as $product)
                                        <div>{{ $product->name }} (Qty: {{ $product->pivot->quantity }})</div>
                                    @endforeach
                                    @if ($sale->products->count() > 1)
                                        <span class="text-primary" style="cursor: pointer;" title="More products available">
                                            View more...
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $sale->product->category->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($sale->currency === 'USD')
                                        ${{ number_format($sale->amount, 2) }}
                                    @elseif ($sale->currency === 'AED')
                                        AED {{ number_format($sale->amount, 2) }}
                                    @elseif ($sale->currency === 'EURO')
                                        €{{ number_format($sale->amount, 2) }}
                                    @elseif ($sale->currency === 'GBP')
                                        £{{ number_format($sale->amount, 2) }}
                                    @else
                                        {{ number_format($sale->amount, 2) }}
                                    @endif
                                </td>
                                
                                <td>{{ $sale->user->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                
                                <th>Photo</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Customer</th>
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
                <h5>Coupon Usage</h5>


                <canvas id="coupon-pie-chart"></canvas>

            </div>

        </div>
    </div>
</div>
