<?php 

require_once __DIR__ . '/../classes/AppError.php'; 

function getErrorMessage(int $errorCode): string
{
    return match ($errorCode) {
        AppError::DB_CONNECTION => "Erreur lors de la connexion à la base de données",
        AppError::AUTH_REQUIRED_FIELDS => 'Champs requis pour l\'authentification manquants',
        AppError::REQUIRED_FIELDS => 'Tous les champs sont obligatoires.',
        AppError::INVALID_CREDENTIALS => 'Mot de passe incorrect',
        AppError::USER_NOT_FOUND => "Utilisateur non trouvé",
        AppError::EMAIL_DUPLICATE => "L'email existe déjà dans la newsletter",
        AppError::PASSWORD_NOT_MATCH => 'Les mots de passe ne correspondent pas',
        AppError::FORMAT_NOT_CORRECT => 'Le format n\'est pas correct',
        AppError::REVIEW_SUBMITTED => 'Avis soumis avec succès',
        AppError::MISSING_DATA => 'Données manquantes',
        AppError::AUTH_REQUIRED => 'Authentification requise',
        AppError::FILE_UPLOAD_ERROR => 'Erreur de l upload du fichier',
        default => "Une erreur est survenue",
    };
}
