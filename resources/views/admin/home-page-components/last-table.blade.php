<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Recent Subscribers</h5>
                <div class="table-responsive">
                    <table class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSubscribers as $subscriber)
                            <tr>
                                <td>{{ $subscriber->name }}</td>
                                <td>{{ $subscriber->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Low Product Stocks</h5>
                <div class="table-responsive">
                    <table class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>#SKU</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                            <tr>
                                <td>{{ $product->sku }}</td>
                                <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50"></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->stock }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#SKU</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Stock</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="col-md-4">
        <div class="card">
            <div class="card-body pb-0">
                <h5 class="card-title">Recent  &amp; User <span>| Activities</span></h5>
  
                <div class="news">
                  <div class="post-item clearfix">
                    
                    <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                    <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
                  </div>
  
                  <div class="post-item clearfix">
                    
                    <h4><a href="#">Quidem autem et impedit</a></h4>
                    <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
                  </div>
  
                  <div class="post-item clearfix">
                    
                    <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                    <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
                  </div>
  
                  <div class="post-item clearfix">
                    
                    <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                    <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
                  </div>
  
                  <div class="post-item clearfix">
                    
                    <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                    <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
                  </div>
  
                </div><!-- End sidebar recent posts-->
  
              </div>
        </div>
    </div>
</div>
