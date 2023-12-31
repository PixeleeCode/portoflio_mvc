<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use PHPMailer\PHPMailer\PHPMailer;

class HomeController extends AbstractController
{
    /**
     * Page d'accueil
     */
    public function index(): void
    {
        $this->view('home/index.php');
    }

    /**
     * Détail d'un projet
     */
    public function details(): void
    {
        $projetRepository = new ProjetRepository();
        $project = $projetRepository->find($_GET['id']);

        // Erreur 404 ?
        if (!$project) {
            header('Location: /404');
            exit;
        }

        $this->view('home/details.php', [
            'project' => $project
        ]);
    }

    /**
     * Page de contact
     */
    public function contact(): void
    {
        $error = null;
        $success = null;

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
                    $phpmailer->Host = $_ENV['MAIL_SMTP'];
                    $phpmailer->SMTPAuth = true;
                    $phpmailer->Port = $_ENV['MAIL_PORT'];
                    $phpmailer->Username = $_ENV['MAIL_USER'];
                    $phpmailer->Password = $_ENV['MAIL_PASS'];

                    // Envoi du mail
                    $phpmailer->setFrom($email, $name); // Expéditeur
                    $phpmailer->addAddress($_ENV['USER_EMAIL'], $_ENV['USER_NAME']); // Destinataire
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
        $this->view('home/contact.php', [
            'error' => $error,
            'success' => $success
        ]);
    }
}
