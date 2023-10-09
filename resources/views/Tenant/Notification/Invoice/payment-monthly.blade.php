@extends('Tenant.stand-alone-index')

@section('content')
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <div class="row flex-center min-vh-100 py-6 text-center">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5">
                    <a class="d-flex flex-center mb-4" href="../../index.html">
                        <img class="me-2" src="/assets/img/icons/spot-illustrations/proapps.png" alt=""
                            width="200" />
                    </a>
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">
                            <span>Pay Before</span>
                            <h3 class="" id="countdown"></h3>
                            <span>Virtual Number</span>
                            <p class="lead text-800 font-sans-serif fw-semi-bold w-md-75 w-xl-100 mx-auto">
                                {{ $transaction->bank }} : {{ $transaction->va_number }}</p>
                            <hr />
                            <p>Make sure the address is correct and that the page hasn't moved. If you think this is a
                                mistake, <a href="mailto:info@exmaple.com">contact us</a>.</p>
                            <button onclick="checkPaymentStatus('{{ $transaction->transaction_id }}')"
                                class="btn btn-primary btn-sm mt-3" href="">
                                <span class="fas fa-home me-2"></span>Check payment status</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        var expiry = '{{ $transaction->expiry_time }}'

        // Set the date we're counting down to
        var countDownDate = new Date(expiry).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("countdown").innerHTML = hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);

        function checkPaymentStatus(transaction_id) {
            console.log(transaction_id);
            $.ajax({
                url: `https://api.sandbox.midtrans.com/v2/${transaction_id}/status`,
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Basic U0ItTWlkLXNlcnZlci1VQkJEOVpMcUdRRFBPd2VpekdkSGFnTFo6',
                    'Content-Type': 'application/json'
                },
                type: 'GET',
                dataType: "jsonp",
                success: function(resp) {
                    console.log(resp);
                }
            })
        }
    </script>
@endsection
