let puzzle = null;

fetch('puzzle.json', {
    method: 'GET'
})
    .then((response) => response.json())
    .then((puzzles) => {
        // Extraction du premier puzzle et construction du générateur
        console.log('Success:', puzzles);
        puzzle = puzzles[0];
        let generator = new PuzzleGenerator(puzzle);

        // Q1.1 Injection de l'auteur
        // On modifie le premier p pour qu'il affiche a la fin un lien vers la page wikipedia de l'auteur
        document.querySelector("p:nth-child(1)").innerHTML += "<a href=\"" + puzzle['url'] + "\">" + puzzle['auteur'] + "</a>"

        // Q1.2 Injection des images
        // On boucle pour chercher toutes les images
        puzzle['images'].forEach(image => {
            // On cree notre objet request
            let maRequete = new Request("img/" + image['src']);

            // On la fetch
            fetch(maRequete)
                .then(function (reponse) {
                    // On check si la reponse est bonne
                    if (reponse.ok) {
                        // On retourne le blob de notre reponse
                        return reponse.blob()
                    } else {
                        // Si la reponse n'est pas bonne alors on affiche son code d'erreur
                        console.log("status de la requete = " + reponse.status)
                    }
                })
                .then(function (reponse) {
                    // Enfin si le blob a été envoyé alors on cree notre objet URL
                    let URLdobjet = URL.createObjectURL(reponse);

                    // Maintenant dans le div d'images on insere nos images
                    let newImage = document.createElement("img")
                    newImage.src = URLdobjet;
                    newImage.style.width = "30px"
                    newImage.style.height = "50px"

                    document.getElementById("images").appendChild(newImage)
                });

        });

        // Q1.3 Injection de l'énoncé
        // On recupere le h3 contenant l'enoncé et on y met l'enonce
        document.querySelector("div>h3").textContent = puzzle["énoncé"]

        // Injection des en-têtes du tableau (ne pas faire cette question)
        generator.insertTableHeaders();

        // Q1.4 Injection des indices
        // On declare un i pour gere les id a mettre dans les checkbox
        let i = 1

        // On ittere sur les indice pour creer chaque checkbox
        puzzle['indices'].forEach((indice) => {

            // On cree le label de l'indice actuel
            let newLabel = document.createElement("label")
            newLabel.innerText = indice

            // On cree le checkbox avec toutes ses options a l'interieur
            let newInput = document.createElement("input")
            newInput.type = "checkbox"
            newInput.name = "indices[]"
            newInput.id = "indice" + i
            newInput.value = newInput.id

            // On cree un li et lui place le checkbox et le label
            let newLi = document.createElement("li")
            newLi.appendChild(newInput)
            newLi.appendChild(newLabel)

            // On place tout ça dans le ol
            document.querySelector("ol").appendChild(newLi)

            // On incremente i pour l'indice suivant
            i++
        })

        // Q1.5 Injection des menus déroulants

        // On recupere les rows de la table
        let rows = document.querySelector("div fieldset table").rows

        // On remplit la premiere ligne
        for (let i = 0; i < rows[0].cells.length; i++)
            rows[0].cells[i].innerText = puzzle['facettes'][i]['nom']

        // On ittere sur les rows et cells de la table
        for (let i = 1; i < rows.length; i++) {
            const row = Array.from(rows)[i];
            // Pour chaque ligne:

            // On remplit la premiere case avec le nom de l'athlete (i-1 car 1ere ligne traitée en dehors de cette boucle)
            let nomAthlete = puzzle['facettes'][0]['valeurs'][i - 1]
            row.cells[0].innerText = nomAthlete

            // On s'occupe ensuite des cases restantes sur chaque lignes (les selects)
            for (let index = 1; index < row.cells.length; index++) {

                // On cree le select
                let newSelect = document.createElement("select")

                // On lui met l'att name a athlete_nomColonne
                newSelect.name = nomAthlete + "_" + puzzle['facettes'][index]['nom']

                // On place le select dans la cellule
                row.cells[index].appendChild(newSelect)

                // Et pour les options

                // On commence deja par mettre l'option vide
                let optionVide=document.createElement("option")
                optionVide.value='vide'
                newSelect.add(optionVide)

                // Ensuite on met les autres options
                for (let j = 0; j < puzzle['facettes'][index]['valeurs'].length; j++) {
                    const valeurOption = puzzle['facettes'][index]['valeurs'][j];

                    let newOption = document.createElement("option")
                    newOption.text = valeurOption;
                    newOption.value = valeurOption;

                    newSelect.add(newOption)
                }
            }
        }

        // Q2.1 Clic sur cellules
        document.querySelectorAll("div#aide table td").forEach((cell) =>{
            cell.addEventListener('click', (e) => {
                if(e.target.innerText === ""){
                    // Si la case est vide alors on met un X sur fond rouge
                    e.target.innerText = "X"
                    e.target.style.backgroundColor = "red"
                } else if (e.target.innerText === "X") {
                    // Si la case a un X alors on met un 0 sur fond vert
                    e.target.innerText = "O"
                    e.target.style.backgroundColor = "green"
                } else if (e.target.innerText === "O"){
                    // Si la case a un 0 alors on remet tout a 0
                    e.target.innerText = ""
                    e.target.style.backgroundColor = ""
                }
            })
        })

        // Q2.2 Cochage des indices
        document.querySelectorAll("input[type=\"checkbox\"]").forEach((indice) => {
            indice.addEventListener('change', (e) => {
                // On inverse le text-deco du nextSibling du checkbox (le label)
                if (e.target.nextSibling.style.textDecoration === "line-through")
                    e.target.nextSibling.style.textDecoration = ""
                else
                    e.target.nextSibling.style.textDecoration = "line-through"
            })
        })

        // Q3 Gestion du formulaire
        // On commence par mettre un ecouteurs sur le boutton submit
        document.querySelector("input[type=\"submit\"]").addEventListener('click', (e)=>{
            // On empeche l'envoi du formulaire
            e.preventDefault()

            // On init un URLSearchParameters
            let searchParams = new URLSearchParams()

            // On lui ajoute tout nos parametres (les values des select)
            document.querySelectorAll("select").forEach( (select) => {
                //? Faut-il gerer le value=vide
                searchParams.append(select.name, select.value)
            })

            // Ensuite on soummet la requete
            fetch("puzzle.php", {
                method:'POST',
                body: searchParams
            })
            .then((response)=>response.json())
            .then((infos) => {
                // Maintenant qu'on a une reponse on s'occupe de la coloration
                Object.entries(infos.réponse).forEach(element => {
                    let id = element[0]
                    let reponseCorrecte = element[1]
                    
                    // On va donc colorier le select correspondant a l'id en question
                    document.querySelector("select[name=\""+id+"\"]").style.backgroundColor = ((reponseCorrecte == 0) ? "red" : "green")

                });

                // Ensuite on s'occupe d'afficher l'alerte si le formulaire est tout bon
                if (infos["résolution"] === 1) {
                    alert("BRAVO: enigme resolue!")
                }
            })

        })

        return puzzle;
    })
    .catch((error) => {
        console.error('Error:', error);
    });



// Q4 Minuteur
let pMinuteur = document.querySelector("#minuteur")
let startTime = (new Date()).getTime()

setInterval(() => {
    let currentTime = (new Date()).getTime()

    // En gros On prends nos 5Minutes totales et on soustrait le temps passé qu'on convertit en secondes(tempsCourant-tempsDebut)
    let TempsRestant = 5*60 - (currentTime - startTime)/1000
    
    if (TempsRestant <= 0)
        document.body.innerText = "C'est fini"
    else
        pMinuteur.innerText = "Encore "+Math.round(TempsRestant)+"s"

}, 1000);
