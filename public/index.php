<?php
require_once "/Users/holgermueller/Coding_projects/read-it/seed/config.php";
require_once "/Users/holgermueller/Coding_projects/read-it/seed/common.php";
include "../includes/register.inc.php";

?>

<?php include "templates/header.php"; ?>

    <main class="registration-form-background">
        <div class="wrapper">
        <section>
        <h2 class="join-in">Join!</h2>
        <p> Please fill out all the fields below.</p>

        <div class="errors">
        <?php  echo $_SESSION[$errors];?>
        </div>
        <br>
            <form action="../includes/register.inc.php" method="POST" class="registration">
            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <input type="text" name="firstname" id="firstName" placeholder="First name" class="form-control" />
            <input type="text" name="lastname" id="lastName" placeholder="Surname" class="form-control" />
            <input type="text" name="username" id="userName" placeholder="Username" class="form-control" />
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" />
            <input type="password" name="userpassword" id="userPassword" placeholder="Password" class="form-control" />
            <input type="password" name="confirmpassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" />
            <input type="text" name="check" value="" style="display:none;" />
            <input type="submit" name="join" value="Join!" class="join form-control" />
            <br>
            </form>
        </section>
        </div>
    </main>

<?php include "templates/footer.php"; ?>
