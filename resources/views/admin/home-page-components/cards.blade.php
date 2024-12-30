{{-- <div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-user text-success border-success"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Staff</div>
                    <div class="stat-digit"> 1,012</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-user text-primary border-primary"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Customers</div>
                    <div class="stat-digit">961</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-user text-pink border-pink"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Subscribers</div>
                    <div class="stat-digit">770</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-shopping-cart text-danger border-danger"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Orders</div>
                    <div class="stat-digit">2,781</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="fa-dollar-sign text-success border-success"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">USD</div>
                    <div class="stat-digit">$ 1,012</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="fa-money-bill-wave text-primary border-primary"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">AED</div>
                    <div class="stat-digit">AED 961</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="fa-pound-sign text-pink border-pink"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">GBP</div>
                    <div class="stat-digit">£ 770</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="fas fa-euro-sign text-danger border-danger"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">UERO</div>
                    <div class="stat-digit">€ 2,781</div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-user text-success border-success"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Staff</div>
                    <div class="stat-digit">{{ $staffCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-user text-primary border-primary"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Customers</div>
                    <div class="stat-digit">{{ $customerCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-user text-pink border-pink"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Subscribers</div>
                    <div class="stat-digit">{{ $subscriberCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-shopping-cart text-danger border-danger"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Orders</div>
                    <div class="stat-digit">{{ $orderCount }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach($orderSums as $currency => $sum)
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="stat-widget-one card-body">
                    <div class="stat-icon d-inline-block">
                        @if($currency == 'USD')
                            <i class="fa fa-dollar-sign text-success border-success"></i>
                        @elseif($currency == 'AED')
                            <i class="fa fa-money-bill-wave text-primary border-primary"></i>
                        @elseif($currency == 'GBP')
                            <i class="fa fa-pound-sign text-pink border-pink"></i>
                        @elseif($currency == 'EURO')
                            <i class="fas fa-euro-sign text-danger border-danger"></i>
                        @else
                            <i class="fa fa-question text-secondary border-secondary"></i> <!-- Default icon for unknown currencies -->
                        @endif
                    </div>
                    <div class="stat-content d-inline-block">
                        <div class="stat-text">{{ $currency }}</div>
                        <div class="stat-digit">{{ $currency }} {{ number_format($sum, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>



