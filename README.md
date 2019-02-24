# Taxation

Sujet: <https://github.com/crouyre/taxation/enonce.pdf>

### Introduction
Le but est de mettre en place un programme qui calcule son imposition en fonction de différentes tranches.

### Choix des technologies
Le projet tourne sous symfony 4.2.3 et utilise phpunit pour les tests unitaires.
   
### Création de la table:
```
 CREATE TABLE edge (id INT AUTO_INCREMENT NOT NULL, rate DOUBLE PRECISION NOT NULL COMMENT 'Taux', start INT NOT NULL COMMENT 'Palier de début en RP du seuil', end INT DEFAULT NULL COMMENT 'Palier de fin en RP du seuil', year INT NOT NULL COMMENT 'Année d''exécution du seuil', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB COMMENT = 'Table contenant les seuils d''imposition' ;

``` 

### Insertion des valeurs:

```
INSERT IGNORE INTO edge (edge.`rate`,edge.`start`,edge.`end`,edge.`year`) 
VALUES
    ('0.05','0','50000000','2014'),
    ('0.15','50000000','250000000','2014'),
    ('0.25','250000000','500000000','2014'),
    ('0.30','500000000', null,'2014')
```

### Choix de l'architecture

En essayant de respecter une architecture SOLID, je suis parti sur un découpage assez simple:
dans un dossier Taxation, une classe ComputeSalary dont l'unique rôle est de calculer l'impôt sur le revenu. 
Pour cela, cette classe a besoin des différentes tranches de l'année en cours soit une collection d'entité nommée Edge qu'elle récupère via le repository.

### Détermination de la méthode de calcul

Pour déterminer la méthode de calcul, deux exemples sont à notre disposition. La règle se définie de la sorte:
> Je récupère l'ensemble de mes tranches.
> 
> Pour chaque tranches  je regarde deux choses:
> - S'il existe un seuil max pour cette tranche 
	> -> Cela reviendrait à dire qu'il n'y a pas de seuil maximum et donc que nous sommes en dernière tranche 
> - Si  le résultat de mon salaire - (le seuil max de la tranche - le seuil min de la tranche) <= 0 
	> ->Cela reviendrait à dire que le reste du salaire ne dépasse pas la tranche en question. 

> Pour ces 2 cas, le calcul est le même: 
> On ajoute au montant de l'imposition le taux de la tranche x le restant du salaire et on arrête la boucle.

> - Sinon on prend le montant d'imposition et on lui ajoute le taux de la tranche x (le seuil max de la tranche - le seuil minimum de la tranche) et on continue la boucle.

### Test

Pour le choix des scénarios : 
- un salaire de 75 000 000 RP => 6 250 000 RP
- un salaire de 750 000 000 RP => 170 000 000 RP 

L'utilisation d'un stub était nécessaire afin de simuler le repository.