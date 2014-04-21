Renaud TERTRAIS  
M2 CIM - DT  
ICOM 2014  

# PROJET PHP / JAVASCRIPT


## Introduction

J’ai souhaité profiter de l’occasion de ce projet pour approfondir le framework **Symfony** dont l’aperçu en cours m’a beaucoup plu. Afin de travailler la partie Javascript, j’ai voulu utiliser le framework **AngularJS** afin de réaliser un mini **CMS** avec un backoffice **full Ajax** (API Rest). Enfin mon dernier objectif était que ce CMS puisse être entièrement **modulaire**.

Ce projet initial à la foi passionnant et motivant, n’en demeure pas moins très ambitieux dans le cadre de cette réalisation. Ainsi, certains aspects ne seront pas totalement aboutis. Je fais le choix de « passer » sur quelques problématiques de sécurité afin de privilégié un rendu fonctionnel.

J’espère que même si mon travail est perfectible et ne respecte pas totalement la consigne initiale, vous apprécierez ma prise de risque et l'originalité de l'architecture de mon code. Bonne lecture !

## 1. Symfony
### 1.1. Les entités

Le maître mot de mon projet est « **modularité** ». J’ai pensé mes **entités Symphony** dans ce sens et voici le principe qui les régisse : chaque entité doit hériter de son **modèle**. Un modèle (pas au sens model MVC mais plus moule, schéma...) est une classe semblable à la classe entité sauf qu’elle n’est pas instanciable (utilisable comme entité). Elle sert de modèle (class mère) pour une class entité. On spécifie cela en retirant l’annotation `@ORM/entity` et `@ORM/table` et on précise `@ORM\MappedSuperclass`. 

Au départ je souhaitais directement faire hériter mes entités les unes des autres mais cela n’est pas possible sans jointures et certaines annotations doivent être définies sur la classe mère à chaque héritage. Or je voulais un système simple dans lequel si un module (entité) correspondait à ce que l’on souhaitait mais que que l’on voulait rajouter des comportements (champs, méthodes…), il nous suffisait de dériver tout simplement et d’overrider ce que bon nous semblerait.

Ainsi la classe **Model** de base est **DataModel** avec 3 champs : **id** (auto-incrément), **created** (date de création) et **updated** (date de modification); 3 champs qui seront utiles à 95% des entités. L’intérêt de l’héritage des entités est que si l’on souhaite donné un comportement à tout les entité, il suffit de l’ajouter à cette classe. Ce sera le cas pour 2 méthodes.

Ce principe d’héritage de classes pour les Models sont le même pour les Repository.

Pour résumer voici comment on créer un module (une entité) **Post** :

1. on crée son **Model**: `class PostModel extends DataModel` (on rajoute les champs nécessaires par exemple title, slug, content…)
2. on crée son **Repository** : `class PostModelRepository extends DataModelRepository`
3. on crée l’**Entity** en tant que telle : `class PostModule extends PostModel` (vide)

Pourquoi créer **PostModel** ? **PostModule** aurait pu étendre directement **DataModel**, oui mais c’est par souci de modularité. Si plus tard, je veux créer un module **Page** qui hérite de **Post**, je peux le faire car j’ai juste à créer un **PageModel** qui hérite de **PostModel** etc.

Il existe **2 controlleurs** : 

1. **DefaultController** chargé d'administrer le front
2. **AdminController** chargé d'administrer le back.

### 1.2. Routes
**DefaultController** fonctionne de manière classique, sans ajax avec un routage traditionnel.

**AdminController** n'utilise pas le routage pour la réécriture d'url (j'utilise le routage d'angular pour la partie admin). Ainsi les routes de ce controlleur me permettent de traiter la requête ajax demandée. Par exemple :

1. url ajax : `/admin/get/Post/1` 
2. route Symfony correspondante : `/admin/get/{module}/{id}`
3. controlleur (méthode) associé : `moduleGetAction( $module , $id )`

### 1.3. Configuration et multilingue
Après avoir été séduit par la concision du **YAML**, j'ai décidé de l'utiliser pour la configuration des modules (`Ressources/public/admin/config/`). Dans ces fichiers de configuration, on définit le nom du module, les différents labels, l'icône du menu. Les labels sont une tentative de création d'une administration multilingue. Pour l'extraction des données de ces fichiers yml, j'ai utilisé le **parser yaml** de Symfony.

### 1.4. Models
Situé dans `Model/` et à ne pas confondre avec les modèles des entités, il s'agit de classes utilitaires avec des méthodes statiques.

### 1.5. Vues
Toujours en conservant cette idée de modularité et d'héritage, j'ai créé des template **twig**. C'est le cas de `moduleList.html.twig` ou de `moduleSingle.html.twig`. Ceci permet de mettre les bases HTML de la vue en me servant des `{{ block }}`. Cela me permet aussi d'initialiser dicretement mes controleur angular *(voir ci dessous)* qui vont faire tout le travail de base.

Comme pour la nomenclature des entités (DataModel, PostModule...), la nomenclature des template twig obéisse à une nomenclature très précise afin d'aider le controlleur à choisir le bon template en fonction du module.

### 1.6. Forms
J'ai essayé d'utiliser les **formulaires** Symfony pour le temps qu'ils permettent de gagner. Chaque **module** (entité) peut créer son formulaire qui sera envoyé à la vue `{module}Single.html.twig` automatiquement. Pour se faire, on doit ajouter une méthode statique à `Model/AdminForm` en respectant la nomenclature `{module}Form` :

```
public static function PostForm( $builder ){
	$builder
		->add('title'	, 'text')
		->add('content'	, 'textarea');

	return self::Render( $builder );
}
```

Ainsi le formulaire se rendra disponible pour le controlleur pour l'**envoie à la vue** et pour la **vérification** en cas de soumission. J'ai notamment rencontré un bon nombre de difficultés concernant cette deuxième partie *(voir plus bas)*. 

## 2. AngularJS

### 2.1 Controleurs & Services

**AngularJS** est un **framework MVC coté client** (tous les fichiers de sont dans `Ressources/public/js/admin/`). Un controller ici est une **fonction** qui va se charger d’administrer un partie du DOM. 

Par exemple : 

**HTML**
```
<body ng-controller="mainController">
    <button ng-click="message('hello world')">{{ label }}</button>
</body>
```

**JS**
```
function mainController( $scope ){
    $scope.label = "Cliquer ici";
    $scope.message = function( msg ){
        alert( msg );
    }
}
```

La aussi j'ai souhaité mettre en place un système d'**héritage** (en m'appyant sur le comportement par défaut) afin encore une fois de faciliter l'intégration de module basé sur l'existant. Tout controller défini à l'intérieur d'un autre controller récupère ses **variables** et **méthodes**. Ainsi, dans l'exemple du haut, si j'avais définit un controlleur dans le `<button>` il aurait hériter de `test` et de `message()`.

Le controlleur de base est `mainContolleur`. Il contiens des méthodes permettant de récupérer en **ajax** les données des modules (entités), d'insérer... Pour se faire il passe par un **service** : **moduleService**. C'est ce dernier qui envoi réellement les appel ajax. Il y a des requêtes qui ne passent pas par ce service : il s'agit des requêtes pour changer de page. En effet pour changer de page, on ne demande pas uniquement des données à **Symfony** mais aussi un template **Twig**.

### 2.2. Routes
Pour l'instant, il n'y a que 2 type de routes possible :

1. `#/admin/{module}`. Elle permet à la liste des entrées du module
2. `#/admin/{module}/{id}`. Elle permet de modifier un entrée d'un module.

## 3. Difficultés rencontrées
Elles sont nombreuse !  Mais voici les principales :

1. **Le passage de données de Symfony à AngularJS** (résolut). Capitale pour le bon fonctionnement de l'administration, ce passage de données a été plus compliqué que prévu. La première chose à laquelle on pense est un `json_encode()` des objets entités. Cependant un `json_encode()` ne contient que les propriétés publiques or les propriétés des entités sont privés. On pourrait les mettre en publique pour résoudre le problème mais on perdrait l'encapsulation des données. J'ai préféré créer une méthode dans le repository `DataModelRepository` qui je le rappelle est le repository duquelle tout les autres dérivent. La méthodes `getVars()` retourne tout les propriétés de l'entité. Cependant pour y accéder à partir du parent, j'ai du mettre les propriétés en `protected`.

2. **Les formulaires Symfony** (non-résolut). Je n'ai pas réussi à faire fonctionner la vérification. Dans le cours on faisait mention de `$form->submit($request)`or il s'avère que cette méthode est dépréciée et qu'il faut utiliser `$form->handleRequest($request)`. Or ni l'une ni l'autre ne semble fonctionner.

3. **Le cache Symfony** (résolut). Au début j'envoyait les données JSON à la vue à partir du controller **Symfony**. Puis j'envoyais les données à Angular en les affichant dans le template **twig**. Le problème est que les données n'étaient pas tout le temps actualiser car Symfony récupérait le fichier dans son cache. La solution est de chargé le template sans les données JSON puis de les récupérer en Ajax après.

La plupart concernent la partie Symfony, ce qui me semble logique en considérant mon manque de connaissances du framework.

## Bilan
Malgré le fait que je n'ai pas eu le temps de finir le projet (malgré la rallonge de 2 semaine très appréciée), je suis très satisfait d'avoir pu approfondir mes connaissances sur **Symfony**. A présent je peux prétendre à des projets sur ce framework. Par ailleurs, la découverte de **Doctrine** et des possibilités de son ORM a été très instructif. Enfin la mise en place d'une application AngularJS et sa synchronisation avec Symfony a été passionnant.

## Avenir du projet
Ce projet pourra me servir de base à un projet professionnel. Il faudra finir la partie user avec login, une partie média avec gestion d'images, un dashboard... Mais la base est la et me semble solide !
