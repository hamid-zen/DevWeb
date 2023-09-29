// Mode strict
"use strict";


// Imports
import {
    Traceur
} from "./traceur.js";
import {
    regénérerTracés_,
    tracer_
} from "./courbes_proto.js";

// Tests
import { Echantillon } from "./échantillonneur.js";


//////////////////////////////////////////////////////////////////////////////////////////
// Construction d'un traceur
let canevas = document.querySelector('canvas');
let contexte = canevas.getContext("2d");
let marge = {
    "X": 20,
    "Y": 20
};

let maxXY = {
    "X": parseInt(document.querySelector("input[name='max_x']").value),
    "Y": parseInt(document.querySelector("input[name='max_y']").value)
};


let traceur = new Traceur(canevas, contexte, marge, maxXY);
console.dir(traceur);
traceur.tracerRepère();
/* Test question 3 */
traceur.tracerGrille()
/*
Test question 2
console.log(traceur.repère)
console.log(traceur.dimensionXY)
console.log(traceur.point(NaN,3))
console.log(traceur.point(NaN,Infinity))
console.log(traceur.point(5,4))
*/
// Initialisation du log
let log = [];


//////////////////////////////////////////////////////////////////////////////////////////
// Test : trace la fonction identité sur un échantillon de 10 points en couleur orange 
let test = function () {
    // Taille de l'échantillon
    let n = 10;

    // La fonction à tracer
    let f = function (x) {
        return x;
    };

    /*
    Test 1ere question
    let e = new Echantillon(f, 10, {"min":1, "max": 10})
    console.log(e.points)
    */
    // Descripteur de la fonction
    let meta_f = {
        "type": "linéaire",
        "f": f,
        "paramètres": [1, 0],
        "strokeStyle": "rgb(255, 165, 0)"
    };

    // Trace la fonction, enregistre son descriptif dans le log et l'affiche dans le tableau HTML
    traceur.dessiner(n, meta_f, log);
    //console.table(log)
}();


//////////////////////////////////////////////////////////////////////////////////////////
// Trace la courbe d'une fonction dès que sa case est cochée dans le formulaire
//tracer(traceur, log);

document.querySelectorAll(".fonction").forEach((input) => {
    input.addEventListener('click', (e) => {
        tracer(traceur, log);
        setTimeout(() => {
            e.target.checked=false
        }, 2000);
    })
})

/*
    Met en place un écouteur sur les cases à cocher et si une case est cochée :
    - (1) construit le descripteur de fonction à partir des paramètres renseignés dans le formulaire
            (voir la fonction de test ou la méthode Traceur.dessiner pour le format de descripteur attendu)
            et en générant un code RGB aléatoire à l'aide de la fonction `rgb()`
    - (2) dessine la fonction en invoquant la méthode `dessiner` sur l'objet `traceur`en lui passant
            la taille de l'échantillon renseignée dans le formulaire, le descripteur et le log passé en argument
            (voir la méthode Traceur.dessiner)
    - (3) laisse la case cochée pendant 2 secondes avant de la décocher.
*/
function tracer(traceur, log) {

    // On commence par construire le descripteur de fonction
    let meta_f = {}

    // On recupere le type de la fonction
    meta_f.type = (document.querySelector(".fonction:checked")===null) ? "linéaire" : document.querySelector(".fonction:checked").value;

    let a, b, n, phi

    // On recupere les parametres et on cree les fonctions
    switch (meta_f.type) {
        case "linéaire":

            a = parseInt(document.querySelector("input[name='linéaire_a']").value)
            b = parseInt(document.querySelector("input[name='linéaire_b']").value)

            meta_f.paramètres = [a, b]

            meta_f.f = function (x) {
                return a * x + b;
            }

            break;
        case "exponentiation":

            n = parseInt(document.querySelector("input[name='exponentiation_n']").value)

            meta_f.paramètres = [n]

            meta_f.f = function (x) {
                return Math.pow(x, n)
            }

            break
        case "racine":
            n = parseInt(document.querySelector("input[name='exponentiation_n']").value)

            meta_f.paramètres = [n]

            meta_f.f = function (x) {
                return Math.pow(x, 1 / n)
            }

            break
        case "e":

            meta_f.paramètres = []

            meta_f.f = function (x) {
                return Math.exp(x)
            }

            break

        case "logarithme":
            //? On prend en compte le "e" (comment donner e en parametre)

            b = document.querySelector("select[name='logarithme_b']").value

            meta_f.paramètres = [b]

            meta_f.f = function (x) {
                switch (b) {
                    case "10":
                        return Math.log10(x)
                    case "e":
                        return Math.log(x)
                    case "2":
                        return Math.log2(x)

                    default:
                        break;
                }
            }

            break
        case "sinus":

            a=parseInt(document.querySelector("input[name='sinus_A']").value)
            n=parseInt(document.querySelector("input[name='sinus_n']").value)
            phi=parseFloat(document.querySelector("input[name='sinus_phi']").value)

            meta_f.paramètres = [a, n, phi]

            meta_f.f = function (x) {
                return a*Math.sin((2*Math.PI*x)/n + phi)
            }

            break;

        default:
            break;
    }
    
    // On recupere le code couleur
    meta_f.strokeStyle = rgb()

    //2eme partie
    // On recupere la taille de l'echantiliion
    let tailleEchantillon=parseInt(document.querySelector("input[name='échantillon_n']").value)
    
    // On appele tracer
    traceur.dessiner(tailleEchantillon, meta_f, log)
}   


// Génère un code rgb aléatoire sous forme de chaîne de caractères, p. ex. "rgb(10,240,89)"
function rgb() {
    return "rgb("+
            Math.floor(Math.random() * 255)+
            ","+
            Math.floor(Math.random() * 255)+
            ","+
            Math.floor(Math.random() * 255)+
            ")"
    
}


//////////////////////////////////////////////////////////////////////////////////////////
// Regénération du canevas au clic sur le bouton "Regénérer".
regénérerTracés(log);

/*
    Met en place un écouteur sur les clics du bouton de soumission qui, le cas échéant,
    (1) supprime le canevas existant et le remplace par un canevas de même dimension
    (2) construit une instance de Traceur pour ce canevas selon les coordonnées max renseignées dans le formulaire
    (3) trace le repère et éventuellement la grille si le bouton radio a été coché
    (4) redessine les courbes de toutes les fonctions figurant dans le log 
*/
function regénérerTracés(log) {
    // On commence par mettre notre ecouteur
    document.querySelector("button[type='submit']").addEventListener('click', (e) => {
        // On cree un nouveau log
        let newLog=[]
        console.log(log)
        // Une fois le boutton cliqué on commence par reset le canevas
        contexte.clearRect(0, 0, canevas.width, canevas.height)
        // On reset aussi le tableau des fonction
        document.querySelector("div.log table").replaceWith(document.createElement("table"))

        // On construit une instance de Traceur
        let newTraceur = new Traceur(canevas, contexte, {"X" : 20, "Y": 20}, {"X" : parseInt(document.querySelector("input[name='max_x']").value), "Y": parseInt(document.querySelector("input[name='max_y']").value)})
        
        // On trace le repere
        newTraceur.tracerRepère()

        // On check si on trace la grille
        if (document.querySelector("input[name='grille']").checked)
            newTraceur.tracerGrille()

        // On trace toutes les fonction dans le log
        log.forEach(meta => {
            let tailleEchantillon=parseInt(document.querySelector("input[name='échantillon_n']").value)
            newTraceur.dessiner(tailleEchantillon, meta, newLog)
        })

        log = newLog
    })
}



// Gestion du curseur
document.getElementsByName("échantillon_n")[0].onchange =
    function () {
        document.getElementsByName("échantillon_taille")[0].value = this.value;
    };