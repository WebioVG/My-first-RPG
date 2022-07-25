<?php

    require 'classes/Dirty.php';
    require 'config/helpers.php';

    $isNameRandom = (bool) post('isNameRandom');
    $name = $isNameRandom ? generateRandomName() : post('name');
    $class = post('class');
    $tribe = post('tribe');
    $success = false;

    if (isSubmit()) {
        $dirtyPlayer = new Dirty($name, $class, $tribe);
        $player = $dirtyPlayer->createNewCharacter();

        if ($player !== null) {
            $success = insert('INSERT INTO player (name, class, tribe, health, strength, mana) VALUES (:name, :class, :tribe, :health, :strength, :mana);', [
                'name' => $player->getName(),
                'class' => $player->getClass(),
                'tribe' => $player->getTribe(),
                'health' => $player->getHealth(),
                'strength' => $player->getStrength(),
                'mana' => $player->getMana()
            ]);
        } else {
            $errors = $dirtyPlayer->getErrors();
        }
    }

    function generateRandomName() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomName = '';

        for ($i = 0; $i < 10; $i++) {
            $randomName .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomName;
    }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <title>RPG</title>
</head>

<body class="max-w-[800px] mx-auto">
    
    <h1 class="my-12 text-center text-xl font-semibold">POO RPG</h1>

    <?php if (!empty($errors)) { ?>
        <div class="bg-red-200 rounded-lg border border-red-700 p-4 text-red-600 font-semibold">
            <?php foreach ($errors as $error) { ?>
                <p>* <?= $error ?></p>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if ($success) { ?>
        <div class="bg-emerald-200 rounded-lg border border-emerald-700 p-4 text-emerald-600 font-semibold">
            <p>Votre personnage a été initialisé !</p>
        </div>
    <?php } ?>

    <form action="" method="post" class="border p-4 rounded-xl mb-6">
        <input name="name" type="text" placeholder="Votre nom..." class="border w-full text-lg pl-4 rounded mb-2">

        <div class="mb-4">
            <input type="checkbox" name="isNameRandom">
            <p class="inline-block">Générer un nom aléatoire</p>
        </div>

        <div class="mb-4">
            <label for="tribe">Votre tribu ?</label>
            <select name="tribe" class="block w-full pl-2 border rounded text-lg">
                <option value="" required selected>Choisir</option>
                <option value="human">Humain</option>
                <option value="dwarf">Nain</option>
                <option value="elf">Elfe</option>
            </select>
        </div>

        <div class="mb-8">
            <label for="class">Votre classe ?</label>
            <div class="flex justify-between">
                <div class="w-[30%]">
                    <div class="mb-4">
                        <input type="radio" name="class" value="warrior">
                        <p class="inline">Guerrier</p>
                    </div>
                    <img class="object-cover w-[200px] h-[200px] mx-auto" src="img/auron.jpg" alt="un guerrier">
                </div>
                <div class="w-[30%]">
                    <div class="mb-4">
                        <input type="radio" name="class" value="mage">
                        <p class="inline">Mage</p>
                    </div>
                    <img class="object-cover w-[200px] h-[200px] mx-auto" src="img/lulu.jpg" alt="un mage">
                </div>
                <div class="w-[30%]">
                    <div class="mb-4">
                        <input type="radio" name="class" value="hunter">
                        <p class="inline">Chasseur</p>
                    </div>
                    <img class="object-cover w-[200px] h-[200px] mx-auto" src="img/wakka.jpg" alt="un chasseur">
                </div>
            </div>
        </div>

        <button class="bg-blue-400 inline-block py-2 px-4 rounded-lg text-white text-lg font-semibold duration-300 hover:scale-[1.1]">Créer</button>
    </form>

    <?php if (isset($player)) { ?>
        <section class="border p-4 rounded-xl mb-8">
            <h2 class="font-semibold text-lg">Bienvenue <span class="italic"><?= $player->getName() ?></span></h2>
            <?php switch($player->getClass()) {
                case 'warrior': ?>
                    <img class="my-4 object-cover w-[200px] h-[200px]" src="img/auron.jpg" alt="un guerrier">

                    <?php break;
                case 'mage': ?>
                    <img class="my-4 object-cover w-[200px] h-[200px]" src="img/lulu.jpg" alt="un mage">

                    <?php break;
                case 'hunter': ?>
                    <img class="my-4 object-cover w-[200px] h-[200px]" src="img/wakka.jpg" alt="un chasseur">

                    <?php break;
            } ?>
            <p>Tu es un <?= $player->getClass() ?> <?= $player->getTribe() ?>.</p>
            <ul class="my-2">
                <li class="pl-4">Ta santé : <?= $player->getHealth() ?></li>
                <li class="pl-4">Ta force : <?= $player->getStrength() ?></li>
                <li class="pl-4">Ton mana : <?= $player->getMana() ?></li>
            </ul>
            <a href="#" class="text-blue-500 duration-300 rounded inline-block hover:border hover:px-4">Je veux un autre personnage.</a>
        </section>
    <?php } ?>

</body>

</html>