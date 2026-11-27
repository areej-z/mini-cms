# Session 13 - Défi

/api/posts/3 affiche tags avec des noms : oui / non
/api/posts ne contient aucun body, /api/posts/3 en contient un : oui / non
Aucune LazyLoadingViolationException : oui / non

Pourquoi ne pas envoyer body dans la liste, et qui en profite ?

Le corps complet rendrait chaque page paginée plus lourde. Il est utile de ne charger le contenu complet que lorsqu'une personne ouvre un article, ce qui améliore la rapidité et réduit les données envoyées sur mobile.

Un brouillon renvoie 403. Quel avantage aurait un 404 pour un brouillon ?

Un 404 ne confirmerait pas qu'un brouillon existe avec ce numéro, alors qu'un 403 révèle son existence. Le choix actuel réutilise uniformément la règle de PostPolicy sur les portes web et API.
