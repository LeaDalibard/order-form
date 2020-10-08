<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>

    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>

    <span><?php echo $alert_empty;?></span>
    <form method="post" action="index.php">
        <span class="error text-success"><?php echo $validationMessage;?></span>
        <p><span class="error text-danger">* required field</span></p>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <span class="error text-danger"">* <?php echo $emailErr;?></span>
                <span class="error text-danger""> <?php echo $emailForm;?></span>
                <input type="text" id="email" name="email" value="<?php echo $cookie_mail; ?>" class="form-control"/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <span class="error text-danger"">* <?php echo $streetErr;?></span>
                    <input type="text" name="street" id="street" value="<?php echo $cookie_street ; ?>" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber ">Street number:</label>
                    <span class="error text-danger"">* <?php echo $streetnumberErr;?></span>
                    <span class="error text-danger""> <?php echo $streetnumberForm;?></span>
                    <input type="text" id="streetnumber" name="streetnumber" value="<?php echo $cookie_number; ?>" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <span class="error text-danger"">* <?php echo $cityErr;?></span>
                    <input type="text" id="city" name="city" value="<?php echo $cookie_city; ?>" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <span class="error text-danger"">* <?php echo $zipcodeErr;?></span>
                    <span class="error text-danger""> <?php echo $zipcodeForm;?></span>
                    <input type="text" id="zipcode" name="zipcode" value="<?php echo $cookie_zipcode; ?>" class="form-control">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>

            <?php foreach ($products as $value): ?>
                <label>
                    <input type="checkbox" value="<?php echo $value->get_price() ?>" name="<?php $value->get_name();?>"/> <?php  echo $value->get_name(); ?> -
                    &euro; <?php echo $value->get_price(); ?>
                </label><br />
            <?php endforeach; ?>
        </fieldset>
        <div>
            <button type="submit" name="select" class="btn btn-primary">Select</button>
        </div>

        <label>
            <input type="checkbox" name="express_delivery" value="5" /> 
            Express delivery (+ 5 EUR) 
        </label>

        <button type="submit" name="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
