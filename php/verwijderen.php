<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApotheCare</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/f7a63622f4.js" crossorigin="anonymous"></script> <!-- Icons library -->
</head>
<body>
    <nav> <!-- Navigatie Bar -->
        <div class="nav-container"> <!-- De foto & text die links staat. -->
            <div class="nav-left">
                <a href="../index.html" class="logo-link">
                    <img src="../images/logo.png" alt="ApotheCare Logo" class="logo">
                </a>
                <a href="">Producten</a>
                <a href="">Chatbot</a>
            </div>
    
            <div class="search-container"> <!-- Input Field & Button die in het midden staan.  -->
                <div class="search-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input placeholder="Zoek een product...">
                    <button>Meer zorg</button>
                </div>
            </div>
    
            <div class="nav-right"> <!-- De links die rechts staan. -->
                <a href="">Inloggen</a>
                <a href="">Registreren</a>
            </div>
        </div>
    </nav>

    <div class="login-container"> <!-- Container die alle components van het inlog form behoud. -->
        <h1>Inloggen</h1>
        
        <form class="login-form" action="login.php" method="POST"> <!-- Formulier voor inloggen. -->
            <div class="form-group">
                <label for="username">Email Adres of naam:</label>
                <input type="text" id="username" name="username" required> <!-- Input field voor email adres of naam. -->
            </div>
            
            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required> <!-- Input field voor wachtwoord. -->
            </div>
            
            <div class="form-actions">
                <a href="register.html" class="register-link">Registreren →</a> <!-- Link naar registreren. -->
                <button type="submit" class="login-btn">Inloggen</button> <!-- Inloggen button. -->
            </div>
        </form>
    </div>
</body>
</html>