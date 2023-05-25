@extends('layouts.main')

@section('content')

      <!-- Block Content -->
        <section id="block">
            <div class="container">

                <!-- First section -->
                <div class="row">
                    <div class="col-sm-8">
                        <div class="feature">
                            <div class="shack_burger">
                                <div class="chicken">
                                    <img src="{{asset('images/chicken.png')}}" alt="Chicken" />
                                </div>

                                <h2>Shack Burger </h2>
                                <p>Black Angus beef patty topped with American cheese, tomato, lettuce, and “Shack Sauce,” served in a grilled potato bun</p>
                            </div>
                            <p class="caption">*Limited Time Only</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="signature">
                            <div class="shape">
                                <span class="flaticon flaticon-burger"></span>
                                <p>signature</p>
                            </div>
                            <div class="signature_content">
                                <p>It used to be a Secret but not any more! Our tribute to the King is a Cheddar Beef Patty,</p>
                            </div>
                        </div>
                    </div>
                </div><!-- first section end -->

        
                <!-- Third section -->
              
        </section><!-- Block Content end-->

        <!-- Lock -->
        <section id="lock">
            <h2>SERVING MORE THAN JUST BURGERS SINCE 1998</h2>
            <p>Check out our opening hours and location address below.</p>
        </section>
@endsection