<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Vérification des données
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit
        http_response_code(400);
        echo "Veuillez remplir correctement tous les champs.";
        exit;
    }

    // Envoi de l'email
    $recipient = "amaury.lefevre@outlook.fr"; // Remplacez par votre adresse email
    $subject = "Nouveau message de $name";
    $email_content = "Nom: $name\n";
    $email_content .= "Message:\n$message\n";
    $email_header = "From: $name <$email>";

    if (mail($recipient, $subject, $email_content, $email_header)) {
        // Set a 200 (okay) response code
        http_response_code(200);
        echo "Votre message a bien été envoyé.";
    } else {
        // Set a 500 (internal server error) response code
        http_response_code(500);
        echo "Oups! Il y a eu une erreur.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code
    http_response_code(403);
    echo "Il y a eu une erreur.";
}


