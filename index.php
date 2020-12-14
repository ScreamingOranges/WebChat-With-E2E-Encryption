<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" cont`ent="ie=edge">
        <title>Login Page</title>
        <link rel="icon" href="attachments/message-icon.png" type="image/gif" sizes="16x16">
        <!-- BOOSTRAP LINK -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

        <script src="lib/jsencrypt.js"></script>
        <script type="text/javascript">

            if (typeof(Storage) !== "undefined") {
                if ((localStorage.getItem("privateKey") === null) || (localStorage.getItem("publicKey") === null)) {
                    var crypt = new JSEncrypt({default_key_size: 1024});
                    localStorage.setItem("privateKey", crypt.getPrivateKey());
                    localStorage.setItem("publicKey", crypt.getPublicKey());
                    console.log("No key pair in localStorage. Saving new key pair");
                }
                else{
                    console.log("Loading key pair from localStorage.");
                }
            }
            else{
                console.log("Sorry, your browser does not support Web Storage...");
            }
            sessionStorage.setItem("privateKey", localStorage.getItem("privateKey"));
            sessionStorage.setItem("publicKey", localStorage.getItem("publicKey"));

            var privateKey = sessionStorage.getItem("privateKey");
            var publicKey = sessionStorage.getItem("publicKey");

            console.log(privateKey);
            console.log(publicKey);
        </script>

        <!-- Additional stylessheets -->
        <link rel="stylesheet" href="css/LOGIN_Styles.css">

    </head>

    <body>
        <div class="container-fluid">
            <div class="logginDiv text-center">
                        <span class="rounded">
                            <form class="form-signin" method="post" action="php/loginHelper.php" autocomplete="off">
                                <img class="m-1" src="attachments/message-icon.png" width="100px" alt="message-icon">
                                <h1 class="h3 mb-3">Please Sign In</h1>

                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control mb-1" placeholder="Email Address" required autofocus>

                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="password" class="form-control mb-1" placeholder="Password" required>

                                <input type="hidden" name="publicKey" value="" id="publicKey"/>

                                <div class="checkbox mt-2">
                                    <label>
                                        <input type="checkbox" name="remember" value="lsRememberMe" id="rememberMe"> Remember Me?
                                    </label>
                                </div>

                                <button id="join" class="btn btn-lg btn-primary btn-block" type="submit" name="join" onclick="lsRememberMe()">Join</button>
                                <a class="btn btn-lg btn-primary btn-block" href="registration.php" role="button">Register Here</a>
                            </form>
                        </span>
            </div>
        </div>

    <script>
        document.getElementById("publicKey").value = publicKey;
        //******************************************************************************
        //for remember me
        const rmCheck = document.getElementById("rememberMe"),
            emailInput = document.getElementById("email"),
            passwordInput = document.getElementById("password");

        if (localStorage.checkbox && localStorage.checkbox !== "") {
            rmCheck.setAttribute("checked", "checked");
            emailInput.value = localStorage.username;
            passwordInput.value = localStorage.passwrd;
        } else {
            rmCheck.removeAttribute("checked");
            emailInput.value = "";
            passwordInput.value = "";
        }

        function lsRememberMe() {
            if (rmCheck.checked && emailInput.value !== "" && passwordInput.value !== "") {
                localStorage.username = emailInput.value;
                localStorage.passwrd = passwordInput.value;
                localStorage.checkbox = rmCheck.value;
            } else {
                localStorage.username = "";
                localStorage.passwrd = "";
                localStorage.checkbox = "";
            }
        }
        //******************************************************************************
        //Form input control for warnings
        var createAllErrors = function() {
            var form = $( this ), errorList = $( "ul.errorMessages", form );
            var showAllErrorMessages = function() {
                errorList.empty();
                // Find all invalid fields within the form.
                var invalidFields = form.find( ":invalid" ).each( function( index, node ) {
                    // Find the field's corresponding label
                    var label = $( "label[for=" + node.id + "] "),
                        // Opera incorrectly does not fill the validationMessage property.
                        message = node.validationMessage || 'Invalid value.';
                    errorList.show().append( "<li><span>" + label.html() + "</span> " + message + "</li>" );
                });
            };

            // Support Safari
            form.on( "submit", function( event ) {
                if ( this.checkValidity && !this.checkValidity() ) {
                    $( this ).find( ":invalid" ).first().focus();
                    event.preventDefault();
                }
            });

            $( "input[type=submit], button:not([type=button])", form )
                .on( "click", showAllErrorMessages);

            $( "input", form ).on( "keypress", function( event ) {
                var type = $( this ).attr( "type" );
                if ( /date|email|month|number|search|tel|text|time|url|week/.test ( type )
                    && event.keyCode == 13 ) {
                    showAllErrorMessages();
                }
            });
        };

        $( "form" ).each( createAllErrors );
    </script>

    </body>
</html>