<?php
// Démarrage ou réinitialisation de la session pour garder le nombre secret
session_start();

// Génération d'un nouveau nombre secret entre 1 et 100 si inexistant
if (!isset($_SESSION['nombre_secret'])) {
    $_SESSION['nombre_secret'] = rand(1, 100);
}

$message = "";
$statut_lumiere = "eteinte"; // 'verte', 'rouge', ou 'eteinte'

// Traitement du formulaire en PHP (si JavaScript est désactivé, le PHP prend le relais)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['devinette'])) {
    $saisie = intval($_POST['devinette']);
    
    if ($saisie === $_SESSION['nombre_secret']) {
        $message = "Bravo ! Vous avez trouvé le nombre secret !";
        $statut_lumiere = "verte";
        // Optionnel : réinitialiser pour une nouvelle partie
        // unset($_SESSION['nombre_secret']);
    } elseif ($saisie < $_SESSION['nombre_secret']) {
        $message = "C'est plus grand !";
        $statut_lumiere = "rouge";
    } else {
        $message = "C'est plus petit !";
        $statut_lumiere = "rouge";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu des chiffres à deviner</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .game-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            width: 320px;
        }
        h1 {
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            width: 80%;
            border: 2px solid #ddd;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
            outline: none;
        }
        input[type="number"]:focus {
            border-color: #007bff;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover {
            background-color: #0056b3;
        }
        #message {
            margin-top: 15px;
            font-weight: bold;
            font-size: 15px;
        }
        /* Style des lumières (LED) */
        .lumiere-container {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .led {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: #ccc; /* Éteinte par défaut */
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .led.verte {
            background-color: #28a745;
            box-shadow: 0 0 12px #28a745, inset 0 2px 4px rgba(255,255,255,0.4);
        }
        .led.rouge {
            background-color: #dc3545;
            box-shadow: 0 0 12px #dc3545, inset 0 2px 4px rgba(255,255,255,0.4);
        }
        .label-led {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="game-container">
    <h1>Devinez le chiffre</h1>
    <p>Trouvez le nombre entre 1 et 100.</p>
    
    <!-- Formulaire (fonctionne avec ou sans JS grâce au PHP) -->
    <form method="POST" id="gameForm">
        <input type="number" name="devinette" id="devinette" min="1" max="100" placeholder="Votre nombre" required autocomplete="off">
        <br>
        <button type="submit" id="valider">Valider</button>
    </form>

    <div id="message"><?php echo htmlspecialchars($message); ?></div>

    <!-- Indicateur lumineux -->
    <div class="lumiere-container">
        <div id="ledIndicator" class="led <?php echo $statut_lumiere; ?>"></div>
        <span class="label-led">Statut</span>
    </div>
</div>

<!-- JavaScript pour rendre le jeu dynamique sans recharger la page -->
<script>
    // Récupération du nombre secret généré par PHP de manière sécurisée
    const nombreSecret = <?php echo $_SESSION['nombre_secret']; ?>;

    const form = document.getElementById('gameForm');
    const inputDevinette = document.getElementById('devinette');
    const messageDiv = document.getElementById('message');
    const ledIndicator = document.getElementById('ledIndicator');

    form.addEventListener('submit', function(e) {
        // Empêche le rechargement de la page pour une expérience fluide en JS
        e.preventDefault(); 

        const valeurSaisie = parseInt(inputDevinette.value);

        // Réinitialisation des classes de la LED
        ledIndicator.className = "led";

        if (isNaN(valeurSaisie)) {
            messageDiv.textContent = "Veuillez entrer un nombre valide.";
            messageDiv.style.color = "#333";
            return;
        }

        if (valeurSaisie === nombreSecret) {
            messageDiv.textContent = "🎉 Bravo ! Vous avez trouvé le nombre secret !";
            messageDiv.style.color = "#28a745";
            ledIndicator.classList.add('verte'); // Allume la lumière verte
        } else if (valeurSaisie < nombreSecret) {
            messageDiv.textContent = "📉 C'est plus grand !";
            messageDiv.style.color = "#dc3545";
            ledIndicator.classList.add('rouge'); // Allume la lumière rouge
        } else {
            messageDiv.textContent = "📈 C'est plus petit !";
            messageDiv.style.color = "#dc3545";
            ledIndicator.classList.add('rouge'); // Allume la lumière rouge
        }

        // Vider le champ de saisie pour le prochain essai
        inputDevinette.value = "";
        inputDevinette.focus();
    });
</script>

</body>
</html>