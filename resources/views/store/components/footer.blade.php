

<!-- Footer Start -->
<div class="footer mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-6">
                <div class="footer-widget">
                    <h1 style="font-family: nabi;">Sadah Abaya</h1>
                    <p style="font-family: nabi;">
                        Sadah celebrates modesty, elegance, and practicality by creating timeless, comfortable abayas.
                        Made from luxury, breathable fabrics, each piece combines beauty with comfort, designed for any
                        season or occasion. More than just clothing, Sadah’s abayas symbolize confidence, grace, and
                        love, helping you feel radiant and at ease.
                    </p>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="footer-widget">
                    <h3 class="title" style="font-family: nabi;">Useful Pages</h3>
                    <ul>
                        <li><a href="{{ route('shop.index') }}" style="font-family: nabi;">Product</a></li>

                        <li><a href="{{ route('cart.index') }}"  style="font-family: nabi;">Cart</a></li>
                        <li><a href="{{ route('login') }}" style="font-family: nabi;">Login</a></li>
                        <li><a href="{{ route('register') }}" style="font-family: nabi;">Register</a></li>

                    </ul>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="footer-widget">
                    <h3 class="title" style="font-family: nabi;">Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('shop.index') }}" style="font-family: nabi;">Product</a></li>

                        <li><a href="{{ route('cart.index') }}" style="font-family: nabi;">Cart</a></li>
                        <li><a href="{{ route('login') }}" style="font-family: nabi;">Login</a></li>
                        <li><a href="{{ route('register') }}" style="font-family: nabi;">Register</a></li>

                        <li><a href="{{ route('wish-list.index') }}" style="font-family: nabi;">Wishlist</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title" style="font-family: nabi;">Get in Touch</h3>
                    <div class="contact-info">

                        <p style="font-family: nabi;"><i class="fa fa-envelope" ></i>Thesadahabaya@gmail.com</p>
                        <p style="font-family: nabi;"><i class="fa fa-phone" ></i>+971 56 282 2338</p>
                        <div class="social">
                            <a href=""><i class="fa fa-twitter"></i></a>
                            <a href=""><i class="fa fa-facebook"></i></a>
                            <a href="https://wa.me/971562822338" target="_blank">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="https://www.instagram.com/thesadahabaya" target="_blank">
                                <i
                                    class="fa fa-instagram"></i></a>
                            <a href=""><i class="fa fa-youtube"></i></a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row payment">
            <div class="col-md-6">
                <div class="payment-method">
                    <p style="font-family: nabi;">We Accept:</p>
                    <img src="{{ asset('new/img/payment-method.png') }}" alt="Payment Method" />
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Footer Bottom Start -->
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 copyright">
                <p >Copyright &copy; <a href="#">Sadah Abaya</a>. All Rights Reserved</p>
            </div>

            <div class="col-md-6 template-by">
                {{-- <p>Template By <a href="#">HTML Codex</a></p> --}}
            </div>
        </div>
    </div>
</div>
<!-- Footer Bottom End -->
