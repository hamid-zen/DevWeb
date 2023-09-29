import {
    Echantillon
} from "./échantillonneur.js";
import {
    tracerGrille,
    point,
    tracer,
    dessiner
} from "./traceur_proto.js";

export class Traceur {
    constructor(canevas, contexte, marge, maxXY) {
        // Le canevas
        this.canevas = canevas;

        // Largeur du canevas
        this.L = this.canevas.getAttribute("width");

        // Hauteur du canevas
        this.H = this.canevas.getAttribute("height");

        // Contexte 2D du canevas
        this.contexte = contexte;

        // Les marges horizontales (gauche/droite) et verticales (haute/basse) sous la forme 
        // {"X" : marge_horizontale, "Y": marge_verticale}
        this.marge = marge;

        /*
        Objet {"X" : Mx, "Y": My} où Mx et My sont les valeurs maximum qui seront acceptées en abscisse et ordonnée :
        - un point (maxXY.X,0) correspondra sur le canevas au point situé à l'extrémité droite de l'axe des abscisses.
        - un point (0,maxXY.Y) correspondra sur le canevas au point situé à l'extrémité haute de l'axe des ordonnées.
        */
        this.maxXY = maxXY;

        /*
        Objet {"X":dX, "Y":dy} où dx et dy sont les coefficients multiplicatifs à appliquer aux coordonnées 
        de tout point (x,y) (-this.maxXY.X <= x <= this.maxXY.X, -this.maxXY.Y <= y <= this.maxXY.Y)
        pour obtenir un décalage en pixels (x*dX,y*dY) par rapport au centre du canevas (cad. l'origine du repère).
        */
        this.dimensionXY = {
            "X": ((this.L - (2 * this.marge.X))) / (2 * this.maxXY.X),
            "Y": ((this.H - (2 * this.marge.Y))) / (2 * this.maxXY.Y)
        };

        /*
        Le repère sous la forme 
            {"X":
                {   "gauche": point du canevas correspondant à l'abscisse minimum,
                    "centre": point du canevas correspondant à l'origine du repère,
                    "droit": point du canevas correspondant à l'abscisse maximum
                },
            "Y":
                {   "bas": point du canevas correspondant à l'ordonnée minimum,
                    "centre": point du canevas correspondant à l'origine du repère,
                    "haut": point du canevas correspondant à l'ordonnée maximum
                }
            }

            Note : X.centre === Y.centre
        */
        this.repère = {
            "X": {
                "gauche": [this.marge.X, Math.floor(this.H / 2)],
                "centre": [Math.floor(this.L / 2), Math.floor(this.H / 2)],
                "droit": [this.L - this.marge.X, Math.floor(this.H / 2)]
            },
            "Y": {
                "bas": [Math.floor(this.L / 2), this.H - this.marge.Y],
                "centre": [Math.floor(this.L / 2), Math.floor(this.H / 2)],
                "haut": [Math.floor(this.L / 2), this.marge.Y]
            }
        };
    }

    // Trace le repère (les 2 axes et leurs échelles de valeurs)
    tracerRepère() {
        // paramétrage du contexte
        this.contexte.strokeStyle = 'black';
        this.contexte.lineWidth = 2;
        this.contexte.setLineDash([]);

        // axe des abscisses
        this.contexte.beginPath();
        this.contexte.moveTo(this.repère.X.gauche[0], this.repère.X.gauche[1]);
        this.contexte.lineTo(this.repère.X.droit[0], this.repère.X.droit[1]);
        this.contexte.stroke();

        // axe des ordonnées
        this.contexte.beginPath();
        this.contexte.moveTo(this.repère.Y.bas[0], this.repère.Y.bas[1]);
        this.contexte.lineTo(this.repère.Y.haut[0], this.repère.Y.haut[1]);
        this.contexte.stroke();

        // échelle des abscisses (21 graduations)
        let point = this.point(this.repère.X.gauche[0], this.repère.X.gauche[1]);
        this.contexte.moveTo(point.X, point.Y);
        for (let x = -this.maxXY.X; x <= this.maxXY.X; x += 2 * this.maxXY.X / 10) {
            let pointTexte = this.point(x, 0);
            this.contexte.fillText(parseFloat(x).toFixed(2).toString(), pointTexte.X - 10, pointTexte.Y + 10);
            this.contexte.stroke();
        }

        // échelle des ordonnées (21 graduations)
        point = this.point(this.repère.Y.bas[0], this.repère.Y.bas[1]);
        this.contexte.moveTo(point.X, point.Y);
        for (let y = -this.maxXY.Y; y <= this.maxXY.Y; y += 2 * this.maxXY.Y / 10) {
            let pointTexte = this.point(0, y);
            this.contexte.fillText(parseFloat(y).toFixed(2).toString(), pointTexte.X - 10, pointTexte.Y + 10);
            this.contexte.stroke();
        }
    };

    // Trace la grille
    tracerGrille() {

        this.contexte.strokeStyle = 'gray';
        this.contexte.setLineDash([1, 4]);

        // grille horizontale
        let tailleRepereVertical = this.repère.Y.bas[1] - this.repère.Y.haut[1]
        let tailleGrille = 10
        for (let i = 0; i <= tailleGrille; i++) {

            this.contexte.beginPath();

            // On commence du "point actuel" (point de depart(haut gauche) + (taille totale)/nombre de lignes)
            let point = this.point(this.repère.X.gauche[0], this.repère.Y.haut[1]);

            this.contexte.moveTo(point.X + this.marge["X"], point.Y + (tailleRepereVertical / tailleGrille) * i + (this.marge["Y"]));
            this.contexte.lineTo(this.repère.X.droit[0], this.marge["Y"] + (tailleRepereVertical / tailleGrille) * i);

            this.contexte.stroke();

        }

        // grille vericale
        let tailleRepereHorizontal = this.repère.X.droit[0] - this.repère.X.gauche[0]
        for (let i = 0; i <= tailleGrille; i++) {
            this.contexte.beginPath();

            // On commence du "point actuel" (point de depart(haut gauche) + (taille totale)/nombre de lignes)
            let point = this.point(this.repère.X.gauche[0], this.repère.Y.haut[1]);

            this.contexte.moveTo(point.X + this.marge["X"] + (tailleRepereHorizontal / tailleGrille) * i, point.Y + (this.marge["Y"]));
            this.contexte.lineTo(point.X + this.marge["X"] + (tailleRepereHorizontal / tailleGrille) * i, this.repère.Y.bas[1]);

            this.contexte.stroke();

        }
        this.contexte.closePath()
    };

    /*
    Transforme un point (x,y) en un point du canevas (u,v) au format objet {"X": u, "Y": v} par 
    - dimensionnement en appliquant this.dimensionXY
    - et décalage par rapport au centre du canevas.
    Emet un message d'avertissement en console et renvoie {"X": false, "Y": false} pour tout point (x,y) hors-limite,
    cad. si l'une au moins de ses coordonnées vaut NaN ou +/-Infinity ou si |x| > this.maxXY.X ou |y| > this.maxXY.Y.
    */

    point(x, y) {
        // on check si la valeur est valide
        if (!isFinite(x) || isNaN(x) || !isFinite(y) || isNaN(y) || Math.abs(x) > this.maxXY.X || Math.abs(y) > this.maxXY.Y) {
            console.warn("traceur.point():Données invalides", { "X": x, "Y": y })
            return { "X": false, "Y": false }
        } else {
            // Si les valeurs sont valides alors on calcule les coordonnées par rapport a la page
            // d'abord on multiplie par le coeff de dimension pour ramener a l'echelle de la page html
            // Puis on decale par rapport au point d'origine (decalage normal pour les x et inverse pour les y (car techniquement l'origine est tout en haut a gauche et va a gauche et en bas (pas en haut)))
            return { "X": (this.repère.X.centre[0] + x * this.dimensionXY.X), "Y": (this.repère.X.centre[1] - y * this.dimensionXY.Y) }
        }
    };

    /*
    - Transforme le tableau P=[...,[u,v],...] de n points passé en paramètre en un tableau Q de points du canevas par appel à la méthode `this.point`.
    - Trace la courbe correspondante à Q en reliant les ordonnées des points successifs (Q[i].Y, Q[i+1].Y) par des segments (1<=i<n).
    
    Remarques :
    - Le tracé utilise la couleur CSS `strokeStyle`.
    - Une exception est levée si P ne vérifie pas P[i].X < P[i+1].X (1<=i<n).
    - Les points hors limite sont omis du tracé et donne lieu à un avertissement en console.
    */
    tracer(P, strokeStyle) {
        this.contexte.beginPath();

        this.contexte.setLineDash([])
        this.contexte.strokeStyle = strokeStyle;

        for (let i = 0; i < P.length - 1; i++) {

            // Pour les points hors limite (ou NaN ou Infinity) on skip l'itteration actuelle (faute d'autre solution)
            if (!isFinite(P[i][0]) ||
                isNaN(P[i][0]) ||
                !isFinite(P[i][1]) ||
                isNaN(P[i][1]) ||
                !isFinite(P[i + 1][0]) ||
                isNaN(P[i + 1][0]) ||
                !isFinite(P[i + 1][1]) ||
                isNaN(P[i + 1][1]) ||
                Math.abs(P[i][0]) > this.maxXY.X ||
                Math.abs(P[i][1]) > this.maxXY.Y ||
                Math.abs(P[i + 1][0]) > this.maxXY.X ||
                Math.abs(P[i + 1][1]) > this.maxXY.Y
            )
                continue;

            // On calcule les coordonnées du  point actuel et du point suivant (traduit en "cooredonées" de page)
            const pointActuel = this.point(P[i][0], P[i][1]);
            const pointSuivant = this.point(P[i + 1][0], P[i + 1][1]);

            // Si les points ne sont pas ordonnées on lache une erreur
            if (P[i][0] > P[i + 1][0])
                console.error("Traceur.tracer(): abscisses non ordonnées")

            this.contexte.moveTo(pointActuel.X, pointActuel.Y)
            this.contexte.lineTo(pointSuivant.X, pointSuivant.Y)
            this.contexte.stroke()

        }

    };

    /* 
    Procède en 3 étapes :
    (1) Génère pour la fonction mathématique décrite par `meta_f` un échantillon de `n` points 
            dont les abscisses sont répartis sur l'intervalle [-this.maxXY.X,this.maxXY.X]
    (2) Trace la courbe échantillonnée sur le canevas selon la fréquence renseignée par le visiteur
    (3) Ajoute `meta_f` au tableau `log` et ajoute une ligne au tableau HTML contenant la formulation de la fonction.

    `meta_f` est un descripteur de fonction réelle au format
        {
            "type": chaîne de l'ensemble {"linéaire", "exponentiation", "racine", "e", "logarithme", "sinus"}
            "f": fonction de rappel JS implémentant la fonction mathématique décrite
            "paramètres": tableau (potentiellement vide) des paramètres de la fonction dans l'ordre des champs HTML correspondants
            "strokeStyle": code couleur CSS pour tracer et tabuler la fonction (p. ex. "orange" ou un code RGB "rgb(5,200,89)")
        }

    Remarques :
    - L'échantillonnage s'effectue par invocation de la méthode `points` sur une instance d'`Echantillon`.
    - Si la fréquence de tracé F (telle que renseignée dans le champ du formulaire) est > 0, le tracé est non-bloquant 
        (cad. asynchrone en utilisant `setInterval`) et chaque segment de la courbe en commençant par le point le plus à gauche 
        est tracé toutes les F/10 secondes.
    - La ligne (mono-cellule) à ajouter au tableau HTML contiendra une chaîne de caractères construite à partir
        du type de la fonction et de la valeur de ses arguments (p. ex. "2x + 1", "3 sin(2Pix/4 + 1.07").
    - La couleur `meta_f.strokeStyle` est utlisée pour le tracé et comme couleur de fond de la ligne HTML.
    */
    dessiner(n, meta_f, log) {
        // A REMPLACER
        //return dessiner.call(this, n, meta_f, log);

        // Absisses min et max
        let absissesMinMax = {
            "min": -this.maxXY.X,
            "max": this.maxXY.X
        };

        // Génération d'un échantillon de n points de la fonction f
        let e = new Echantillon(meta_f.f, n, absissesMinMax)

        // Tracé de l'échantillon

        // On recupere la frequence
        let frequence = parseInt(document.querySelector("input[name='échantillon_f']").value)

        if (frequence == 0) {
            // Syncrone
            this.tracer(e.points, meta_f.strokeStyle)
        } else {
            // Comment sleep la fonction
            setTimeout(() => {
                this.tracer(e.points, meta_f.strokeStyle)
            }, frequence * 10);
        }
        // Log de la fonction et affichage dans le tableau

        // on ajoute les infos de f dans le log
        log.push(meta_f)

        // Ensuite on rajoute f a la table html
        let newTr = document.querySelector("div.log table").insertRow()
        let newTd = newTr.insertCell()

        newTd.style.backgroundColor = meta_f.strokeStyle

        // On s'occupe maintenant du texte du td
        switch (meta_f.type) {
            case "linéaire":
                newTd.innerHTML = meta_f.paramètres[0] + ((meta_f.paramètres[1] >= 0) ? ("x + "+ meta_f.paramètres[1]) : ("x - "+(-meta_f.paramètres[1])))
                break;
            case "exponentiation":
                newTd.innerHTML = "x <sup>" + meta_f.paramètres[0] + "</sup>"
                break
            case "racine":
                newTd.innerHTML = "x <sup>1/" + meta_f.paramètres[0] + "</sup>"
                break;
            case "e":
                newTd.innerHTML = "e <sup>x</sup>"
                break;
            case "logarithme":
                newTd.innerHTML = "log<sub>" + meta_f.paramètres[0] + "(x)</sub>"
                break;
            case "sinus":
                newTd.innerHTML = meta_f.paramètres[0]+"sin(2Πx/"+meta_f.paramètres[1]+" + "+meta_f.paramètres[2]+")"
                break;
            default:
                break;
        }

    };
}