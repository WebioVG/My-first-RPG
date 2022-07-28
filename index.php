<?php

    require_once __DIR__.'/config/autoload.php';

    use player\Character;

    ///////////////////////
    // DECLARE VARIABLES //
    ///////////////////////

    $isGameRunning = isset($_GET['player']) && isset($_GET['opponent']) && isset($_GET['method']) && isset($_COOKIE['player']) ? true : false;
    $player1InGameID = $_COOKIE['player'] ?? 0;
    $player2InGameID = setPlayer2InGameID($isGameRunning, $player1InGameID);
    $player1 = null;
    $player2 = null;
    $currentPlayer = null;
    $otherPlayer = null;
    $winner = null;

    ///////////////
    // FUNCTIONS //
    ///////////////

    function getRandomCharacterID(int $except) {
        do {
            $random = rand(0, count(selectAll('SELECT inGameID FROM player')) - 1);
            $player2ID = selectAll('SELECT inGameID FROM player')[$random]['inGameID'];
        } while ($player2ID === $except || !checkIfCharacterIsAliveByID($player2ID));

        return $player2ID;
    }

    function checkIfCharacterIsAliveByID($id) {
        if (selectOne('SELECT * FROM player WHERE inGameID = '.$id)['isDead'] === 1) {
            return false;
        } else {
            return true;
        }
    }
    
    function setPlayer2InGameID($isGameRunning, $player1InGameID) {
        if (!$isGameRunning) {
            $player2InGameID = getRandomCharacterID($player1InGameID) ?? 0;
            setcookie('opponent', $player2InGameID, time() + 60 * 60 * 24 * 365);
        } else {
            $player2InGameID = $_COOKIE['opponent'];
        }

        return $player2InGameID;
    }

    //////////
    // MAIN //
    //////////

    // Load the players
    if ($player1InGameID !== 0) {
        $player1 = Character::load($player1InGameID);

        if ($isGameRunning) {
            $player2 = Character::load($player2InGameID);
        }
    }

    if ($isGameRunning && $_GET['method'] !== '') {
        if ($_GET['player'] == $player1->getInGameID()) {
            $currentPlayer = $player1;
            $otherPlayer = $player2;
        } elseif ($_GET['player'] == $player2->getInGameID()) {
            $currentPlayer = $player2;
            $otherPlayer = $player1;
        } else {
            echo 'ERROR';
            die();
        }

        if ($_GET['method'] === 'attack') {
            $currentPlayer->genericAttack($otherPlayer);
        }
    }

    // End the game when a player's health reaches zero
    if ($isGameRunning && $player1->getIsDead()) {
        $winner = clone $player2;
        $isGameRunning = false;
        
        unset($player2);
    } else if ($isGameRunning && $player2->getIsDead()) {
        $winner = clone $player1;
        $isGameRunning = false; 
                
        unset($player2);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="js/index.js"></script>

    <title>RPG - Accueil</title>
</head>

<body>

    <?php require 'partials/header.php'; ?>

    <main class="pt-[12vh] relative">
        <h2 class="text-center text-2xl font-semibold py-12">Combat aléatoire</h2>

        <?php if ($winner !== null) { ?>
            <h3 class="bg-green-300 text-center text-2xl font-semibold py-4 my-12"><span class="font-semibold text-3xl text-rose-600"><?= $winner->getName() ?></span> a gagné !</h3>
        <?php } ?>

        <section class="flex justify-center gap-4">
            <a href="index.php?player=<?= $player1InGameID ?>&opponent=<?= $player2InGameID ?>&method=" class="bg-emerald-600 inline-block rounded-lg text-center text-lg font-semibold mb-8 px-6 py-1 text-white">Démarrer</a>
            <a href="index.php" class="bg-red-600 inline-block rounded-lg text-center text-lg font-semibold mb-8 px-6 py-1 text-white">Réinitialiser</a>
        </section>

        <section class="max-w-[1000px] mx-auto grid grid-cols-2 gap-16 mb-12">
            <?php if ($player1 !== null) { ?>
                <article class="bg-slate-100 border rounded-lg p-4 relative">
                    <?php if (isset($player2) && $currentPlayer === $player2) { ?>
                        <img class="absolute left-3 top-3" src="img/star.svg" alt="étoile">
                    <?php } ?>

                    <h2 class="text-center text-lg text-blue-400 font-semibold mb-4 italic">Votre personnage</h2>
                    <h3 class="text-center text-xl font-semibold mb-4 underline"><?= $player1->getName() ?></h3>

                    <?php switch ($player1->getClass()) {
                        case 'warrior':
                            echo '<img class="object-cover w-[150px] h-[150px] mx-auto mb-4 rounded-[50%] border" src="img/auron.jpg" alt="un chasseur">';
                            
                            break;
                        case 'mage':
                            echo '<img class="object-cover w-[150px] h-[150px] mx-auto mb-4 rounded-[50%] border" src="img/lulu.jpg" alt="un chasseur">';
                                
                            break;
                        case 'hunter':
                            echo '<img class="object-cover w-[150px] h-[150px] mx-auto mb-4 rounded-[50%] border" src="img/wakka.jpg" alt="un chasseur">';
                                
                            break;
                    } ?>

                    <hr class="my-3">

                    <h5 class="mx-auto text-center w-[100px] mb-4 text-lg border-b pb-1">Statistiques</h5>
                    
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">ID : </span><span class="italic"><?= $player1->getInGameID() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Classe : </span><span class="italic"><?= $player1->getClass() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Tribu : </span><span class="italic"><?= $player1->getTribe() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Vie : </span><span class="italic"><?= $player1->getHealth() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Mana : </span><span class="italic"><?= $player1->getMana() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Force : </span><span class="italic"><?= $player1->getStrength() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Puissance : </span><span class="italic"><?= $player1->getPower() ?></span></p>

                    <?php if ($winner === null) { ?>
                        <hr class="my-3">

                        <h5 class="mx-auto text-center w-[100px] mb-4 text-lg border-b pb-1">Menu</h5>

                        <a href="index.php?player=<?= $player1InGameID ?>&opponent=<?= $player2InGameID ?>&method=attack" id="player1AttackButton" class="py-2 px-12 bg-blue-400 text-white font-bold border rounded-lg block text-center mx-auto duration-300 w-3/4 hover:border-blue-600" type="button">Attaquer</a>
                    <?php } ?>
                </article>
            <?php } else { ?>

                <p class="text-center text-xl text-red-600 font-semibold absolute left-[50%] top-[50%] translate-x-[-50%] pt-32">Vous devez créer un personnage pour pouvoir jouer.</p>

            <?php } ?>

            <?php if (isset($player2) && $player2 !== null) { ?>
                <article class="bg-slate-100 border rounded-lg p-4 relative">
                    <?php if (isset($player1) && $currentPlayer === $player1) { ?>
                        <img class="absolute right-3 top-3" src="img/star.svg" alt="étoile">
                    <?php } ?>

                    <h2 class="text-center text-lg text-rose-600 font-semibold mb-4 italic">Votre adversaire</h2>
                    <h3 class="text-center text-xl font-semibold mb-4 underline"><?= $player2->getName() ?></h3>

                    <?php switch ($player2->getClass()) {
                        case 'warrior':
                            echo '<img class="object-cover w-[150px] h-[150px] mx-auto mb-4 rounded-[50%] border" src="img/auron.jpg" alt="un chasseur">';
                            
                            break;
                        case 'mage':
                            echo '<img class="object-cover w-[150px] h-[150px] mx-auto mb-4 rounded-[50%] border" src="img/lulu.jpg" alt="un chasseur">';
                                
                            break;
                        case 'hunter':
                            echo '<img class="object-cover w-[150px] h-[150px] mx-auto mb-4 rounded-[50%] border" src="img/wakka.jpg" alt="un chasseur">';
                                
                            break;
                    } ?>

                    <hr class="my-3">

                    <h5 class="mx-auto text-center w-[100px] mb-4 text-lg border-b pb-1">Statistiques</h5>
                    
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">ID : </span><span class="italic"><?= $player2->getInGameID() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Classe : </span><span class="italic"><?= $player2->getClass() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Tribu : </span><span class="italic"><?= $player2->getTribe() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Vie : </span><span class="italic"><?= $player2->getHealth() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Mana : </span><span class="italic"><?= $player2->getMana() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Force : </span><span class="italic"><?= $player2->getStrength() ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Puissance : </span><span class="italic"><?= $player2->getPower() ?></span></p>

                    <?php if ($winner === null) { ?>
                        <hr class="my-3">

                        <h5 class="mx-auto text-center w-[100px] mb-4 text-lg border-b pb-1">Menu</h5>

                        <a href="index.php?player=<?= $player2InGameID ?>&opponent=<?= $player1InGameID ?>&method=attack" class="py-2 px-12 bg-rose-400 text-white font-bold border rounded-lg block text-center mx-auto duration-300 w-3/4 hover:border-rose-600" type="button">Attaquer</a>
                    <?php } ?>
                </article>
            <?php } ?>
        </section>
    </main>

</body>

</html>