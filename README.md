Renaud TERTRAIS
M2 CIM - DT
ICOM 2014

# PROJET 
# PHP / JAVASCRIPT

* * *

## Introduction
J’ai souhaité profiter de l’occasion de ce projet pour approfondir le framework Symfony dont l’aperçu en cours m’a beaucoup plu. Afin de travailler la partie Javascript, j’ai voulu utiliser le framework AngularJS afin de réaliser un mini CMS full Ajax (API Rest). Enfin mon dernier objectif était que ce CMS puisse être entièrement modulaire.

Ce projet initial à la foi passionnant et motivant, n’en demeure pas moins très ambitieux dans le cadre de cette réalisation. Ainsi, certains aspects ne seront pas totalement aboutis. Je fais le choix de « passer » sur quelques problématiques de sécurité afin de privilégié un rendu fonctionnel.

J’espère que même si mon travail est perfectible et ne respecte pas totalement la consigne initiale, vous apprécierez ma prise de risque et la rigueur de mon ambition.

## Symfony : Les entités
Le maître mot de mon projet est « modularité ». J’ai pensé mes entités Symphony dans ce sens et voici le principe qui les régisse : chaque entité doit hériter de son model. Un model est une class semblable à la classe entité sauf qu’elle n’est pas instanciable (utilisable comme entité). Elle sert de model (class mère) pour une class entité. On spécifie cela en retirant l’annotation @ORM/entity et @ORM/table et on précise @ORM\MappedSuperclass. Au départ je souhaitais directement faire hériter mes entités les unes des autres mais cela n’est pas possible sans jointures et certaines annotations doivent être défini sur la class mère à chaque héritage. Or je voulais un système simple dans lequel si un module (entité) correspondait à ce que l’on souhaitais mais que que l’on voulait rajouter des comportements (champs, méthodes…), il nous suffisait de dérivé tout simplement et d’overrider ce que bon nous semblait.

Ainsi la classe Model de base est DataModel avec 3 champs : id (auto-incrément) created (date de création) et updated (date de modification); 3 champs qui seront utiles à 95% des entités. L’intérêt de l’héritage des entités est que si l’on souhaite donné un comportement à tout les entité, il suffit de l’ajouter à cette classe. Ce sera le cas pour 2 méthodes.

Ce principe d’héritage de classes pour les Models sont le même pour les repository.

Pour résumer voici comment on créer un module (une entité) Post :
1. on crée son modèle: class PostModel extends DataModel (on rajoute les champs nécessaires par exemple title, slug, content…)
2. on crée son repository : class PostModelRepository extends DataModelRepository
3. on crée l’entité en tant que telle : class PostModule extends PostModel (vide)

Pourquoi créer PostModel ? PostModule aurait pu étendre directement DataModel, oui mais c’est par souci de modularité. Si plus tard, je veux créer un module Page qui hérite de Post, je peux le faire car j’ai juste à créer un PageModel qui hérite de PostModel etc.

## AngularJS : Les contrôleurs
Angular est un framework MVC coté client (tous les fichiers de sont dans Ressources/public/js/admin/). Un controller ici est une fonction qui va se charger d’administrer un partie du DOM. Par exemple : <body ng-controller=‘’

