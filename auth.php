<?php

if (isset($_COOKIE['is_login'])) {
    header('location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/auth.css">
</head>

<body>
    <div class="form-structor">
        <div class="signup">
            <h2 class="form-title" id="signup"><span>or</span>Sign up</h2>
            <form action="logic/register.php" method="POST">
                <div class="form-holder">
                    <input type="text" name="name" class="input" placeholder="Name" />
                    <input type="email" name="email" class="input" placeholder="Email" />
                    <input type="password" name="password" class="input" placeholder="Password" />
                </div>
                <button class="submit-btn" type="submit">Sign up</button>
            </form>
        </div>
        <div class="login slide-up">
            <div class="center">
                <h2 class="form-title" id="login"><span>or</span>Log in</h2>
                <form action="logic/login.php" method="POST">
                    <div class="form-holder">
                        <input type="email" name="email" class="input" placeholder="Email" />
                        <input type="password" name="password" class="input" placeholder="Password" />
                    </div>
                    <button class="submit-btn" type="submit">Log in</button>
                </form>

            </div>
        </div>
    </div>
    <script>
        console.clear();

        const loginBtn = document.getElementById('login');
        const signupBtn = document.getElementById('signup');

        loginBtn.addEventListener('click', (e) => {
            let parent = e.target.parentNode.parentNode;
            Array.from(e.target.parentNode.parentNode.classList).find((element) => {
                if (element !== "slide-up") {
                    parent.classList.add('slide-up')
                } else {
                    signupBtn.parentNode.classList.add('slide-up')
                    parent.classList.remove('slide-up')
                }
            });
        });

        signupBtn.addEventListener('click', (e) => {
            let parent = e.target.parentNode;
            Array.from(e.target.parentNode.classList).find((element) => {
                if (element !== "slide-up") {
                    parent.classList.add('slide-up')
                } else {
                    loginBtn.parentNode.parentNode.classList.add('slide-up')
                    parent.classList.remove('slide-up')
                }
            });
        });
    </script>
</body>

</html>