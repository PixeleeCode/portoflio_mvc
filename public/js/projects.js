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
                const template = document.querySelector('#project').content
                const article = document.importNode(template, true)

                // Gère le format date
                const date = new Date(project.createdAt)

                article.querySelector('h1').textContent = project.title
                article.querySelector('small').textContent = `Posté le ${date.toLocaleDateString('fr')}`
                article.querySelector('img').src = project.folderPreview
                article.querySelector('img').alt = project.title
                article.querySelector('p').textContent = `${project.description.slice(0, 75)}...`
                article.querySelector('button').addEventListener('click', () => {
                    // Appel une fonction pour récupérer les infos du projet
                    readProject(project.id)
                })

                document.querySelector('#listing-projects').appendChild(article)
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
            const container = document.querySelector('#listing-projects')

            // Permet de vider le contenu d'un élément HTML
            container.textContent = ''

            // Modifie le titre du H1 de la page
            document.querySelector('h1').textContent = 'Mon projet'

            // Supprime la div "alerte" d'un utilisateur connecté
            document.querySelector('.alert-success').remove()

            const template = document.querySelector('#project').content
            const article = document.importNode(template, true)

            // Gère le format date
            const date = new Date(project.createdAt)

            article.querySelector('h1').textContent = project.title
            article.querySelector('small').textContent = `Posté le ${date.toLocaleDateString('fr')}`
            article.querySelector('img').src = project.folderPreview
            article.querySelector('img').alt = project.title
            article.querySelector('p').textContent = project.description
            article.querySelector('button').remove()

            container.appendChild(article)

            // Modifie l'URL du navigateur
            history.replaceState('', '', `/projet/details?id=${idProject}`)
        })
        .catch(error => console.log(error))
}
