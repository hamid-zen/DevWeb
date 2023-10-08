import {
    parseCSV,
    p_fetch
}
from "./utils.js";

/* 
Fichier CSV listant les régions françaises.
Définition des champs :
    https://www.insee.fr/fr/information/3363419#titre-bloc-26
*/
const url = "./data/régions.csv";

/* 
Promesse extrayant par Fetch le contenu du fichier CSV accessible à l'URL `url` 
et le renvoyant sous la forme d'un tableau d'objets représentant les régions.
Chaque objet a les propriétés suivantes :
- "code" : le numéro de la région (entier)
- "nom" : le nom de la région (chaîne).
Les objets sont triés dans l'ordre croissant des numéros de régions.
*/
export const p_régions =
    p_fetch(url, 'csv').then( donnes => {
        // On recupre le tableau d'objets
        let tableauObj = parseCSV(donnes, "\n", ";")

        // On cree le nouveau tableau avec les bonne proprietes
        let resultat = []
        tableauObj.forEach(objet => {
            
            let newObject = {
                code: objet.REGION,
                nom: objet.NCC
            }

            resultat.push(newObject)
        });

        // On trie selon le numero de region
        return resultat.sort((a,b) => a-b);
    })

