/**
 * Affichage des projets sur la page d'accueil
 */
fetch('/api/all/projects')
    .then(response => response.json())
    .then(projects => {
        // Exécute le code dans X millisecondes
        setTimeout(() => {
            // Masquer le loader
            document.querySelector('#loader').classList.add('d-none')

            projects.forEach(project => {
                createCard(project)
            })
        }, 2000)
    })
    .catch(error => console.error(error))

/**
 * Récupère les détails d'un projet
 */
function readProject(idProject)
{
    fetch(`/api/project?id=${idProject}`)
        .then(response => response.json())
        .then(project => {

            // Erreur 404
            if (project.code && project.code === 404) {
                // Redirection vers la page 404
                document.location.href = '/404'
            }

            // Modifie le titre du H1 de la page
            document.querySelector('h1').textContent = 'Mon projet'

            // Supprime la div "alerte" d'un utilisateur connecté
            document.querySelector('.alert-success').remove()

            // Créer la fiche du produit
            createCard(project, true)

            // Modifie l'URL du navigateur
            history.replaceState('', '', `/projet/details?id=${idProject}`)
        })
        .catch(error => console.log(error))
}

/**
 * Création des cartes pour un projet
 */
function createCard(project, onlyOneProject = false)
{
    const container = document.querySelector('#listing-projects')

    /**
     * S'il s'agit d'un seul projet pour les infos,
     * vide le contenu de la div affichant tous les projets
     */
    if (onlyOneProject) {
        // Permet de vider le contenu d'un élément HTML
        container.textContent = ''
    }

    const template = document.querySelector('#project').content
    const article = document.importNode(template, true)

    // Gère le format date
    const date = new Date(project.createdAt)

    article.querySelector('h1').textContent = project.title
    article.querySelector('small').textContent = `Posté le ${date.toLocaleDateString('fr')}`
    article.querySelector('img').src = project.folderPreview
    article.querySelector('img').alt = project.title

    // S'il s'agit d'un seul projet, on retire le bouton "En savoir plus..."
    if (onlyOneProject) {
        article.querySelector('p').textContent = project.description
        article.querySelector('button').remove()
    } else {
        article.querySelector('p').textContent = `${project.description.slice(0, 75)}...`
        // Appel une fonction pour récupérer les infos du projet
        article.querySelector('button').addEventListener('click', () => {
            readProject(project.id)
        })
    }

    document.querySelector('#listing-projects').appendChild(article)
}
