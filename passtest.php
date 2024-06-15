<?php
// $userPass = "Tinu5@12345"; // User's entered password
$userPass = "Bard@123456"; // User's entered password

// $hashPass = '$2y$10$1Hqwk.RwxnAksw677XZFDudYs7mwZqflSigmK3lDOsmQNiD8MTs.W'; // Stored password hash
// $hashPass = '$2y$10$sNwI4qpwBIi4K3UvWs46wO2RUcs227nuHWpd7A.t9ytflz44sDp2m'; // Stored password hash
$hashPass = '$2y$10$8tfArLkeZCR0v/iQvd9Dv.dE0lApcBROSdVeBhwu8j/0fZStg/Usi'; // Stored password hash

// Use password_verify() to securely compare the hashes
if (password_verify($userPass, $hashPass)) {
    echo "The passwords match."; // True
} else {
    echo "The passwords do not match."; // False
}
//Tinu5@12345
?>
