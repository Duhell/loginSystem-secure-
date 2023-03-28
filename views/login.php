<?php
    require "../control/functions.php";

    if(isset($_POST['submit'])){
        $response = loginUser($_POST['username'],$_POST['password']);
        
    }
    $title = "Login";
    include "./tags/head.php";
?>
    <main>
        <form action="" method="post" autocomplete="off">
            <p id ="regTitle">Sign in</p>
            <p id="error"><?= @$response ?></p>
            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?= @$_POST['username']; ?>" placeholder="Username">
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" value="<?= @$_POST['password']; ?>" placeholder="Password">
            </div>

            <button type="submit" name="submit">Login</button>

            <p id="A_login">Don't have an account? <a href="index.php">Create Here</a></p>
            <a id="forgot_password" href="#">Forgot Password?</a>

            
        </form>
    </main>
<?php include "./tags/footer.php"; ?>