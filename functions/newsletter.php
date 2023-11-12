<?php

const EMAIL_EMPTY     = 1;
const EMAIL_INVALID   = 2;
const EMAIL_DUPLICATE = 3;
const EMAIL_SPAM      = 4;

function getErrorMessage(int $errorCode): string
{
    return match ($errorCode) {
        EMAIL_EMPTY => "L'email est obligatoire",
        EMAIL_INVALID => "Le format de l'email est incorrect",
        EMAIL_DUPLICATE => "L'email existe déjà dans la newsletter",
        EMAIL_SPAM => "Désolé, cet email n'est pas accepté dans notre newsletter",
        default => "Une erreur est survenue"
    };
}

function registerEmail(string $emailsFilePath, string $email): void
{
    $emailsFile = fopen($emailsFilePath, 'a');
    fwrite($emailsFile, $email . PHP_EOL);
    fclose($emailsFile);
}

function getTotalEmails(): int
{
    $emails = file(__DIR__ . '/../emails.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return count($emails);
}

// Florian

// const ERROR_MESSAGES = [
//   'is_empty'       => "L'email est obligatoire",
//   'invalid_format' => "Le format de l'email est incorrect",
//   'duplicate'      => "L'email existe déjà dans la newsletter",
//   'is_spam'        => "Désolé, cet email n'est pas accepté dans notre newsletter"
// ];

// function getErrorMessage(string $errorCode): string
// {
//     return ERROR_MESSAGES[$errorCode] ?? "Une erreur est survenue";
// }