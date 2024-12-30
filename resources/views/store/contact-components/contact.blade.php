<!-- Contact Start -->
<div class="contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="form">
                    <form class="comments-form contact-form" action="{{ route('contacts.store') }}" method="POST">
                        @csrf <!-- Laravel CSRF protection -->

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Your Name"
                                    required />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Your Email"
                                    required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="company" placeholder="Company(Optional)"
                                     />
                            </div>

                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="subject" placeholder="Subject"
                                    required />
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                        </div>

                        <div>
                            <button type="submit" class="aa-secondary-btn">Send Message</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-md-5">
                <div class="contact-info">
                    <div class="section-header">
                        <h3>Get in Touch</h3>

                    </div>

                    <h4><i class="fa fa-envelope"></i>Thesadahabaya@gmail.com</h4>
                    <h4><i class="fa fa-phone"></i>+971 56 282 2338</h4>
                    <div class="social">
                        <a href=""><i class="fa fa-twitter"></i></a>
                        <a href=""><i class="fa fa-facebook"></i></a>
                        <a href="https://wa.me/971562822338" target="_blank">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                        <a href="https://www.instagram.com/thesadahabaya" target="_blank"><i
                                class="fa fa-instagram"></i></a>
                        <a href=""><i class="fa fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
