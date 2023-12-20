<?php

use PHPMailer\PHPMailer\PHPMailer;

class HomeController
{
    /**
     * Page d'accueil
     */
    public function index(): void
    {
        require_once '../templates/home/index.php';
    }

    /**
     * Page de contact
     */
    public function contact(): void
    {
        // Si une méthode POST est reçue
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage des données
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $email = htmlspecialchars(strip_tags($_POST['email']));
            $message = htmlspecialchars(strip_tags($_POST['message']));

            // Vérifie si tous les champs sont remplis
            if (!empty($name) && !empty($email) && !empty($message)) {

                // Vérifie si le mail est valide
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    // Envoi de l'email avec PHPMailer
                    // Connecter au SMTP de MailTrap
                    $phpmailer = new PHPMailer();
                    $phpmailer->isSMTP();
                    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                    $phpmailer->SMTPAuth = true;
                    $phpmailer->Port = 2525;
                    $phpmailer->Username = '<Identifiant>';
                    $phpmailer->Password = '<Mot de passe>';

                    // Envoi du mail
                    $phpmailer->setFrom($email, $name); // Expéditeur
                    $phpmailer->addAddress('guillaume@demo.com', 'Guillaume'); // Destinataire
                    $phpmailer->Subject = 'Message du formulaire de contact';
                    $phpmailer->Body = $message;

                    // Envoyer le mail
                    if ($phpmailer->send()) {
                        $success = 'Votre message a bien été envoyé !';
                    } else {
                        // $error = "Votre message n'a pu être envoyé. Veuillez ré-essayer !";
                        $error = $phpmailer->ErrorInfo;
                    }
                } else {
                    $error = 'Votre adresse email est invalide';
                }
            } else {
                $error = 'Veuillez remplir tous les champs';
            }
        }

        // Affichage du template
        require_once '../templates/home/contact.php';
    }
}
