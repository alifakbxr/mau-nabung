-- Migration: 001_accounting_hardening.sql
-- Description: Implements Soft Deletes, Strict Constraints, and System Settings

START TRANSACTION;

-- 1. Create Settings Table
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL, -- Nullable for global settings, or specific user settings
  `key_name` varchar(50) NOT NULL,
  `value` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_setting` (`user_id`, `key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Add deleted_at to transactions (Soft Deletes)
-- Check if column exists is hard in standard SQL script without procedures, 
-- but we assume this is a standard migration run.
ALTER TABLE `transactions` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;

-- 3. Harden Constraints
-- First, drop existing SET NULL constraints if possible (names guessed from schema.sql)
ALTER TABLE `transactions` DROP FOREIGN KEY `fk_transactions_account`;
ALTER TABLE `transactions` DROP FOREIGN KEY `fk_transactions_related_account`;

-- Add RESTRICT constraints (Prevent deleting accounts with active transactions)
ALTER TABLE `transactions` 
ADD CONSTRAINT `fk_transactions_account_strict` 
FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE RESTRICT;

ALTER TABLE `transactions` 
ADD CONSTRAINT `fk_transactions_related_account_strict` 
FOREIGN KEY (`related_account_id`) REFERENCES `accounts` (`id`) ON DELETE RESTRICT;

COMMIT;
