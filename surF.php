
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variantes de Liens au Survol/Scroll</title>
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
            width: 80%;
            max-width: 1000px;
            justify-content: space-between;
            align-items: center;
        }

        /* Liste des liens */
        .links-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .link-item {
            font-size: 2.5rem;
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
            width: 400px;
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
            background: rgba(0, 0, 0, 0.7);
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
        Liste des liens interactifs
        <div class="links-list">
            <button class="link-item active" data-target="variant-1">Design UI/UX</button>
            <button class="link-item" data-target="variant-2">Développement Web</button>
            <button class="link-item" data-target="variant-3">Intelligence Artificielle</button>
        </div>

        <!-- Conteneur des variantes correspondantes -->
        <div class="variants-container">
            <!-- Variante 1 -->
            <div class="variant-card active" id="variant-1" style="background-image: linear-gradient(to top, rgba(0,0,0,0.9), transparent), url('https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=600&q=80')">
                <div class="variant-info">
                    <h3>Variante : Mode Clair / Minimaliste</h3>
                    <p>Focus sur l'expérience utilisateur et l'ergonomie visuelle.</p>
                </div>
            </div>

            <!-- Variante 2 -->
            <div class="variant-card" id="variant-2" style="background-image: linear-gradient(to top, rgba(0,0,0,0.9), transparent), url('https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80')">
                <div class="variant-info">
                    <h3>Variante : Stack Moderne</h3>
                    <p>Utilisation de React, Node.js et architectures micro-services.</p>
                </div>
            </div>

            <!-- Variante 3 -->
            <div class="variant-card" id="variant-3" style="background-image: linear-gradient(to top, rgba(0,0,0,0.9), transparent), url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=600&q=80')">
                <div class="variant-info">
                    <h3>Variante : Modèles Génératifs</h3>
                    <p>Intégration d'agents intelligents et de traitements de données lourds.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sélectionner tous les liens et toutes les cartes de variantes
        const links = document.querySelectorAll('.link-item');
        const variants = document.querySelectorAll('.variant-card');

        // Parcourir chaque lien pour écouter l'événement de survol (ou de défilement)
        links.forEach(link => {
            link.addEventListener('mouseenter', () => {
                // Retirer la classe active de tous les liens et variantes
                links.forEach(l => l.classList.remove('active'));
                variants.forEach(v => v.classList.remove('active'));

                // Activer le lien survolé
                link.classList.add('active');

                // Récupérer l'identifiant de la variante cible
                const targetId = link.getAttribute('data-target');
                const targetVariant = document.getElementById(targetId);

                // Activer la variante correspondante
                if (targetVariant) {
                    targetVariant.classList.add('active');
                }
            });
        });
    </script>

</body>
</html>