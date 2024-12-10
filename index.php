<?php

include("./autoLoader.php");

session_start();


// Vérifier si les personnages existent déjà dans la session
if (!isset($_SESSION['monNain'])) {
    // Créer un nouveau Nain et l'ajouter à la session
    $_SESSION['monNain'] = new Nain("kaissaoutsse");
    $_SESSION['monNain']->Hache();
}

if (!isset($_SESSION['monElfe'])) {
    // Créer un nouvel Elfe et l'ajouter à la session
    $_SESSION['monElfe'] = new Elfe("coquinette");
    $_SESSION['monElfe']->Arc();  // Assigner une arme à l'Elfe
}

// Récupérer les objets Nain et Elfe à partir de la session
$monNain = $_SESSION['monNain'];
$monElfe = $_SESSION['monElfe'];

// Initialiser le compteur de tours si ce n'est pas déjà fait
if (!isset($_SESSION['nbTours'])) {
    $_SESSION['nbTours'] = 0; // Premier tour
}

// Fonction pour réinitialiser les personnages et les tours
if (isset($_POST['restart'])) {
    // Réinitialiser les objets de session
    unset($_SESSION['monNain']);
    unset($_SESSION['monElfe']);
    unset($_SESSION['nbTours']);
    // Rediriger vers la même page pour que les modifications soient appliquées
    header("Location: " . $_SERVER['PHP_SELF']);
    exit(); // Assurez-vous que le script s'arrête après la redirection
}


// Gestion des actions (attaquer ou soigner)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['attaquer_nain'])) {
        // Nain attaque l'Elfe
        $dommages = $monNain->attaquer();
        $monElfe->recevoirDommage($dommages);
    }
    
    if (isset($_POST['attaquer_elfe'])) {
        // Elfe attaque le Nain
        $dommages = $monElfe->attaquer();
        $monNain->recevoirDommage($dommages);
    }
    
    if (isset($_POST['soin_elfe'])) {
        // L'elfe se soigne
        $monElfe->soigner();
    }
    
    if (isset($_POST['soin_nain'])) {
        // Le nain se soigne
        $monNain->soigner();
    }
    
    // Incrémenter le nombre de tours après chaque action
    $_SESSION['nbTours']++;
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Dome du Tonnerre</title>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'MedievalSharp', sans-serif;
            background: url('https://your-fantasy-background-image.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            margin: 0;
            padding: 0;
            background-image: url("./images/arena.jpg");
        }
        .container {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            height: 700px;
        }
        .character {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }
        h3 {
            text-align: center;
            color: #FFD700;
        }
        .stat {
            margin-bottom: 10px;
            height: 10%;
            font-size: 30px;
        }
        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            background: linear-gradient(45deg, #6b8e23, #228b22);
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: linear-gradient(45deg, #228b22, #6b8e23);
        }
        .restart-btn {
            background: #dc143c;
            margin-top: 30px;
            display: block;
            width: 200px;
            margin: 30px auto;
        }
        .restart-btn:hover {
            background: #b22222;
        }
        .status {
            text-align: center;
            margin-top: 20px;
            font-size: 30px;
            color: black;
        }
        .affichePV {
            color: black;
            background: red;
            height: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            font-size: 20px;
            margin-top: 1px;
        }
        .imgNain {
            width: 10%;
            height: 10%;
            margin-right: 1000px;
            margin-top: 200px;
            position: absolute;
        }
        .imgElfe {
    position: absolute;
    margin-left: 650px;
    margin-top: 15px;
    transition: transform 0.3s ease;
}

/* Animation de secousse */
@keyframes tilt-shaking {
    0% { transform: rotate(0deg); }
    25% { transform: rotate(5deg); }
    50% { transform: rotate(0deg); }
    75% { transform: rotate(-5deg); }
    100% { transform: rotate(0deg); }
}

.shake {
    animation: tilt-shaking 0.5s ease forwards;
}
                    
     
    </style>
</head>
<body>
<div class="container">
    <div class="character">
        <h3>Informations du Nain :</h3>
        <p class="stat">Nom: <?= $monNain->getName(); ?></p>
        <p class="stat">PDV: <?= $monNain->getPV(); ?></p>
        <p class="stat">Endurance: <?= $monNain->getEndurance(); ?></p>
        <p class="stat">Force: <?= $monNain->getForce(); ?></p>
        <p class="stat">Statut: <?= $monNain->getEnVie(); ?></p>
        <p class="stat">Arme: <?= $monNain->getNomArme(); ?></p>

        <div class="buttons">
            <form method="post">
                <button type="submit" id='attNain' name="attaquer_nain">Attaquer</button>
                <button type="submit" id='soinNain' name="soin_nain">Soigner</button>
            </form>
        </div>
    </div>

    <div class="imgNain">
        <img src="./images/dwarf-removebg-preview.png" id="nain_image" alt="Nain" />
    </div>

    <div class="affichePV">
    <p><?= $monNain->getPV(); ?> PV</p>
    </div>

    <div class="status">
    <p>Nombre de tours : <?= $_SESSION['nbTours']; ?></p>
    </div>

    <div class="affichePV">
    <p><?= $monElfe->getPV(); ?> PV</p>
    </div>

    <div class=imgElfe>
        <img src="./images/elf-removebg-preview.png" id="elfe_image" alt="Elfe" />
    </div>

    <div class="character">
        <h3>Informations de l'Elfe :</h3>
        <p class="stat">Nom: <?= $monElfe->getName(); ?></p>
        <p class="stat">PDV: <?= $monElfe->getPV(); ?></p>
        <p class="stat">Endurance: <?= $monElfe->getEndurance(); ?></p>
        <p class="stat">Force: <?= $monElfe->getForce(); ?></p>
        <p class="stat">Statut: <?= $monElfe->getEnVie(); ?></p>
        <p class="stat">Arme: <?= $monElfe->getNomArme(); ?></p>

        <div class="buttons">
            <form method="post">
                <button type="submit" id="attElfe" name="attaquer_elfe">Attaquer</button>
                <button type="submit" id="soinElfe" name="soin_elfe">Soigner</button>
            </form>
        </div>
    </div>
</div>



<form method="post">
    <button type="submit" name="restart" class="restart-btn">RESTART</button>
</form>

</body>
</html>

<script>
// Récupérer les éléments nécessaires
const attaquerNainBtn = document.querySelector('button[name="attaquer_nain"]');
const attaquerElfeBtn = document.querySelector('button[name="attaquer_elfe"]');
const nainImage = document.getElementById('nain_image');
const elfeImage = document.getElementById('elfe_image');

// Fonction pour secouer l'image
function secouerImage(imageElement, formElement) {
    imageElement.classList.add('shake');
    // Supprimer l'animation après 500ms pour pouvoir la réappliquer
    setTimeout(function () {
        imageElement.classList.remove('shake');
        // Soumettre le formulaire après l'animation
        formElement.submit();  // Soumettre le formulaire après l'animation
    }, 250);  // Durée de l'animation
    
}

// Événement lorsque le bouton "Attaquer Nain" est cliqué
attaquerNainBtn.addEventListener('click', function (e) {
    e.preventDefault();  // Empêche le formulaire d'être soumis immédiatement

    // Appliquer l'animation de secousse à l'image du Nain uniquement
    const form = attaquerNainBtn.closest('form'); // Récupère le formulaire parent
    secouerImage(nainImage, form);
     // Secouer l'image et soumettre le formulaire après l'animation
    <?php $dommages = $monElfe->attaquer();
     $monNain->recevoirDommage($dommages); ?>
    });

// Événement lorsque le bouton "Attaquer Elfe" est cliqué
attaquerElfeBtn.addEventListener('click', function (e) {
    e.preventDefault();  // Empêche le formulaire d'être soumis immédiatement

    // Appliquer l'animation de secousse à l'image de l'Elfe uniquement
    const form = attaquerElfeBtn.closest('form'); // Récupère le formulaire parent
    secouerImage(elfeImage, form); // Secouer l'image et soumettre le formulaire après l'animation
    <?php $dommages = $monNain->attaquer();
     $monElfe->recevoirDommage($dommages); ?>
});

// </script>
