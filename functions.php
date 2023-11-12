<?php

const FIRSTNAME_THEN_NAME = 0;
const NAME_THEN_FIRSTNAME = 1;

/**
 * Returns the full name of a given member
 *
 * @param array $member associative array with `name` and `firstname` keys
 * @return string Full name, format : `name firstname`
 */
function getFullName(array $member, int $order = NAME_THEN_FIRSTNAME): string
{
    if ($order === FIRSTNAME_THEN_NAME) {
        return $member['firstname'] . ' ' . $member['name'];
    }

    return $member['name'] . ' ' . $member['firstname'];
}

function findAbility(array $abilities, int $id): ?array
{
    $ability = null;

    foreach ($abilities as $element) {
        if ($element['id'] === $id) {
            $ability = $element;
            break;
        }
    }

    return $ability;
}