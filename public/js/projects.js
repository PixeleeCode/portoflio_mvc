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
                article.querySelector('a').href = `/projet/details?id=${project.id}`

                document.querySelector('#listing-projects').appendChild(article)
            })
        }, 5000)
    })
    .catch(error => console.error(error))
