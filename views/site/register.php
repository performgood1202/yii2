<?php 
 use yii\widgets\ActiveForm;
?>

    <?php
        $session = Yii::$app->session;
        $dataReturn = $session->getFlash('dataReturn');
        $errors = $session->getFlash('errorMessages');
        $errorM = $session->getFlash('errorMessage');
        $success = $session->getFlash('successMessage');
        if(isset($errors) && (count($errors) > 0))
        {
            foreach($session->getFlash('errorMessages') as $error)
            {
                echo "<div class='alert alert-danger' role='alert'>$error[0]</div>";
            }
        }

        if(isset($success))
        {
            echo "<div class='alert alert-success' role='alert'>$success</div>";
        }
        if(isset($errorM))
        {
            echo "<div class='alert alert-danger' role='alert'>$errorM</div>";
        }
    ?>

    <h1>Register</h1>

    <?php
    ActiveForm::begin([
        "action" => ["site/sign-up"],
        "method" => "post"
    ]);
    ?>
 <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" placeholder="Name" class="form-control" <?php if(isset($dataReturn["name"])){?> value="<?php echo $dataReturn["name"];?>" <?php } ?> required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" placeholder="Email" class="form-control" <?php if(isset($dataReturn["email"])){?> value="<?php echo $dataReturn["email"];?>" <?php } ?> required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" placeholder="Password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>

    <?php
    ActiveForm::end();
    ?>