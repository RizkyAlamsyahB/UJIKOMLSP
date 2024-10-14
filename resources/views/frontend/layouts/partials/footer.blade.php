<!-- Content Section -->
<section id="about-us">
    <!-- Bagian konten halaman Anda -->

    <!-- Footer Section -->
    <footer class="footer footer-custom-bg text-light py-5">
        <div class="container">
            <!-- Top Row with Four Columns -->
            <div class="row">
                <!-- Logo Column -->
                <div class="col-md-3 ">
                    <img src="{{ asset('template/dist/assets/compiled/png/logo_baru_gray.png') }}" alt="Logo"
                        alt="Tentz Logo" class="img-fluid mb-3 w-50">
                    <p><strong>Discover the perfect camping shelter today in our shop!</strong></p>
                </div>

                <!-- Shop Column -->
                <div class="col-md-3">
                    <h5><strong>SHOP</strong></h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-E6E3DB">Glamping Tents</a></li>
                        <li><a href="#" class="text-E6E3DB">Bell Tents</a></li>
                        <li><a href="#" class="text-E6E3DB">Festival Tents</a></li>
                        <li><a href="#" class="text-E6E3DB">Yurt Tents</a></li>
                    </ul>
                </div>

                <!-- Company Column -->
                <div class="col-md-3">
                    <h5><strong>COMPANY</strong></h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-E6E3DB">Customer Review</a></li>
                        <li><a href="#" class="text-E6E3DB">Life In Tent</a></li>
                        <li><a href="#" class="text-E6E3DB">About Us</a></li>
                        <li><a href="#" class="text-E6E3DB">Influencer</a></li>
                    </ul>
                </div>

                <!-- Contact Us Column -->
                <div class="col-md-3">
                    <h5><strong>CONTACT US</strong></h5>
                    <p>Email: <a href="mailto:contact@tentz.com" class="text-light">contact@tentz.com</a></p>
                    <p>Call Or Text: +1 971-112-4582</p>
                    <p>M-F 9 AM-4 PM PST</p>
                </div>
            </div>

            <!-- Bottom Row with "LAM GEAR" Text -->
            <div class="footer row mt-5">
                <div class="col text-center">
                    <h1 class="text-footer"><span>LAM GEAR</span></h1>
                </div>
            </div>

        </div>
    </footer>
</section>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Optional: Add custom styles here -->
<style>
    .footer h1 {
        font-family: 'Anton';
        font-size: 10vw;
        margin: 0;
        letter-spacing: 30px;
        text-transform: uppercase;
        color: #333;
        position: relative;

    }


    .footer {
        position: relative;
    }

    .footer h1 {
        position: relative;
        /* This makes sure that the pseudo-elements are positioned relative to the heading */
        display: inline-block;
        /* Ensures the lines are aligned properly with the text */
        padding: 0 40px;
        /* Adds padding to the sides of the text to make space for the lines */
    }

    .footer h1::before,
    .footer h1::after {
        content: '';
        position: absolute;
        height: 1px;
        background-color: #444;
        width: 100%;
        /* Make the width 100% to stretch across the parent */
    }

    .footer h1::before {
        top: -20px;
        /* Line above the text */
        left: 0;
    }

    .footer h1::after {
        bottom: -20px;
        /* Line below the text */
        left: 0;
    }

    .footer h1 span::before,
    .footer h1 span::after {
        content: '';
        position: absolute;
        width: 1px;
        background-color: #444;
        height: 100%;
    }

    .footer h1 span::before {
        left: -40px;
        /* Line to the left of the text */
        top: 0;
    }

    .footer h1 span::after {
        right: -40px;
        /* Line to the right of the text */
        top: 0;
    }



    .footer h5 {
        margin-bottom: 1rem;
        color: #E6E3DB;
    }

    .footer p,
    .footer ul,
    .footer a {
        color: #bbb;
    }

    .footer a:hover {
        color: #fff;
        text-decoration: none;
    }

    .footer-custom-bg {
        background-color: #FFFFFF !important;
    }
</style>
