<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Portfolio</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="css/loader.css" rel="stylesheet">
        <script src="js/projects.js" defer></script>
    </head>
    <body>
        <div class="container mx-auto p-5">
            <div class="row">
                <div class="col-8">
                    <h1 class="pb-5">Mes beaux projets 🤩</h1>
                </div>
                <div class="col-4">
                    <input type="search" id="search" class="form-control mt-2" placeholder="Rechercher...">
                </div>
            </div>

            <!-- Affiche un message si l'utilisateur est connecté -->
            <?php if($isLoggedIn): ?>
                <div class="alert alert-success">
                    Bonjour <?php echo $_SESSION['user']->getUsername(); ?> !
                </div>
            <?php endif; ?>

            <div id="loader" class="text-center my-5">
                <span class="cat d-block mb-2">
                    <span class="cat__body"></span>
                    <span class="cat__body"></span>
                    <span class="cat__tail"></span>
                    <span class="cat__head"></span>
                </span>
                <strong>Chat</strong>rgement des projets...
            </div>

            <!-- Liste de tous les projets -->
            <div id="listing-projects"></div>
        </div>

        <!-- Template pour afficher mes projets -->
        <template id="project">
            <article class="pb-5">
                <h1></h1>
                <small class="d-block text-secondary pb-2"></small>
                <img src="" alt="" class="img-fluid rounded">
                <p></p>
                <button type="button" class="btn btn-sm btn-primary">
                    En savoir plus...
                </button>
                <?php if($isLoggedIn): ?>
                    <button type="button" class="btn btn-sm btn-danger">
                        J'aime
                    </button>
                <?php endif ?>
            </article>
        </template>
    </body>
</html>
