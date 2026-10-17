<?php
// --- CONFIGURATION DE LA BASE DE DONNÉES ---
$host = 'localhost';
$dbname = 'mon_site';
$username = 'root';
$password = ''; // Laissez vide par défaut sous XAMPP/Wamp

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Configuration des erreurs PDO en mode Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Récupération des données depuis la base de données
    $stmt = $pdo->query("SELECT * FROM liens_variantes");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variantes Dynamiques (PHP & MySQL)</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f0f0f;
            color: #ffffff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 85%;
            max-width: 1000px;
            justify-content: space-between;
            align-items: center;
        }

        /* Liste des liens générée par PHP */
        .links-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .link-item {
            font-size: 2.2rem;
            font-weight: bold;
            color: #555;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.3s ease;
            cursor: pointer;
            background: none;
            border: none;
            text-align: left;
        }

        .link-item:hover, .link-item.active {
            color: #ffffff;
            transform: translateX(10px);
        }

        /* Zone d'affichage des variantes */
        .variants-container {
            position: relative;
            width: 420px;
            height: 300px;
            border-radius: 12px;
            overflow: hidden;
            background-color: #1a1a1a;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .variant-card {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, transform 0.4s ease;
            transform: translateY(20px);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 20px;
            background-size: cover;
            background-position: center;
        }

        .variant-card.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .variant-info {
            background: rgba(0, 0, 0, 0.75);
            padding: 15px;
            border-radius: 8px;
            backdrop-filter: blur(5px);
        }

        .variant-info h3 {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: #ff3366;
        }

        .variant-info p {
            font-size: 0.9rem;
            color: #ccc;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- 1. Génération dynamique des liens depuis PHP -->
        <div class="links-list">
            <?php foreach ($items as $index => $item): ?>
                <button class="link-item <?= $index === 0 ? 'active' : '' ?>" data-target="variant-<?= $item['id'] ?>">
                    <?= htmlspecialchars($item['titre']) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- 2. Génération dynamique des cartes de variantes depuis PHP -->
        <div class="variants-container">
            <?php foreach ($items as $index => $item): ?>
                <div class="variant-card <?= $index === 0 ? 'active' : '' ?>" 
                     id="variant-<?= $item['id'] ?>" 
                     style="background-image: linear-gradient(to top, rgba(0,0,0,0.9), transparent), url('<?= htmlspecialchars($item['image_url']) ?>')">
                    <div class="variant-info">
                        <h3><?= htmlspecialchars($item['variante_titre']) ?></h3>
                        <p><?= htmlspecialchars($item['variante_description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 3. Script JavaScript pour l'interactivité au survol -->
    <script>
        const links = document.querySelectorAll('.link-item');
        const variants = document.querySelectorAll('.variant-card');

        links.forEach(link => {
            link.addEventListener('mouseenter', () => {
                // Désactiver tous les éléments
                links.forEach(l => l.classList.remove('active'));
                variants.forEach(v => v.classList.remove('active'));

                // Activer le lien survolé
                link.classList.add('active');

                // Récupérer la variante correspondante via l'attribut data-target
                const targetId = link.getAttribute('data-target');
                const targetVariant = document.getElementById(targetId);

                if (targetVariant) {
                    targetVariant.classList.add('active');
                }
            });
        });
    </script>

</body>
</html>