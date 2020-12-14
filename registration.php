<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registration</title>
        <link rel="icon" href="attachments/message-icon.png" type="image/gif" sizes="16x16">
        <!-- BOOSTRAP LINK -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

        <!-- Additional stylessheets -->
        <link rel="stylesheet" href="css/Registration_Styles.css">
    </head>

    <body>
        <div class="container-fluid">
            <div class="logginDiv text-center">
                        <span class="rounded">
                            <form class="form-signin" method="post" action="php/registrationHelper.php" autocomplete="off">
                                <h1 class="h1 mb-2">Register Here</h1>

                                <label for="uname" class="m-0">Name</label>
                                <input type="text" name="uname" id="uname" class="form-control mb-1" autocomplete="off" required autofocus>

                                <label for="email" class="m-0">Email</label>
                                <input type="email" name="email" id="email" class="form-control mb-1" autocomplete="off" required>

                                <label for="password" class="m-0">Password</label>
                                <input type="password" name="password" id="password" class="form-control mb-1" autocomplete="off" required>

                                <label for="confPassword" class="m-0">Confirm Password</label>
                                <input type="password" name="confPassword" id="confPassword" class="form-control mb-2" autocomplete="off" required>

                                <button id="join" class="btn btn-lg btn-primary btn-block" type="submit" name="join">Register</button>
                                <a href="index.php">Already a user? Click here.</a>
                            </form>
                        </span>
            </div>
        </div>
    </body>
</html>