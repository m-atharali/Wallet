@extends('layouts.app')

@section('content')
<style>
    .ul {
        list-style: none;
    }
    .label {
        border: .2px solid green;
        display: inline-block;
        padding: 2px;
        border-radius: 2px;
    }
    table {
        width: 94%;
        border-bottom: .2px solid black;
    }
    th {
        border: .2px solid black;
        text-align: center;
    }
    td {
        border: .2px solid black;
        border-top: none;
        border-bottom: none;
        padding: 5px;
    }
    button {
        background-color: green;
        padding: 3px;
        border-radius: 2px;
        border: .2px solid green;
        color: #fff;
    }
    button:hover {
        background-color: #fff;
        color: green;
        /* border: .2px solid green; */
    }
    #paymentForm{
        display: none;
    }
    #deposit{

    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div> -->
        </div>
    </div>
    <div>
    <ul class="ul">
        <li>
            <p class="label">wallet ID</p>
            {{ Auth::user()->wallet_id }}
        </li>
        <li>
            <p class="label">currency </p>
            {{$currency}}
        </li>
        <li>
            <p class="label">wallet Balance</p> 
            {{$amount}} <br />
            <!-- deposit form -->
            <form id="paymentForm" method="GET" action="">
                        @csrf


                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <div class="form-control" id="email-address" >{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="currency" class="col-md-4 col-form-label text-md-right">{{ __('Currency') }}</label>
                            <div class="col-md-6">
                                <div class="form-control" id="currency" >{{ $currency }}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>
                            <div class="col-md-6">
                                <input id="amount" type="number" class="form-control" name="amount" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" onclick="payWithPaystack()" class="btn btn-primary">
                                    {{ __('Pay') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <script src="https://js.paystack.co/v1/inline.js"></script>
                    <a id='deposit'>
                        <button>Deposit</button>
                    </a>
                    <script>
                        //show
                        const paymentForm = document.getElementById('paymentForm');
                        const deposit = document.querySelector("#deposit");
                            // let amount1 = document.getElementById("amount").value;
                            
                            deposit.addEventListener("click", function (){
                                paymentForm.style.display = 'block';
                                // alert('work');
                            });
                    </script>
                    <script>
                            
                            // alert();
                            // const paymentForm = document.getElementById('paymentForm');
                            const email = document.getElementById("email-address").innerHTML;
                            // let amount1 = document.getElementById("amount").value;
                            
                            paymentForm.addEventListener("submit", payWithPaystack, false);
                            function payWithPaystack(e) {
                                e.preventDefault();
                                let handler = PaystackPop.setup({
                                    key: 'pk_test_0730836c8e5a87d5d7ba62a1035eabd3abec3491', // Replace with your public key
                                    email: email,
                                    amount: document.getElementById("amount").value * 100,
                                    currency: document.getElementById("currency").innerHTML,
                                    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                                    // label: "Optional string that replaces customer email"
                                    onClose: function(){
                                        alert('Window closed.');
                                    },
                                    callback: function(response){
                                        const ref = response.reference;
                                        const amount = document.getElementById("amount").value;
                                        window.location.href='/deposit/'+ amount;
                                        // let message = 'Payment complete! Reference: ' + response.reference;
                                        // alert(message);
                            
                                    }
                                });
                                handler.openIframe();
                            }

                            
                            // const paymentForm = document.getElementById('paymentForm');  
                        
                    </script>

            
        </li>
    </ul>
    <div class="trans">
        <h3>Transaction history</h3>
        <!-- {{$transaction}} -->
        <table>
            <thead>
                <th>Transaction ID</th>
                <th>Transaction Type</th>
                <th>Description</th>
                <th>Amount ({{$currency}})</th>
                <th>Balance ({{$currency}})</th>
                <th>Date</th>
            </thead>
            <tbody>
                <?php 
                    $details = json_decode($transaction, true);
                    // print_r($details);
                ?>
                @foreach($details as $doc)
                <tr>
                    <td>{{$doc['transaction_id']}}</td>
                    <td>{{$doc['transaction_type']}}</td>
                    <td>{{$doc['description']}}</td>
                    <td><?php 
                    if ($doc['transaction_type'] == 'debit')
                    {echo '-'; }else {echo '+';} ?>{{$doc['amount']}}</td>
                    <td>{{$doc['balance']}}</td>
                    <td>{{$doc['created_at']}}</td> 
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    
    
        <!-- {{ Auth::user()->balance }} -->
    </div>
</div>
@endsection
