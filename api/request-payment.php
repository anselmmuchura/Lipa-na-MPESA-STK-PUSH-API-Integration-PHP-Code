<?php

require('config.php');

session_start();

$base     = (isset($_SERVER["HTTPS"]) ? "https" : "http") . "://" . (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '');
$defaults = array(
    "env"              => "sandbox",
    "type"             => 5,
    "shortcode"        => "174379",
    "headoffice"       => "174379",
    "key"              => "JfgNvJpIzyILBV1ZODqnIkEszhGnqxUO",
    "secret"           => "Ge7PIo7JHIp1OXmg",
    "username"         => "apitest",
    "password"         => "",
    "passkey"          => "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919",
    "validation_url"   => $base . "/api/validate",
    "confirmation_url" => $base . "/api/confirm",
    "callback_url"     => $base . "/api/reconcile",
    "timeout_url"      => $base . "/api/timeout",
    "results_url"      => $base . "/api/results",
);

$configuration = new Config($defaults);

if (isset($_POST['submit'])) {

    $phone = $_POST['phone'];
    $amount = 1;
    $reference = "ACCOUNT";
    $description = "Transaction Description";
    $remark = "Remark";
    $callback = null;

    $phone = (substr($phone, 0, 1) == "+") ? str_replace("+", "", $phone) : $phone;
    $phone = (substr($phone, 0, 1) == "0") ? preg_replace("/^0/", "254", $phone) : $phone;
    $phone = (substr($phone, 0, 1) == "7") ? "254{$phone}" : $phone;

    $timestamp = date("YmdHis");
    $password  = base64_encode($configuration->getConfig()->shortcode . $configuration->getConfig()->passkey . $timestamp);

    $endpoint = ($configuration->getConfig()->env == "live")
        ? "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest"
        : "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

    $curl_post_data = array(
        "BusinessShortCode" => $configuration->getConfig()->headoffice,
        "Password"          => $password,
        "Timestamp"         => $timestamp,
        "TransactionType"   => ($configuration->getConfig()->type == 4) ? "CustomerPayBillOnline" : "CustomerBuyGoodsOnline",
        "Amount"            => $amount,
        "PartyA"            => $phone,
        "PartyB"            => $configuration->getConfig()->shortcode,
        "PhoneNumber"       => $phone,
        "CallBackURL"       => $configuration->getConfig()->callback_url,
        "AccountReference"  => $reference,
        "TransactionDesc"   => $description,
        "Remark"            => $remark,
    );

    $response = $configuration->remote_post($endpoint, $curl_post_data);
    $result   = json_decode($response, true);


    if ($result['ResponseCode'] && $result['ResponseCode'] == 0) {
        $_SESSION['MerchantRequestID'] = $result['MerchantRequestID'];
        $_SESSION['CheckoutRequestID'] = $result['CheckoutRequestID'];
        $_SESSION['Amount'] = $amount;

        header("location: ../confirm-payment.php");
    } elseif ($result['errorCode'] && $result['errorCode'] == '500.001.1001') {
        $errors = "Error! A transaction is already in progress for the current phone number";
        header("location: ../index.php?error=" . $errors . "");
    } elseif ($result['errorCode'] && $result['errorCode'] ==  '400.002.02') {
        $errors = "Error! Invalid Request";
        header("location: ../index.php?error=" . $errors . "");
    } else {
        $errors = "Error! Unable to make MPESA STK Push request. If the problem persists, please contact our site administrator!";
        header("location: ../index.php?error=" . $errors . "");
    }
}
