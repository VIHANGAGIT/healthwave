// function paymentGateway(){

//             /*// Payment completed. It can be a successful failure.
//             payhere.onCompleted = function onCompleted(orderId) {
//                 console.log("Payment completed. OrderID:" + orderId);
//                 // Note: validate the payment and show success or failure page to the customer
//             };

//             // Payment window closed
//             payhere.onDismissed = function onDismissed() {
//                 // Note: Prompt user to pay again or show an error page
//                 console.log("Payment dismissed");
//             };

//             // Error occurred
//             payhere.onError = function onError(error) {
//                 // Note: show an error page
//                 console.log("Error:"  + error);
//             };

//             // Put the payment variables here
//             var payment = {
//                 "sandbox": true,
//                 "merchant_id": "121XXXX",    // Replace your Merchant ID
//                 "return_url": undefined,     // Important
//                 "cancel_url": undefined,     // Important
//                 "notify_url": "http://sample.com/notify",
//                 "order_id": "ItemNo12345",
//                 "items": "Door bell wireles",
//                 "amount": "1000.00",
//                 "currency": "LKR",
//                 "hash": "45D3CBA93E9F2189BD630ADFE19AA6DC", // *Replace with generated hash retrieved from backend
//                 "first_name": "Saman",
//                 "last_name": "Perera",
//                 "email": "samanp@gmail.com",
//                 "phone": "0771234567",
//                 "address": "No.1, Galle Road",
//                 "city": "Colombo",
//                 "country": "Sri Lanka",
//                 "delivery_address": "No. 46, Galle road, Kalutara South",
//                 "delivery_city": "Kalutara",
//                 "delivery_country": "Sri Lanka",
//                 "custom_1": "",
//                 "custom_2": ""
//             };

//             payhere.startPayment(payment);*/

// }

$(document).ready(function () {

  $("#pay").click(function (event) {
    event.preventDefault();
    var totalPrice = document.getElementById('price-value-total').textContent;
    totalPrice = parseFloat(totalPrice.replace(/[^0-9.]/g, '')).toFixed(2);

    $.ajax({
      url: "http://localhost/healthwave/patient/make_payment/",
      type: "POST",
      data: {
        amount: totalPrice,
      },
      success: function (data) {

        //Payment completed. It can be a successful failure.
        payhere.onCompleted = function onCompleted(orderId) {
            console.log("Payment completed. OrderID:" + orderId);
            // Note: validate the payment and show success or failure page to the customer
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
            // Note: Prompt user to pay again or show an error page
            console.log("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
            // Note: show an error page
            console.log("Error:"  + error);
        };

        
        data = JSON.parse(data);
        console.log(data);

        var payment = {
          sandbox: true,
          merchant_id: data["merchant_id"], // Replace your Merchant ID
          return_url: data["return_url"], // Page to redirect after success payment
          cancel_url: data["cancel_url"], // Page to redirect after cancel payment
          notify_url:data["sample_url"], // Page to redirect after sucess and if you want to send email or notification
          order_id: data["order_id"],
          items: data["items"],
          amount: data["amount"],
          currency: data["currency"],
          hash: data["hash"], // *Replace with generated hash retrieved from backend
          first_name: data["first_name"],
          last_name: data["last_name"],
          email: data["email"],
          phone: data["phone"],
          address: data["address"],
          city: data["city"],
          country: data["Country"],
          delivery_address: data["delivery_address"],
          delivery_city: data["delivery_city"],
          delivery_country: data["delivery_country"],
          custom_1: data["custom_1"],
          custom_2: data["custom_2"],
        };

        payhere.startPayment(payment);
      },
    });
  });
});
