<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            padding: 20px;
        }
        .left-column, .right-column {
            flex: 1;
            padding: 10px;
        }
        .product-image {
            width: 100%;
        }
        .product-thumbnails img {
            width: 50px;
            margin: 5px;
        }
        .product-title {
            font-size: 24px;
            font-weight: bold;
        }
        .product-price {
            color: red;
            font-size: 24px;
        }
        .product-discount {
            text-decoration: line-through;
            color: grey;
        }
        .product-rating {
            color: orange;
        }
        .product-details {
            margin-top: 20px;
        }
        .product-color-options img {
            width: 40px;
            margin: 5px;
        }
        .product-size-options {
            margin-top: 10px;
        }
        .product-quantity {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
        }
        .product-actions {
            margin-top: 20px;
        }
        .btn {
            background-color: orange;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: darkorange;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Left Column -->
    <div class="left-column">
        <img src="uploadimage/sample-watch.jpg" class="product-image" alt="Product Image">
        <div class="product-thumbnails">
            <img src="uploadimage/sample-watch.jpg" alt="Thumbnail 1">
            <img src="uploadimage/sample-watch.jpg" alt="Thumbnail 2">
            <img src="uploadimage/sample-watch.jpg" alt="Thumbnail 3">
        </div>
    </div>
    
    <!-- Right Column -->
    <div class="right-column">
        <div class="product-title">Couple Stainless Watches Runway Mercer Stainless Steel Couple Watch (Silver)</div>
        <div class="product-rating">
            <i class="fas fa-star"></i> 4.5 
            <span>10K+ Ratings</span> | 
            <span>10K+ Sold</span>
        </div>
        <div class="product-price">
            ₱68 <span class="product-discount">₱699</span> <span>90% OFF</span>
        </div>
        <div>Lowest Price Guaranteed</div>
        <div>Free & Easy Returns</div>
        <div>Shipping Discount for orders over ₱249</div>
        <div>Shipping To: Ilagan, Isabela</div>
        <div>Shipping Fee: ₱0 - ₱58</div>

        <div class="product-details">
            <div>Color</div>
            <div class="product-color-options">
                <img src="uploadimage/sample-watch.jpg" alt="Silver Black">
                <img src="uploadimage/sample-watch.jpg" alt="Silver White">
                <img src="uploadimage/sample-watch.jpg" alt="Gold Black">
                <img src="uploadimage/sample-watch.jpg" alt="Gold White">
            </div>
        </div>

        <div class="product-size-options">
            <div>Size</div>
            <select>
                <option>Big (Men's) 1pcs</option>
                <option>Small (Lady's) 1pcs</option>
            </select>
        </div>

        <div class="product-quantity">
            <div>Quantity</div>
            <button>-</button>
            <input type="number" class="quantity-input" value="1">
            <button>+</button>
            <div>16727 pieces available</div>
        </div>

        <div class="product-actions">
            <button class="btn">Add To Cart</button>
            <button class="btn">Buy Now</button>
        </div>
    </div>
</div>

</body>
</html>
