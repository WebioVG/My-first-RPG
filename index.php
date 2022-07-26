<?php

    require 'config/helpers.php';
    require 'classes/Character.php';
    require 'classes/DB.php';

    $inGameID = $_COOKIE['inGameID'] ?? null;
    $player1 = null;
    $player2 = null;
    $gameIsRunning = true;

    function getRandomCharacterID($except) {
        do {
            $random = rand(0, count(selectAll('SELECT inGameID FROM player')) - 1);
            $player2ID = selectAll('SELECT inGameID FROM player')[$random]['inGameID'];
        } while ($player2ID === $except);

        return $player2ID;
    }

    function loadOpponent($except) {
        return Character::load(getRandomCharacterID($except));
    }

    if (isset($inGameID)) {
        $player1 = Character::load($inGameID);
    }

    if ($gameIsRunning && $player1 !== null) {
        $player2 = loadOpponent($player1->getInGameID());
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <title>RPG - Accueil</title>
</head>

<body>

    <?php require 'partials/header.php'; ?>

    <main class="pt-[12vh] relative">
        <h2 class="text-center text-2xl font-semibold py-8">Combat aléatoire</h2>

        <section class="max-w-[1000px] mx-auto grid grid-cols-2 gap-16 mb-12">
            <?php if ($player1 !== null) { ?>
                <article class="bg-slate-100 border rounded-lg p-4">
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

                    <hr class="my-3">

                    <h5 class="mx-auto text-center w-[100px] mb-4 text-lg border-b pb-1">Menu</h5>

                    <button class="py-2 px-12 bg-blue-400 text-white font-bold border rounded-lg block text-center mx-auto duration-300 hover:border-rose-600" type="button">Attaquer</button>

                </article>
            <?php } else { ?>

                <p class="text-center text-xl text-red-600 font-semibold absolute left-[50%] top-[50%] translate-x-[-50%] pt-32">Vous devez créer un personnage pour pouvoir jouer.</p>

            <?php } ?>

            <?php if ($player2 !== null) { ?>
                <article class="bg-slate-100 border rounded-lg p-4">
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

                    <hr class="my-3">

                    <h5 class="mx-auto text-center w-[100px] mb-4 text-lg border-b pb-1">Menu</h5>

                    <button class="py-2 px-12 bg-rose-600 text-white font-bold border rounded-lg block text-center mx-auto duration-300 hover:border-rose-600" type="button">Attaquer</button>
                </article>
            <?php } ?>
        </section>
    </main>

</body>

</html>