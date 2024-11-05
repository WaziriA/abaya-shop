

<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                <ul aria-expanded="false">
                    <li><a href="./index.html">Dashboard </a></li>
                    
                </ul>
            </li>
            <li class="nav-label">Users</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-users-mm-2"></i><span class="nav-text">Users</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('user.index')}}">All Users</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Staff</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('owner.index')}}">Owner</a></li>
                            <li><a href="{{ route('showStaffs.index')}}">Workes</a></li>
                            
                            
                        </ul>
                    </li>
                    <li><a href="{{ route('customer.index')}}">Customers</a></li>
                    <li><a href="{{ route('admin-users.showTrash')}}">Disabled Users</a></li>
                    <li><a href="{{ route('subscribers.index')}}">Subscribers</a></li>
                    <li><a href="#">User Activity</a></li>
                </ul>
            </li>

            <li class="nav-label">Orders</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-chart-bar-33"></i><span class="nav-text">Orders</span></a>
                        <ul aria-expanded="false">
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Online Orders</a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('order.index')}}">All Orders</a></li>
                        <li><a href="#">Complete Orders</a></li>
                        <li><a href="#">In Transit Orders</a></li>
                        <li><a href="#">Pending Orders</a></li>
                    </ul>
                            </li>
                   <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Offline Orders</a>
                      <ul aria-expanded="false">
                        <li><a href="{{ route('offline-order.index')}}">All Orders</a></li>
                        <li><a href="{{ route('complete-order.index')}}">Complete Orders</a></li>
                        <li><a href="{{ route('transit-order.index')}}">In Transit Orders</a></li>
                        <li><a href="{{ route('pending-order.index')}}">Pending Orders</a></li>
                     </ul>
                   </li>
                   <li><a href="#">Shipping</a></li>
                   <li><a href="#">Shipping Agents</a></li>
                </ul>
                
            </li>
            <li class="nav-label">Inventory</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-world-2"></i><span class="nav-text">Products</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('category.index')}}">Add Category</a></li>
                    <li><a href="{{ route('admin-product.index')}}">View Products</a></li>
                    <li><a href="{{ route('stock.index')}}">Stock Level</a></li>
                    <li><a href="{{ route('products.deleted')}}">Deleted Products</a></li>
                    
                  

                </ul>
            </li>
            <li class="nav-label">Financial Statements</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                class="icon icon-plug"></i><span class="nav-text">Financial Matrics</span></a>
                <ul aria-expanded="false">
                    <li><a href="#">Sales</a></li>
                    <li><a href="#">Expenses</a></li>
                   <li><a href="#">Net Profit</a></li>
            
                </ul>
            </li>
            <li class="nav-label">Content management</li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-plug"></i><span class="nav-text">CMS</span></a>
                        <ul aria-expanded="false">
                        <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Home Page</a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('cms.index')}}">Carousel Items</a></li>
                                <li><a href="{{ route('carousel.trashed')}}">Carousel Trashed Items</a></li>
                                <!--<li><a href="#">In Transit Orders</a></li>
                                <li><a href="#">Pending Orders</a></li>-->
                            </ul>
                
                    
                    <li><a href="#">Shop page</a></li>
                    <li><a href="#">Product details page</a></li>
                    
                </ul>
            </li>
            <li class="nav-label">Coupons</li>
            
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-form"></i><span class="nav-text">Coupons</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('coupon.index')}}">Active Coupons</a></li>
                    <li><a href="{{ route('coupons.expired')}}">Expired Coupons</a></li>
                    <li><a href="#">Coupons Usage statics</a></li>
                    <li><a href="{{ route('coupons.trashed')}}">Disabled Coupon</a></li>
                </ul>
            </li>
            
            <li class="nav-label">Personal Details</li>
            
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="icon icon-single-04"></i><span class="nav-text">Profile</span></a>
                <ul aria-expanded="false">
                    <li><a href="#">View profile</a></li>
                    <li><a href="#">Change Password</a></li>
                    <li> 
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                           <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                Log-out
                            </a>
                        </form>
                    </li>
                    
                </ul>
            </li>

        </ul>
    </div>


</div>