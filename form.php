<?php
//view forms for user's interating

function displayForm($fail = null)
{
    if(isset($_COOKIE["username"])){
        $username = $_COOKIE["username"];
    }else{
        $username = "";
    }


    echo <<<HTML
        <!DOCTYPE html>

        <html>
        <head>
            <meta charset="UTF-8">
            <title>Login form</title>
            <link rel="stylesheet" href="style.css">
            <script src="validation.js"></script>
        </head>
        
        <body>
            <input type="radio" id="loginForm" name="formToggle" checked>
            <input type="radio" id="registerForm" name="formToggle">
            <input type="radio" id="forgotForm" name="formToggle">

            <div class='error' id='statusMsg'>$fail</div>
            
            <!------------------------ LOGIN FORM ------------------------>
            <div class="wrapper" id="loginFormContent">
                <form method="post" action="login.php" onsubmit="return validateLogin(this)">
                    <h1>Login</h1>

                    <div class="input-box">
                        <input type="text" placeholder="Username" maxlength="16" name="username" value="$username" required>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="checkbox1">
                        <label><input type="checkbox" name="remember_me">Remember Me</label>
                        <label for="forgotForm">Forgot Password</label>
                    </div>

                    <button type="submit" class="btn">Login</button>

                    <div class="link">
                        <p>Don't have an account? <label for="registerForm" onclick="showStatusMsg()">Register</label></p>
                    </div>
                </form>
            </div>

            <!------------------------ REGISTER FORM ------------------------>
            <div class="wrapper" id="registerFormContent">
            <form method="post" action="signup.php" onsubmit="return validateSignUp(this)">
                    <h1>Register</h1>

                    <div class="input-box">
                        <input type="text" placeholder="Username" maxlength="16" name="username" required>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="Email" maxlength="64" name="email" required>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="checkbox1">
                        <label><input type="checkbox" name="condition" required>I agree to terms & conditions</label>
                    </div>

                    <button type="submit" class="btn">Register</button>

                    <div class="link">
                        <p>Already have an account? <label for="loginForm" onclick="showStatusMsg()">Login</label></p>
                    </div>
                </form>
            </div>

            <!------------------------ FORGOT FORM ------------------------>
            <div class="wrapper" id="forgotFormContent">
                <form action="">
                    <h1>Reset your password</h1>
                    <div class="input-box">
                        <input type="email" placeholder="Email" required>
                    </div>
                    <div class="input-box">
                        <button type="submit" class="btn">Send Request</button>
                    <div class="link">
                        <p>Don't have an account? <label for="registerForm" onclick="showStatusMsg()">Register</label></p>
                    </div>
                </form>
            </div>

            <script>
                function showStatusMsg() {
                    // Get the statusMsg element
                    var statusMsg = document.getElementById('statusMsg');

                    // Hide the status message
                    statusMsg.style.display = 'none';
                }
            </script>
        </body>
        </html>
    HTML;
}

function displayWelcomeMessage($name)
{
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DecrypToId</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="style1.css">
        <script type="text/javascript" src="animation.js"></script>
        
        <!-- GSAP Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    </head>

    <body>
        <div class="container-logout">
            <a href="logout.php" class="button neon">Logout</a>
            <a href="history.php" class="button neon">History</a>
        </div>

        <div class="text">
            <h1>Welcome To DecryptoId</h1>
        </div>

        <h2>Hello <span style="color:00a2e5"> $name!</span></h2>
        
        <h2><span class='error' id='statusMsg'></span></h2>

        <form method='post' action='decrypttoid.php' enctype='multipart/form-data' onsubmit="return validateInputMessage(this)">	
            <h3> Select from a list of ciphers</h3>
            
            <div class="select-wrapper"> 
                <select name="ciphers[]" id="ciphers" class="select">
                    <option value="Substitution">Simple Substitution</option>
                    <option value="Transposition">Double Transposition</option>
                    <option value="Stream">RC4</option>
                    <option value="DES">DES</option>
                </select>
            </div> 

            <br/>

            <h3> Select a option</h3>
            <div class="container">
                <div class="btn-container">
                    <input type="radio" id="EncryptText" name="option" value="encrypt-text"> 
                    <label class="codedText fromRight" for="EncryptText">Encrypt</label><br/>
                    <input type="radio" id="DecryptText" name="option" value="decrypt-text"> 
                    <label class="codedText" for="DecryptText">Decrypt</label><br/>
                </div>
            </div>

            <h3> Select a kind of input</h3>
            <div class="container">
                <div class="btn-container">
                    <input type="radio" id="InputText" name="operation" value="input-text" checked="checked"> 
                    <label class="codedText fromRight" for="InputText">Input Text</label><br/>
                    <input type="radio" id="UploadFile" name="operation" value="upload-file">
                    <label class="codedText" for="UploadFile">Upload File</label><br/>
                </div>
            </div>

            <div class="text-block" id="input-text-block" style="display: block;">
                <div class="text-prompt">
                    <div>
                        <input type="text" id="text-prompt" name="input-text" />
                        <label for="text-prompt">Enter your text</label>
                    </div>
                </div>
            </div>

            <div class="text-block" id="upload-file-block">
                <div class="wrap-button">
                    <div class="upload">
                        <span id="text-upload" style="font-size: 22px; margin: 0 20%;">Select Text File:</span>
                        <input type="file" id="myFile" name="filename" onchange= "return fileValidation()">               
                    </div>
                </div>
            </div>

            <input class="buton-submit" type='submit' name='uploadBtn' value='Submit'>
        </form>

        <!-- check option for input or upload in real-time -->
        <script enctype="multipart/form-data">
            // Cache the text blocks
            var inputTextBlock = document.getElementById('input-text-block');
            var uploadFileBlock = document.getElementById('upload-file-block');
            var inputText = document.getElementById('text-prompt');
            var uploadText = document.getElementById('text-upload'); 

            document.querySelectorAll('input[type=radio][name="option"]').forEach(function(radio) {
                radio.addEventListener('click', function() {
                    toggleVisibility_option(this.value);
                });
            });

            document.querySelectorAll('input[type=radio][name="operation"]').forEach(function(radio) {
                radio.addEventListener('click', function() {
                    toggleVisibility(this.value);
                });
            });

            // select between input or upload
            function toggleVisibility(selectedOption) {
                if (selectedOption === 'input-text') {
                    inputTextBlock.style.display = 'block';
                    uploadFileBlock.style.display = 'none';
                } else if (selectedOption === 'upload-file') {
                    inputTextBlock.style.display = 'none';
                    uploadFileBlock.style.display = 'block';
                }
            }
            function toggleVisibility_option(selectedOption) {
                if (selectedOption === 'encrypt-text') {
                    inputText.style.color = 'orange';
                    uploadText.style.color = 'orange';
                } else if (selectedOption === 'decrypt-text') {
                    inputText.style.color = 'red';
                    uploadText.style.color = 'red';
                }
            }

            // check validation of file uploaded in while choosing
            function fileValidation() {
                var fileInput = document.getElementById('myFile');       
                var filePath = fileInput.value;
            
                // Allowing file type
                var allowedExtensions = /(\.txt)$/i;
                
                if (!allowedExtensions.exec(filePath)) {
                    alert('Invalid file type');
                    fileInput.value = '';
                    return false;
                } 
            }

            function validateInputMessage(form) {
                var operation = form.querySelector('input[name="operation"]:checked'); // Get the checked input/file
                var option = form.querySelector('input[name="option"]:checked'); // Get the checked radio button
                var inputText = form.querySelector('input[name="input-text"]'); // Get the input text element
                var fileInput = form.querySelector('input[name="filename"]'); // Get the file input element
                var statusMsg = document.getElementById("statusMsg");

                // Check if an option is selected
                if (option === null) {
                    statusMsg.innerText = "Please select an option.";
                    return false; // Prevent form submission
                }

                if(operation.value === 'input-text'){
                    // Check if the input text is empty
                    if (inputText.value.trim() === "") {
                        statusMsg.innerText = "Please enter your text.";
                        return false; // Prevent form submission
                    }
                } else {
                    // Check if a file is uploaded
                    if (fileInput.files.length === 0) {
                        statusMsg.innerText = "Please select a file.";
                        return false; // Prevent form submission
                    }

                    // Check if the uploaded file is empty
                    if (fileInput.files[0].size === 0) {
                        statusMsg.innerText = "The selected file is empty.";
                        return false; // Prevent form submission
                    }
                }

                // Clear any previous error message
                statusMsg.innerText = "";
                return true; // Allow form submission
            }
            
        </script>
    </body>

    </html>

    HTML;
}


function displayHistory($histories = null){
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <script type="text/javascript" src="animation.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View History</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="style2.css">
        <script type="text/javascript" src="animation.js"></script>
        
        <!-- GSAP Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    </head>

    <body>
        <div class="container-logout">
            <a href="index.php" class="button neon">Back</a>
        </div>

        <div class="text">
            <h1>Your History</h1>
        </div>
            
        <div class="table-container">
            <table class="rwd-table">
            <tr>
                <th>Cipher Name</th>
                <th>Encrypt</th>
                <th>Decrypt</th>
                <th>Time</th>
            </tr>


    HTML;
        // Loop through each history entry and display it in the table
        if(!empty($histories)) {
            foreach($histories as $history) {
                echo "<tr>";
                echo "<td data-th='Cipher Name'>" . $history['cipher_name'] . "</td>";
                echo "<td data-th='Encrypt'>" . $history['encrypt_text'] . "</td>";
                echo "<td data-th='Decrypt'>" . $history['decrypt_text'] . "</td>";
                echo "<td data-th='Time'>" . $history['timerecord'] . "</td>";
                echo "</tr>";
            }
        }

    echo <<<HTML
            
            </table>
        </div>

    </body>

    </html>

    HTML;
}

function displayCaesarCipher($info)
{
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
        
    <head>
        <script type="text/javascript" src="animation.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CipherCaesar</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="style1.css">
        <script type="text/javascript" src="animation.js"></script>
        
        <!-- GSAP Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>


        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    </head>

    <body>
        <div class="container-logout">
            <a href="index.php" class="button neon">Back</a>
        </div>

        <div class="text">
            <h1>Welcome To Caesar Cipher</h1>
        </div>

        <h2><span class='error' id='statusMsg'></span></h2>

        <form method='post' action='' enctype='multipart/form-data' onsubmit="event.preventDefault(); return copyToClipboard()">	 
            <div class="container">
                <h3 id="result"> Result from your prompt: <div id="textToCopy">$info</div></h3>
            </div>
            <div class="container">
                <div class="btn-container">
                    <input type="submit" value="Copy Text">
                </div>
            </div>
        </form>

        <script>        
            document.querySelectorAll('input[type=radio][name="operation"]').forEach(function(radio) {
                radio.addEventListener('click', function() {
                    showOperation(this.value); // Call the showOperation function with the selected value
                });
            });

             // Function to make an AJAX request to the server
            function showOperation(operation) {
                var xhttp;
                if(window.XMLHttpRequest)
                    xhttp = new XMLHttpRequest();
                else
                    xhttp = new ActiveXObject("Microsoft.XMLHTTP");

                xhttp.open("POST", "./ajax/Caesar.php?", true);
                //Send the proper header information along with the request
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("result").innerHTML = this.responseText;
                    }
                };
                
                xhttp.send("operation="+operation);
            }

            function copyToClipboard() {
                var statusMsg = document.getElementById("statusMsg");
                // Get the text to copy
                var textToCopy = document.getElementById("textToCopy").innerText;
                
                // Create a temporary input element
                var tempInput = document.createElement("input");
                
                // Set the value of the temporary input to the text to copy
                tempInput.value = textToCopy;
                
                // Append the temporary input to the body
                document.body.appendChild(tempInput);
                
                // Select the text inside the temporary input
                tempInput.select();
                
                // Copy the selected text to the clipboard
                document.execCommand("copy");
                
                // Remove the temporary input from the body
                document.body.removeChild(tempInput);
                
                // Alert the user that the text has been copied (you can use other UI elements for a more elegant message)
                //alert("Text copied to clipboard: " + textToCopy);
                statusMsg.innerText = "Text copied to clipboard: " + textToCopy;
            }
        </script>
    </body>

    </html>

    HTML;
}

function displayTransCipher($info)
{
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
        
    <head>
        <script type="text/javascript" src="animation.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TranspositionCaesar</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="style1.css">
        <script type="text/javascript" src="animation.js"></script>
        
        <!-- GSAP Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>


        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    </head>

    <body>
        <div class="container-logout">
            <a href="index.php" class="button neon">Back</a>
        </div>

        <div class="text">
            <h1>Welcome To Transposition Cipher</h1>
        </div>
        
        <h2><span class='error' id='statusMsg'></span></h2>

        <form method='post' action='' enctype='multipart/form-data' onsubmit="event.preventDefault(); return copyToClipboard()">	 
            <div class="container">
                <h3 id="result"> Result from your prompt: <div id="textToCopy">$info</div></h3>
            </div>
            <div class="container">
                <div class="btn-container">
                    <input type="submit" value="Copy Text">
                </div>
            </div>
        </form>

        <script>        
            document.querySelectorAll('input[type=radio][name="operation"]').forEach(function(radio) {
                radio.addEventListener('click', function() {
                    showOperation(this.value); // Call the showOperation function with the selected value
                });
            });

             // Function to make an AJAX request to the server
            function showOperation(operation) {
                var xhttp;
                if(window.XMLHttpRequest)
                    xhttp = new XMLHttpRequest();
                else
                    xhttp = new ActiveXObject("Microsoft.XMLHTTP");

                xhttp.open("POST", "./ajax/Caesar.php?", true);
                //Send the proper header information along with the request
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("result").innerHTML = this.responseText;
                    }
                };
                
                xhttp.send("operation="+operation);
            }

            function copyToClipboard() {
                var statusMsg = document.getElementById("statusMsg");
                // Get the text to copy
                var textToCopy = document.getElementById("textToCopy").innerText;
                
                // Create a temporary input element
                var tempInput = document.createElement("input");
                
                // Set the value of the temporary input to the text to copy
                tempInput.value = textToCopy;
                
                // Append the temporary input to the body
                document.body.appendChild(tempInput);
                
                // Select the text inside the temporary input
                tempInput.select();
                
                // Copy the selected text to the clipboard
                document.execCommand("copy");
                
                // Remove the temporary input from the body
                document.body.removeChild(tempInput);
                
                // Alert the user that the text has been copied (you can use other UI elements for a more elegant message)
                //alert("Text copied to clipboard: " + textToCopy);
                statusMsg.innerText = "Text copied to clipboard: " + textToCopy;
            }
        </script>
    </body>

    </html>

    HTML;
}

function displayRC4Cipher($info)
{
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
        
    <head>
        <script type="text/javascript" src="animation.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>StreamCaesar</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="style1.css">
        <script type="text/javascript" src="animation.js"></script>
        
        <!-- GSAP Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>


        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    </head>

    <body>
        <div class="container-logout">
            <a href="index.php" class="button neon">Back</a>
        </div>

        <div class="text">
            <h1>Welcome To RC4 Cipher</h1>
        </div>
        
        <h2><span class='error' id='statusMsg'></span></h2>

        <form method='post' action='' enctype='multipart/form-data' onsubmit="event.preventDefault(); return copyToClipboard()">	 
            <div class="container">
                <h3 id="result"> Result from your prompt: <div id="textToCopy">$info</div></h3>
            </div>
            <div class="container">
                <div class="btn-container">
                    <input type="submit" value="Copy Text">
                </div>
            </div>
        </form>

        <script>        
            document.querySelectorAll('input[type=radio][name="operation"]').forEach(function(radio) {
                radio.addEventListener('click', function() {
                    showOperation(this.value); // Call the showOperation function with the selected value
                });
            });

             // Function to make an AJAX request to the server
            function showOperation(operation) {
                var xhttp;
                if(window.XMLHttpRequest)
                    xhttp = new XMLHttpRequest();
                else
                    xhttp = new ActiveXObject("Microsoft.XMLHTTP");

                xhttp.open("POST", "./ajax/Caesar.php?", true);
                //Send the proper header information along with the request
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("result").innerHTML = this.responseText;
                    }
                };
                
                xhttp.send("operation="+operation);
            }

            function copyToClipboard() {
                var statusMsg = document.getElementById("statusMsg");
                // Get the text to copy
                var textToCopy = document.getElementById("textToCopy").innerText;
                
                // Create a temporary input element
                var tempInput = document.createElement("input");
                
                // Set the value of the temporary input to the text to copy
                tempInput.value = textToCopy;
                
                // Append the temporary input to the body
                document.body.appendChild(tempInput);
                
                // Select the text inside the temporary input
                tempInput.select();
                
                // Copy the selected text to the clipboard
                document.execCommand("copy");
                
                // Remove the temporary input from the body
                document.body.removeChild(tempInput);
                
                // Alert the user that the text has been copied (you can use other UI elements for a more elegant message)
                //alert("Text copied to clipboard: " + textToCopy);
                statusMsg.innerText = "Text copied to clipboard: " + textToCopy;
            }
        </script>
    </body>

    </html>

    HTML;
}

function displayDESCipher($info)
{
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
        
    <head>
        <script type="text/javascript" src="animation.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BlockCaesar</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="style1.css">
        <script type="text/javascript" src="animation.js"></script>
        
        <!-- GSAP Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>


        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    </head>

    <body>
        <div class="container-logout">
            <a href="index.php" class="button neon">Back</a>
        </div>

        <div class="text">
            <h1>Welcome To DES Cipher</h1>
        </div>
        
        <h2><span class='error' id='statusMsg'></span></h2>

        <form method='post' action='' enctype='multipart/form-data' onsubmit="event.preventDefault(); return copyToClipboard()">	 
            <div class="container">
                <h3 id="result"> Result from your prompt: <div id="textToCopy">$info</div></h3>
            </div>
            <div class="container">
                <div class="btn-container">
                    <input type="submit" value="Copy Text">
                </div>
            </div>
        </form>

        <script>        
            document.querySelectorAll('input[type=radio][name="operation"]').forEach(function(radio) {
                radio.addEventListener('click', function() {
                    showOperation(this.value); // Call the showOperation function with the selected value
                });
            });

             // Function to make an AJAX request to the server
            function showOperation(operation) {
                var xhttp;
                if(window.XMLHttpRequest)
                    xhttp = new XMLHttpRequest();
                else
                    xhttp = new ActiveXObject("Microsoft.XMLHTTP");

                xhttp.open("POST", "./ajax/Caesar.php?", true);
                //Send the proper header information along with the request
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("result").innerHTML = this.responseText;
                    }
                };
                
                xhttp.send("operation="+operation);
            }

            function copyToClipboard() {
                var statusMsg = document.getElementById("statusMsg");
                // Get the text to copy
                var textToCopy = document.getElementById("textToCopy").innerText;
                
                // Create a temporary input element
                var tempInput = document.createElement("input");
                
                // Set the value of the temporary input to the text to copy
                tempInput.value = textToCopy;
                
                // Append the temporary input to the body
                document.body.appendChild(tempInput);
                
                // Select the text inside the temporary input
                tempInput.select();
                
                // Copy the selected text to the clipboard
                document.execCommand("copy");
                
                // Remove the temporary input from the body
                document.body.removeChild(tempInput);
                
                // Alert the user that the text has been copied (you can use other UI elements for a more elegant message)
                //alert("Text copied to clipboard: " + textToCopy);
                statusMsg.innerText = "Text copied to clipboard: " + textToCopy;
            }
        </script>
    </body>

    </html>

    HTML;
}
?>