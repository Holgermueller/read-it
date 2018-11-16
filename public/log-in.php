

<?php include "templates/general-header.php"; ?>

    <div class="log-in-form">

    <h2>Log in:</h2>

        <form method="post" class="log-in-form header-elem">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
            <label for="password">Password</label>
            <input type="text" name="userpassword" id="password">
            <input type="text" name="check" value="" style="display:none;" />
            <input type="submit" name="login" value="Log In" class="log-in">
        </form>

    </div>

<?php include "templates/footer.php"; ?>