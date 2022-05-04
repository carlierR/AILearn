# Plugin AILearn


## Pré-requis

Installer le plugin Wordpress dans `` wp-content\plugins``.
Il existe la version AILearn qui utilise fonctionne grace à la connexion wordpress et la version AILearn_login qui utilise le fichier texte login.txt pour s'authentifier

## Installation

Pour commencer, vous devez créer deux articles/posts. Le premier sera le contenu du formulaire et le second sera la page permettant de récupérer les données.

Le premier article n'a pas besoin d'avoir un nom/slug spécifique, mais il faudra rajouter un shortcode  ``[AILearn_show]`` dans la page.

Concernant le second article, il faut lui attribuer le slug ``store`` ainsi que le shortcode ``[AILearn_store]``.

### Pour la version AiLearn

Le processus d'installation reste le même que l'autre version sauf qu'il faut rajouter un article nommé ``login`` avec comme contenu, un shortcode ``[AILearn_login]``

Le fichiers texte permettant de modifier les informations des activitées et de la connexion utilisateurs sont situés dans le dossier ``file`` du plugin.

L'ajout d'un utilisateur se fait dans le fichier login.txt, un utilisateur par ligne écrit de cette façon ``login,MotDePasse``.

L'ajout d'une activité se fait dans le fichier activity.txt, une activitée par ligne.

Attention, supprimer une activité qui est déja apparut dans le fichier de données pourrait causer des conflits. 

## Information

Les utilisateurs pourront ensuite accéder à l'article contenant le formulaires pour commencer à remplir le fichier.

Le plugin possède une page de configuration trouvable dans le menu déroulant de la barre d'administration permettant de télécharger le fichier au format CSV.

La gestion des utilisateurs est gérer par le systeme de connexion de Wordpress.
    
