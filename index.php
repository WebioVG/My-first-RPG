<?php

    require 'config/helpers.php';
    require 'classes/Character.php';
    require 'classes/DB.php';

    $inGameID = $_COOKIE['inGameID'] ?? null;
    $player = []; 

    if (isset($inGameID)) {
        $player = selectOne('SELECT * FROM player WHERE inGameID = '.$inGameID.';');
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

    <main class="pt-[12vh]">
        <h2 class="text-center text-3xl text-red-600 font-semibold py-8">Combat aléatoire</h2>

        <section class="max-w-[1000px] mx-auto grid grid-cols-2 gap-16">
            <?php if (isset($_COOKIE['inGameID'])) { ?>
                <article class="bg-slate-100 border rounded-lg p-4">
                    <h2 class="text-center text-lg text-rose-600 font-semibold mb-4 italic">Votre personnage</h2>
                    <h3 class="text-center text-xl font-semibold mb-4 underline"><?= $player['name'] ?></h3>

                    <?php switch ($player['class']) {
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
                    
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">ID : </span><span class="italic"><?= $player['inGameID'] ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Classe : </span><span class="italic"><?= $player['class'] ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Tribu : </span><span class="italic"><?= $player['tribe'] ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Vie : </span><span class="italic"><?= $player['health'] ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Mana : </span><span class="italic"><?= $player['mana'] ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Force : </span><span class="italic"><?= $player['strength'] ?></span></p>
                    <p class="mb-1"><span class="font-semibold inline-block w-[35%]">Puissance : </span><span class="italic"><?= $player['power'] ?></span></p>

                    <hr class="my-3">

                    <h5 class="mx-auto text-center w-[100px] mb-4 text-lg border-b pb-1">Menu</h5>

                    <button class="py-2 px-12 bg-blue-300 text-white font-bold border rounded-lg block text-center mx-auto duration-300 hover:border-rose-600" type="button">Attaquer</button>

                </article>
            <?php } ?>
        </section>
    </main>

</body>

</html>