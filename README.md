# Sortir du nucléaire

# Concept

Le site de sortie du nucléaire 

- informe sur le nucléaire
- présente l'association "Sortir du nucléaire"
- publie des annonces d'activités (conférences, AG, ...)
- aide à suivre l'actualité sur le nucléaire

## La page d'accueil

La page d'accueil:

- donne envie de consulter les informations sur le nucléaire;
- rend clair que derriere le site il y a l'association "Sortir du nucléaire";
- informe sur les activités de l'association;
- présente quelque nouvelles d'actualité.

### La sidebar

Dans la sidebar nous avons les éléments suivants:

- Les _nouvelles_: affiche le titre de la dernière nouvelle (dans la section actualite/nouvelles) ou, si il existe, une "accroche" (teaser) préparée exprès pour la/les nouvelles courrantes.
- Un slider avec les cinque derniers posts sur la _page Facebook_
- Un lien vers la dernière _mise à jour_ (n'est pas générée automatiquement; sert à mettre en évidence les changements dans la partie informative du site)
- Lien vers la dernière édition du _journal_


## La navigation

La navigation doit mettre en valeur les thèmes principaux du site.

Il y a une navigation principale par desssous le bandeau avec le logo.

Dans certains cas, nous pouvons avoir une navigation dans la barre de droite.


### "Top" Navigation

À gauche:

- lien vers la page d'accueil
- prochain évenments dans l'agenda ou, si aucun, lien vers la dernière édition du journal

À droite:

- lien vers le formulaire de contact

###  Navigation principale


- déplacer "contact" sous "association" (le contenu de contact
  concernant uniquement l'asso)
- déplacer "liens" dans chaque section pour laquelle nous avons des
  liens (nous pourrons ajouter sur chaque page de lien un lien vers les
  autres pages de lien, si nécessaire...)
- déplacer "presse" sous actualité
- et après avoir fait de la place à la racine de la navigation,
  déplacer les sous-menus de "sortons du nucléaire" à la racine (et
  enlever "sortons du nucléaire).
  j'ai aussi abrégé les titres dans la navigation, on reprendra les
  titres complets sur la page même.
- enfin, je me pose la question si "accueil" est encore nécessaire. je
  vais essayer de suivre la solution proposée par http://lematin.ch :
  une ligne de texte par dessus le bandeau principal...)

Website de l'association Suisse Sortir du nucléaire

# Contact form

- sur green/nexlink `mail()` ne semble pas marcher
- avec PHPMailer, j'arrives à envoyer des mails vers des address `@sortirdunucleaire.ch`, avec n'importe quel from.

# Notes

Converting the journal's pdfs into pngs:

    convert sdn_journal_73.pdf[0] -resize 150x sdn_journal_73_150.png

or even 

    for i in *.pdf; do convert ${i}[0] -resize 150x ${i%.pdf}_150.png; done

- cross reference anchors in markdownk:
  - <http://stackoverflow.com/questions/5319754/cross-reference-named-anchor-in-markdown>
  - <https://michelf.ca/projects/php-markdown/extra/>
- facebook feed:
    - eventually, for composer:
        "simplepie/simplepie": "1.3.1",
        "facebook/php-sdk": "3.2.3",
    - http://callmenick.com/2013/03/14/displaying-a-custom-facebook-page-feed/
    - https://gist.github.com/banago/3864515
    - https://github.com/facebook/facebook-php-sdk
- line below the page title: http://www.impressivewebs.com/centered-heading-horizontal-line/

# Reference

- rename the lightSlider's image and modify `lightSlider.css` according to it.
- upload manager:
  - https://github.com/daverogers/jQueryFileTree/
  - http://toopay.github.io/bootstrap-markdown/ (with custom buttons...)

# Todo

- find a way to correctly show the favicon on each page
- define who should get the contact form mails. (info@sortirdunucleaire)
- make the page less wide
- (optionally) insert non breaking spaces for:
  - ` :`, ` ?`, ` !`
  - `« `, ` »`
- improve the way tables are shown (now i have to add a faked header with a dot in it
- add the old items in actualite/archive
- define the to address in the contact form from the structure.
- check what to do with neuchatel (and the other "small sites")
- add the content of the news
- add a module for the most recent update
- find out how to show items of a module (news entries)
- create a 303 redirect for each old id=
- add the tests for the Markdown local url replacements
      test

      <ici> et <http://labas.com>

      [test ici](ici) [test ici 2](ici_2)

      ![test ici](ici)

      [test la](http://labas.com)

      [tests la](https://labas.com)

      [test@test.com](mailto:test@test.com)

      ![tests la](https://labas.com)
 

## Content

- add the way to get the magazine on the magazine's page sidebar.
- when getting into a section always show the first subsection (i could create a module showing a sidebar with the list of subsections, too)


## Séance août 2016

- Quelle est l'objectif et
- quel est le public cible


publiques cibles:

- simpatisants
- journalistes
- élus
- faiseurs d'opinions / citoyen grand gueules de quartier
- associations
  - verts
- monde anti-nucléaire francophone
- entreprises energies renouvelables

nos différents moyens de communication suivants

- Le site web SdN
- les résaux sociaux
  - twitter
  - facebook
- Le journal SdN
- infoSdN  (bulletin électronique)
- lettres de lecteur
- "stand/conférences"

todo:
- proposition serveur: (y compromis côté écologique)
  - cyon.ch
  - dreamhost (ecology)
  - green.ch
  - metanet.ch

- enlever facebook ou plus en bas
- tweets qui défilent de haut en bas sans effacer le précédent
- bandeau au fond comme sur greenpeace.ch
- ajouté la date dans les actualités
- faire de façon à ce que l'article d'accueil soient éditable + image
- texte un peu trop petit et pas assez de place entre les menus de la navigation
- https://github.com/UberGallery ?
- download all the .md + .csv in a zip
