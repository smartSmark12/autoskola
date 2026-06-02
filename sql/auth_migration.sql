-- Migrace: přihlašování uživatelů (žáci i instruktoři)
-- Přidá sloupec `heslo` (hash z password_hash) a unikátní email do obou tabulek.
-- Email slouží jako přihlašovací jméno, role je dána tabulkou.
-- Hesla existujícím záznamům nastav skriptem: php sql/seed_passwords.php

ALTER TABLE `studenti`
  ADD COLUMN `heslo` VARCHAR(255) NULL AFTER `email`;

ALTER TABLE `instruktori`
  ADD COLUMN `heslo` VARCHAR(255) NULL AFTER `email`;

-- Email musí být unikátní, aby šel použít jako login.
ALTER TABLE `studenti`
  ADD UNIQUE KEY `uniq_student_email` (`email`);

ALTER TABLE `instruktori`
  ADD UNIQUE KEY `uniq_instruktor_email` (`email`);
