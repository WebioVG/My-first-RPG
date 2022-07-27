<?php

    require 'config/autoload.php';

    $players = Character::all() ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <title>RPG - Liste des joueurs</title>
</head>

<body>

    <?php require 'partials/header.php'; ?>

    <main class="my-[12vh]">

        <h1 class="py-12 text-center text-2xl font-semibold">Liste des joueurs</h1>

        <?php if (!empty($players)) { ?>
            <section class=" w-[1000px] mx-auto grid grid-cols-3 gap-4">
                <?php foreach($players as $player) { ?>
                    <article class="bg-slate-100 border rounded-lg p-4">
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

                        <p class="mb-1"><span class="text-lg font-semibold inline-block w-[35%]">ID : </span><span class="italic"><?= $player['inGameID'] ?></span></p>
                        <p class="mb-1"><span class="text-lg font-semibold inline-block w-[35%]">Classe : </span><span class="italic"><?= $player['class'] ?></span></p>
                        <p class="mb-1"><span class="text-lg font-semibold inline-block w-[35%]">Tribu : </span><span class="italic"><?= $player['tribe'] ?></span></p>
                        <p class="mb-1"><span class="text-lg font-semibold inline-block w-[35%]">Vie : </span><span class="italic"><?= $player['health'] ?></span></p>
                        <p class="mb-1"><span class="text-lg font-semibold inline-block w-[35%]">Mana : </span><span class="italic"><?= $player['mana'] ?></span></p>
                        <p class="mb-1"><span class="text-lg font-semibold inline-block w-[35%]">Force : </span><span class="italic"><?= $player['strength'] ?></span></p>
                        <p class="mb-1"><span class="text-lg font-semibold inline-block w-[35%]">Puissance : </span><span class="italic"><?= $player['power'] ?></span></p>
                    </article>
                <?php } ?>
            </section>
        <?php } ?>
    </main>

    
</body>

</html>