import {
    p_fetch
}
    from "./utils.js";

import {
    p_régions
}
    from "./régions.js";

/* 
Fichier XML listant les départements français.
Définition des balises :
    https://www.insee.fr/fr/information/3363419#titre-bloc-23
*/
const url = "./data/départements.xml";

/* 
Promesse construite à partir des 2 promesses extrayant
- le contenu du fichier XML accessible à l'URL `url` en utilisant `p_fetch` (voir import),
- les régions du fichier CSV (voir `p_régions` dans l'import).

Les promesses sont résolues en parallèle.
Si elles sont toutes deux tenues, la réponse est un objet dont les propriétés sont 
des objets correspondant aux éléments `département` du document XML.
La clé d'une propriété est la chaîne correspondant au code du département (p. ex. 
"2A", "49").
Chaque objet a les propriétés suivantes
- "nom" : contenu du sous-élément NCCENR (chaîne)
- "chef_lieu" : contenu du sous-élément CHEFLIEU (entier)
- "région" : nom de la région du département (chaîne).
*/
export const p_départements =
    Promise.all([p_régions, p_fetch(url, 'xml')])
        .then(reponses => {

            // Objet a retourner
            let resultat = {}

            let donneesXML = reponses[1]

            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(donneesXML, "text/xml");
            const departementsXML = xmlDoc.querySelectorAll("département");

            // Maintenant qu'on a les données de chaque departement
            departementsXML.forEach(element => {

                // On recupere le nom, cheflieu, region dans l'objet
                let newObject = {
                    nom: element.children[5].textContent,
                    chef_lieu: parseInt(element.children[2].textContent),
                    région: element.children[5].textContent
                }

                // On ajoute ce nouvel objet en tant que propriété
                resultat[element.children[1].textContent] = newObject
            });

            return resultat;
        })
