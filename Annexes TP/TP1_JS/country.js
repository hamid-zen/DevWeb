//! Probleme question 7 (Affichage des drapeaux)

// 2 variables globales à modifier dans l'écouteur window.onload
var countries = {
    "names": [], // ["Afghanistan", ...]
    "codes": {}, // {"Afghanistan":"AF", ...}
    "flags": {} // {"Afghanistan":"data:image...", ...}
};

var continents = []; // [{"Asia":["Afghanistan","Armenia",...]}, ...]


window.addEventListener("load", (event) => {
    // Q1 Extraction des noms de pays à partir du tableau HTML

    // On commence par recuperer le table
    countries.names = Array.from(document.querySelectorAll("td")).map((x) => (x.innerText));
    console.log(countries.names);

    // Q2 Extraction des codes de pays du fichier country_codes.json
    fetch('country_codes.json', {
        method: 'GET'
    })
        .then((response) => response.json())
        .then((country_codes) => {
            console.log('Success:', country_codes);
            // On ittere sur les objets
            country_codes.forEach(element => {
                // On extraie les pays et leurs codes
                pays = Object.entries(element)[0][0]
                code = Object.entries(element)[0][1]

                // On les ajoute a l'objet
                countries.codes[pays] = code
            });
            console.log(countries.codes);
            return countries.codes;
        })
        .catch((error) => {
            console.error('Error:', error);
        });

    // Q3 Extraction des continents de pays à partir du tableau country_continents (importé de country_continents.js)

    // On recupere les noms des continents
    let continentsNames = country_continents.map((x) => (x.continent))
    // On filtre les doublons et on le trie
    continentsNames = Array.from(new Set(continentsNames)).sort()
    // On ittere sur les noms et on lui cree un tableau de pays
    continentsNames.forEach(continent => {
        let countriesOfContinent = []
        country_continents.forEach(country => {
            if (country["continent"] == continent)
                countriesOfContinent.push(country["country"])
        });
        // On finit par push le couple {contient: tableau des pays}
        continents.push({ [continent]: countriesOfContinent })
    });
    console.log(continents);

    // Q4 Extraction des drapeaux de pays à partir de la constante country_flags (importée de country_flags.js)
    // On ittere sur les drapeaux
    country_flags.forEach(element => {
        // Meme traitement que pour Q1
        // On recupere le pays et son logo(drapeau)
        let pays = element.country
        let logo = element.flag_base64

        // On l'ajoute a l'object flags
        countries.flags[pays] = logo
    });
    console.log(countries.flags);

    // Q5 Mise en forme CSS
    // On commence par centrer le texte des cellules du tableau
    document.querySelectorAll("td").forEach(element => {
        element.style.textAlign = "center"
        element.style.fontSize = "75%"
    });

    // On ajoute la classe au second sous element div
    document.querySelector("div:nth-child(2)").classList.add("row")

    // On ajoute la classe au premier sous element div
    document.querySelector("div:nth-child(2) div").className = "side"
});



let handleSelectors = function () {
    // Q6 Gestion du menu

    document.querySelector("select").addEventListener('change', (e) => {
        let choixContinent = e.target.value
        let pays = []

        // On extraie les pays du continent
        continents.forEach(objetContinent => {
            // On recupere le nom et les pays du continent
            let nomContinent = Object.entries(objetContinent)[0][0]
            let paysContinent = Object.entries(objetContinent)[0][1]

            // Si un seul continent alors affectation normale
            if (nomContinent === choixContinent)
                pays = paysContinent
            // Si choix "total" alors concatenation
            else if (choixContinent === "all")
                pays = pays.concat(paysContinent)

        });

        // Maintenant qu'on a les pays on ittere dessus pour cacher les autres
        document.querySelectorAll("td").forEach(cell => {

            // Si le pays de la cellule est dans la liste alors on rend visible
            if (pays.includes(cell.innerHTML))
                cell.style.visibility = "visible"
            else
                cell.style.visibility = "hidden"
        });
    })
}();


let handleRadios = function () {
    // Q7 gestion des boutons radio
    document.querySelectorAll("input[type=\"radio\"]").forEach(radio => {
        radio.addEventListener('click', (e) => {
            // On recupere le choix
            let choixAffichage = e.target.value;

            // Si le choix est d'afficher les noms il suffit d'afficher les id pour chaque case
            if (choixAffichage === "noms") {
                document.querySelectorAll("td").forEach(cell => {
                    cell.innerHTML = cell.id;
                });
            } else {
                // Si les choix est d'afficher les codes alors il va falloir aller chercher le code de chaque pays
                if (choixAffichage === "codes") {
                    document.querySelectorAll("td").forEach(cell => {
                        let paysCellule = cell.innerHTML;

                        // On cherche le code du pays dans l'objet countries
                        Object.entries(countries.codes).forEach(element => {
                            let nomPays = element[0]
                            let codePays = element[1]

                            if (paysCellule === nomPays) {
                                // On affiche le code a la place de l'affichage normal
                                cell.innerHTML = codePays;
                            }
                        });
                    });
                    // Si le choix est d'afficher les drapeaux alors on va aller chercher le drapeau (code en BASE64)
                } else if (choixAffichage === "drapeaux") {
                    document.querySelectorAll("td").forEach(cell => {
                        let paysCellule = cell.innerHTML;

                        // On cherche le code du pays dans l'objet countries
                        Object.entries(countries.flags).forEach(element => {
                            let nomPays = element[0]
                            let drapeauPays = element[1]

                            if (paysCellule === nomPays) {
                                // Alors a la place du texte html a l'interieur on affiche l'image
                                cell.innerHTML = "<img src=\""+ drapeauPays +"\" alt=\"" + paysCellule + "\" />"
                                console.log(cell.outerHTML)
                            }
                        });
                    });
                }
            }
        })
    });
}();

let handleHeader = function f() {
    let tds = document.querySelectorAll("td");
    tds.forEach(function (td) {
        td.addEventListener("click", function (e) {
            let country_name = e.target.id;
            if (country_name) {
                fetch('get_country_features.php', {
                    method: 'POST',
                    body: new URLSearchParams("country_name=" + country_name),
                })
                    .then((response) => response.json())
                    .then((country) => {
                        console.log('Success:', country);
                        // Q8 clic sur cellule
                        // A COMPLETER <---
                        // --> A COMPLETER
                        return country;
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        });
    });
}();