<?php

require 'db.php';

session_start();

/**
 * Permet de récupèrer facilement un champ en POST
 */
function post($field) {
    return sanitize($_POST[$field] ?? null);
}

/**
 * Permet de nettoyer une valeur
 */
function sanitize($value) {
    return trim(htmlspecialchars($value));
}

/**
 * Permet de vérifier si un formulaire est soumis.
 */
function isSubmit() {
    return !empty($_POST);
}

/**
 * Permet de récupèrer l'utilisateur dans la session.
 */
function user() {
    return $_SESSION['user'] ?? null;
}

/**
 * Permet d'afficher le jour actuel en français.
 */
function day() {
    return str_replace(
        ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
        date('l')
    );
}

/**
 * Permet de faire un insert en SQL.
 */
function insert($sql, $bindings = []) {
    global $db;

    return $db->prepare($sql)->execute($bindings);
}

/**
 * Permet de faire un select en SQL (fetch).
 */
function selectOne($sql, $bindings = []) {
    global $db;

    $query = $db->prepare($sql);
    $query->execute($bindings);

    return $query->fetch();
}

/**
 * Permet de faire un select all en SQL (fetchAll).
 */
function selectAll($sql, $bindings = []) {
    global $db;

    $query = $db->prepare($sql);
    $query->execute($bindings);

    return $query->fetchAll();
}
