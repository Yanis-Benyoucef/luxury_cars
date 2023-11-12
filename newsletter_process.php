<?php

require_once 'functions.php';
require_once 'functions/newsletter.php';
require_once 'classes/Utils.php';
require_once 'classes/Email.php';
require_once 'classes/EmailsFile.php';
require_once 'classes/Exception/EmptyEmailException.php';
require_once 'classes/Exception/InvalidEmailException.php';

// Return early pattern
// Situation désirée : la clé email est définie dans le tableau $_POST
// J'inverse donc cette condition
// et suis capable d'interrompre le script (ou rediriger, comme ici)
// beaucoup plus tôt
if (!isset($_POST['email'])) {
    Utils::redirect('newsletter.php');
}

// Si je me trouve ici, ça signifie que je n'ai pas redirigé
// Donc que j'ai bien une clé email dans $_POST
// 1 - Initialisations de variables
try {
    $email = new Email($_POST['email']);
    $spamChecker = new SpamChecker();
    if ($spamChecker->isSpam($email)) {
        throw new InvalidArgumentException(code: EmailError::SPAM);
    }
    $file  = new EmailsFile(__DIR__ . '/emails.txt');
    $file->add($email);
    Utils::redirect('subscription_confirm.php?email=' . $email->getEmail());
} catch (EmptyEmailException|InvalidEmailException $e) {
    // Envoi email à l'administrateur, puis redirection
    Utils::redirect("newsletter.php?error=" . $e->getCode());
} catch (InvalidArgumentException $e) {
    Utils::redirect("newsletter.php?error=" . $e->getCode());
}


