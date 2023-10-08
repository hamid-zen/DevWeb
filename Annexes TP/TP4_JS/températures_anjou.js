import {
    p_températures_départementales
}
from "./températures_départementales.js";

/* 
Promesse produisant les températures minimales/moyennes/maximales mensuelles en 2022
dans le département 49 à partir de la réponse de la promesse `p_températures_départementales` (voir import).
La réponse est un tableau d'objets.
A chacun des 12 mois de 2022 correspond 3 objets dans ce tableau : 
- un pour la température minimale, 
- un pour la température maximale et
- un pour la température moyenne.

Chaque objet à 4 propriétés :
    -- "date" : un objet Date correspondant au 1er jour du mois
    -- "mois" : le nom du mois en français
    -- "température" : un flottant représentant une température
    -- "classe" : l'une des chaînes "Minimales", "Maximales", "Moyennes"

La température minimale (resp. maximale) d'un mois donné sera le minimum (resp. maximum) 
des températures minimales (resp. maximales) quotidiennes relevées pour ce mois.
La température moyenne d'un mois sera la moyenne des températures moyennes 
quotidiennes relevées pour ce mois.
*/
export const p_températures_anjou =
    p_températures_départementales
    .then(reponse => {

        // On cree notre tableau d'objets 
        let resultat = []

        // On recupere le tableau des relevé anjour
        let donneesAnjou = reponse['49']

        // On doit filtrer pour avoir que 2022
        donneesAnjou = donneesAnjou.filter((releve) => (releve.date.getFullYear()===2022))

        // Maintenant on recupere les min, max, moyenne pour chaque mois
        for (let i = 0; i < 12; i++) {
            let donneesMois = donneesAnjou.filter((releve) => (releve.date.getMonth() === i))

            // On recupere le max des maximales et le min des minimales
            let max = Math.max(...donneesMois.map(a => a.tmax))
            let min = Math.min(...donneesMois.map(a => a.tmin))
            // On recupere la moyenne
            let moy = donneesMois.map(a => a.tmoy).reduce((a, b) => a + b, 0) / (donneesMois.map(a => a.tmoy)).length;

            // On recupere les autres propriétés
            let date = new Date(2022, i, 1)
            let mois = new Intl.DateTimeFormat("fr-FR", {month: "long"}).format(date)
            
            // On rajoute cet nouvel objet au tableau resultat
            resultat.push(
                {
                    "date": date,
                    "mois": mois,
                    "température": min,
                    "classe": "Minimales"
                },
                {
                    "date": date,
                    "mois": mois,
                    "température": max,
                    "classe": "Maximales"
                },
                {
                    "date": date,
                    "mois": mois,
                    "température": moy,
                    "classe": "Moyennes"
                }
            )
        }

        return resultat;
    })