/*
Fonction renvoyant un tableau d'objets correspondant au contenu d'un fichier CSV
donné sous la forme d'une chaîne de caractères `données`.
`données` contient une ligne d'en-têtes définissant les noms des champs (colonnes) dont
- le séparateur de lignes est `séparateur_lignes`
- le séparateur de colonnes est `séparateur_colonnes`.

Chaque objet du tableau représente une ligne de `données` (à l'exception de la ligne d'en-têtes)
et chacune de ses propriétés correspond au nom d'un champ et à sa valeur dans la ligne.
*/
export function parseCSV(données, séparateur_lignes, séparateur_colonnes) {
    const csv = [];

    // On commence par recuperer le tableau des lignes
    let lignes = données.split(séparateur_lignes)

    // On recupere le nom des colonnes
    let colonnes = lignes[0].split(séparateur_colonnes)
    
    for (let i = 1; i < lignes.length; i++) {
        // On recupere les infos de la ligne actuelle
        const dataLigne = lignes[i].split(séparateur_colonnes);
        
        // On cree un nouvel objet
        let newObject = {}

        // On itere sur ces infos pour remplire l'objet
        for (let j = 0; j < dataLigne.length; j++) {

            const valeur = dataLigne[j];
            const nomPropriete = colonnes[j];

            newObject[nomPropriete] = (!isNaN(valeur) && valeur !== "") ? parseInt(valeur) : valeur

        }
        
        // Maintenant qu'on a un objet on l'ajoute au tableau
        csv.push(newObject)
    }

    return csv;
};


/* 
Fonction renvoyant une promesse qui extrait par Fetch le contenu d'un fichier 
accessible à l'URL `url` et de format `format`.
`format` est l'une des chaînes :
- "xml" (fichier XML), 
- "json" (fichier JSON)
- "csv" (fichier CSV). 
*/
export const p_fetch = (url, format) =>
    fetch(url)
    .then(réponse => {
        if (!réponse.ok) {
            throw Error(`HTTP error, status = ${réponse.status}`);
        }

        switch (format) {
            case "xml":
            case "csv":
                return réponse.text();
                break;
            case "json":
                return réponse.json();
                break;
            default:
                throw Error(`Format de fichier incorrect = ${format}`);

        }

    })
    .catch(erreur => {
        console.log(erreur.message);
    });