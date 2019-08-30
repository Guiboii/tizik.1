# tizik.1.0
TiZiK, le site de l'enseignement de la musique

<h1>A faire en priorité</h1>
<li>TEACHER -> Retirer une SCHOOL de sa liste</li>
<li>SCHOOL -> Gérer l'administration</li>
<li>TEACHER -> remettre en forme la mise en place des formulaires SCHOOL</li>
<li></li>
<h1></h1>
<h2>Logique des controllers :</h2>
<li>le HomeController gère toutes les pages d'accueil des différents rôles (pas trouvé mieux pour la redirection après le formulaire de login)</li>
<li>SchoolController gère les fonctionnalités liées aux SCHOOL, les parties "new" "addTeacher" "edit" "delete" sont réservées aux TEACHER</li>
