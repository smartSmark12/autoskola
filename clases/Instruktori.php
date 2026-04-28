<?php

class Instruktori {

    private $id;
    private $jmeno;
    private $prijmeni;
    private $telefon;
    private $email;
    private $aktivni;

    function nastavHodnoty($id = null, $jmeno = '', $prijmeni = '', $telefon = '', $email = '', $aktivni = true){
        if (!($id === null || filter_var($id, FILTER_VALIDATE_INT) !== false)) {
            return false;
        }
        $this->id = $id;

        if (!is_string($jmeno) || trim($jmeno) === '' || mb_strlen($jmeno) > 50) {
            return false;
        }
        if (!is_string($prijmeni) || trim($prijmeni) === '' || mb_strlen($prijmeni) > 50) {
            return false;
        }
        $this->jmeno = trim($jmeno);
        $this->prijmeni = trim($prijmeni);

        // český formát: volitelně +420 / 420, pak 9 číslic (mezery povolené)
        $pattern = '/^(\\+420\\s?|420\\s?)?\\d{3}\\s?\\d{3}\\s?\\d{3}$/';
        if ($telefon !== null && $telefon !== '' && !preg_match($pattern, $telefon)) {
            return false;
        }
        $this->telefon = ($telefon === '') ? null : $telefon;

        if ($email !== null && $email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if ($email !== null && mb_strlen($email) > 100) {
            return false;
        }
        $this->email = ($email === '') ? null : $email;

        if (is_bool($aktivni)) {
            $this->aktivni = $aktivni;
        } elseif ($aktivni === 0 || $aktivni === 1 || $aktivni === '0' || $aktivni === '1') {
            $this->aktivni = (bool)(int)$aktivni;
        } else {
            return false;
        }

        return true;
    }

    function vypis(){
        echo '<article class="display-card">';
        echo '<p><strong>ID:</strong> ' . htmlspecialchars((string)$this->id) . '</p>';
        echo '<p><strong>Jméno:</strong> ' . htmlspecialchars((string)$this->jmeno) . '</p>';
        echo '<p><strong>Příjmení:</strong> ' . htmlspecialchars((string)$this->prijmeni) . '</p>';
        echo '<p><strong>Telefon:</strong> ' . htmlspecialchars((string)($this->telefon ?? '')) . '</p>';
        echo '<p><strong>Email:</strong> ' . htmlspecialchars((string)($this->email ?? '')) . '</p>';
        echo '<p><strong>Aktivní:</strong> ' . ($this->aktivni ? 'Ano' : 'Ne') . '</p>';
        echo '</article>';
    }

    function vypisSOdkazy(){
        echo '<article class="display-card">';
        echo '<p><strong>ID:</strong> ' . htmlspecialchars((string)$this->id) . '</p>';
        echo '<p><strong>Jméno:</strong> ' . htmlspecialchars((string)$this->jmeno) . '</p>';
        echo '<p><strong>Příjmení:</strong> ' . htmlspecialchars((string)$this->prijmeni) . '</p>';
        echo '<p><strong>Telefon:</strong> ' . htmlspecialchars((string)($this->telefon ?? '')) . '</p>';
        echo '<p><strong>Email:</strong> ' . htmlspecialchars((string)($this->email ?? '')) . '</p>';
        echo '<p><strong>Aktivní:</strong> ' . ($this->aktivni ? 'Ano' : 'Ne') . '</p>';
        echo '<p class="card-actions">';
        echo '<a href="../forms_edit/form-instruktor.php?id=' . urlencode((string)$this->id) . '">Editovat</a> | ';
        echo '<a href="../forms_remove/form-instruktori.php?id=' . urlencode((string)$this->id) . '">Smazat</a>';
        echo '</p>';
        echo '</article>';
    }

    function vypisOptions(){
        echo '<option value="' . htmlspecialchars((string)$this->id) . '">'
           . htmlspecialchars($this->prijmeni . ' ' . $this->jmeno)
           . '</option>';
    }

    public function getId() { return $this->id; }
    public function getJmeno() { return $this->jmeno; }
    public function getPrijmeni() { return $this->prijmeni; }
    public function getTelefon() { return $this->telefon; }
    public function getEmail() { return $this->email; }
    public function getAktivni() { return $this->aktivni; }

}
?>
