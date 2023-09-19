#
curl -X POST "http://localhost:80/calculate-price" -H 'Content-Type:application/json' -d "{\"product\": 1,\"taxNumber\": \"FRFJ123456789\",\"couponCode\": \"D15\"}"
curl -X POST "http://localhost:80/purchase" -H 'Content-Type:application/json' -d "{\"product\": 1,\"taxNumber\":\"IT12345678900\",\"couponCode\":\"D15\",\"paymentProcessor\":\"paypal\"}"
 
