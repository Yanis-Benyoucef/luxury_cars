<?php

require_once __DIR__ . '/Email.php';
require_once __DIR__ . '/EmailError.php';
require_once __DIR__ . '/SpamChecker.php';

class EmailsFile
{
    private array $emails;

    public function __construct(
        private string $emailsFilePath,
    ) {
        $this->emails = file($this->emailsFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    public function add(Email $email): void
    {
        if (in_array($email->getEmail(), $this->emails)) {
            throw new InvalidArgumentException(code: EmailError::DUPLICATE);
        }

        $emailsFile = fopen($this->emailsFilePath, 'a');
        fwrite($emailsFile, $email->getEmail() . PHP_EOL);
        fclose($emailsFile);
    }
}