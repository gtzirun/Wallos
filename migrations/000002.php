<?php
// This migration adds an "enabled" column to the payment_methods table and sets all values to 1.
// It allows the user to disable payment methods without deleting them.

/** @noinspection PhpUndefinedVariableInspection */
// Query to get the table information
$tableInfoQuery = $db->query("PRAGMA table_info(payment_methods)");

$columnRequired = true;
while ($column = $tableInfoQuery->fetchArray(SQLITE3_ASSOC)) {
    if ($column['name'] == 'enabled') {
        // If the 'enabled' column exists, no need to add it
        $columnRequired = false;
        break;
    }
}

if ($columnRequired) {
    $db->exec('ALTER TABLE payment_methods ADD COLUMN enabled BOOLEAN DEFAULT 1');
    $db->exec('UPDATE payment_methods SET enabled = 1');
}
