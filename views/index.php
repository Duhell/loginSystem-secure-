<?php
    require "../control/functions.php";

    if(isset($_POST['submit'])){
        $response = register($_POST['email'],$_POST['username'],$_POST['password'],$_POST['confirm_password']);
    }
    $title = "Register New User";
    include "./tags/head.php";
?>
    <main>
        <form action="" method="post" autocomplete="off">
            <p id ="regTitle">Sign up</p>
            <?php
                if(@$response == "Success"){
                    ?>
                    <p id="success">Registration Success</p>
                <?php
                }else{
                    ?>
                    <p id="error"><?= @$response ?></p>
                <?php
                }
            ?>
            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?= @$_POST['username']; ?>" placeholder="Username">
            </div>

            <div>
                <label>Email</label>
                <input type="text" name="email" value="<?= @$_POST['email']; ?>" placeholder="example@gmail.com">
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" value="<?= @$_POST['password']; ?>" placeholder="Password">
            </div>

            <div>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" value="<?= @$_POST['confirm_password']; ?>" placeholder="Confirm">
            </div>

            <button type="submit" name="submit">Register</button>

            <p id="A_login">Already have an account? <a href="login.php">Login</a></p>

            
        </form>
    </main>
<?php include "./tags/footer.php"; ?>