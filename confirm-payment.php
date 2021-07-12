<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MPESA Payment Confirmation</title>
    <link rel="icon" href="assets/favicon.png" sizes="16x16" type="image/png">
    <link rel="stylesheet" href="assets/payment.css" />
</head>

<body>
    <div class="card-container">
        <div class="top">
            <a href="index.php"><img src="assets/mpesa-logo.png" width="100%" alt=""></a>
        </div>
        <div class="middle">
            <h3>Payment Details</h3>
            <div class="extra-detail">
                <div class="detail">
                    <p id="dark">Total Amount</p>
                </div>
                <div class="detail-price">
                    <p id="dark">KES 1</p>
                </div>
            </div>
            <div class="border"></div>
        </div>

        <div class="form-box">
            <div class="card-box">
                <div class="main-content">
                    <div class="pay-instruction">
                        <h3>Payment Instruction</h3>
                    </div>
                    <div class="pay-instruction">
                        <p>
                            3. Enter your <b>M-PESA PIN</b> and the amount specified on the

                            notification will be deducted from your M-PESA account when you press send.<br />

                            4. You will receive an M-PESA payment confirmation message on your mobile phone.<br />

                            5. After receiving the M-PESA payment confirmation message please click on the <b>Complete Order</b> button below to complete the order and confirm the payment made.<br /></p>
                    </div>
                </div>
                <div class="name-area">
                    <form class="login" action="" method="POST" enctype="multipart/form-data" id='payment_form'>
                        <input type="hidden" name="phone" class="input-no">
                        <div class="payment-buttons">
                            <div class="btn-sent">Payment request sent</div>
                            <button type="submit" id="complete_btn" class="pay-btn">Complete Order</button>
                        </div>
                    </form>

                </div>

            </div>

            <div class="powered">App powered by <a href="https://mfc.ke" target="_blank">Mediaforce</a></div>
        </div>
    </div>
    <!--<script src='functions.js'></script>-->
    <script src='payment.js'></script>
</body>

</html>