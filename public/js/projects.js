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
        }, 50)
    })
    .catch(error => console.error(error))

/**
 * Moteur de recherche
 * Ecouteur d'évènement réagissant au changement dans le champ texte
 */
document.querySelector('#search').addEventListener('input', function() {
    const searchTerm = this.value

    fetch(`/api/search?query=${searchTerm}`)
        .then(response => response.json())
        .then(projects => {
            // Vider la liste des projets sur l'accueil
            document.querySelector('#listing-projects').textContent = ''

            // Affiche les projets correspondant à ma recherche
            projects.forEach(project => {
                createCard(project)
            })
        })
        .catch(error => console.error(error))
})

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

            // Videz l'affichage actuel
            document.querySelector('#listing-projects').textContent = '';

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
    const template = document.querySelector('#project').content
    const article = document.importNode(template, true)

    // Gère le format date
    const date = new Date(project.createdAt)

    article.querySelector('article').id = `project-id-${project.id}`
    article.querySelector('h1').textContent = project.title
    article.querySelector('small').textContent = `Posté le ${date.toLocaleDateString('fr')}`
    article.querySelector('img').src = project.folderPreview
    article.querySelector('img').alt = project.title

    // Bouton Love
    const btnLove = article.querySelector('.btn-danger')
    if (btnLove) {
        article.querySelector('.btn-danger').addEventListener('click', () => {
            isLove(project.id, article)
        })
    }

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

function isLove(idProject)
{
    fetch(`/api/love?id=${idProject}`)
        .then(response => response.json())
        .then(() => {
            const article = document.querySelector(`article#project-id-${idProject}`)
            article.querySelector('.btn-danger').textContent = 'Déjà aimé'
            article.querySelector('.btn-danger').disabled = true
        })
        .catch(error => console.error(error))
}
