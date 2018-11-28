<?php include "templates/header.php"; ?>

    <main class="registration-form-background">

        <h2 class="join-in">Join!</h2>
        <p> Please fill out all the fields below.</p>

    <?php
    if(!empty($error)) {
        echo '<h2>Error(s)!<?h2>' . '<br>';
        foreach($errors as $errormessage) {
            echo $errormessage . '<br>';
        }
    }
    ?>

        <form action="includes/register.inc.php" method="post" class="registration">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <input type="text" name="firstname" id="firstName" placeholder="First name" class="form-control" />
            <input type="text" name="lastname" id="lastName" placeholder="Surname" class="form-control" />
            <input type="text" name="username" id="userName" placeholder="Username" class="form-control" />
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" />
            <input type="password" name="userpassword" id="userPassword" placeholder="Password" class="form-control" />
            <input type="password" name="confirmpassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" />
            <input type="text" name="check" value="" style="display:none;" />
            <input type="submit" name="submit" value="Join!" class="join form-control" />
        </form>

    </main>

<?php include "templates/footer.php"; ?>
