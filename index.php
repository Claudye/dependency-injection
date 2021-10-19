<?php
/**
 * Injection de dépendance
 *  Cette Injection de dépence peut injecter toute class qui respecte le PSR-4
 */
require __DIR__.'/vendor/autoload.php';
use Ladis\DI\Tests\Fictive;
use Ladis\DI\Mediator;
use Ladis\DI\Tests\FictiveNull;
use Ladis\DI\Tests\FictiveWithOptional;


$container = Mediator::mediator();


/**
 * Ceci est une liste de class injectable
 * 
 */
$lots = [
    "myclass" =>Fictive::class,
    'fictivenull' =>FictiveNull::class,
    'optional'=>FictiveWithOptional::class,
    'closure'=> function (){
        
    }
];
echo 'Possible d\'envoyer un tableau de class à injecter <hr>';
$container->configure($lots);
 /**
  * Enrgistrment d'un objet avec argument
  * On enregistre FictiveWithOptional  On lui passe les arguments  [200,'non',new Fictive]
  */
$container->register("objet",FictiveWithOptional::class)
->setArguments('objet',[200,'non',new Fictive]);

/**
 * On enregistre une information sur dont la clé est recive
 */
$container->receive('receive','Toto va au marché');




echo 'Possible charger une classe enregistrer <hr>';
$objetWithNamespace = $container->get('myclass');
/**
 * Sans constructeur
 */
dump($objetWithNamespace);

echo 'Possible de charger une classe sans constructeur <hr>';
/**
 * Avec contructeur sans param
 */
$objetWithNamespacefictivenull = $container->get('fictivenull');

dump($objetWithNamespacefictivenull);


echo 'Possible de charger une classe avec constructeur et arguments <hr>';

/**
 * Avec Param
 */

$objetWithNamespacefictivenull = $container->get('optional');

dump($objetWithNamespacefictivenull);

echo 'Possible de charger une classe à partir de son namespace <hr>';

/**
 * Namespace endu
 */

 /**
 * Avec Param
 */

$objetn = $container->get(Fictive::class);
dump($objetn);

echo 'Possible de charger une closure enregistrée <hr>';

/**
 * Namespace endu
 */

 /**
 * Avec Param
 */

$objetn = $container->get('closure');
dump($objetn);

echo 'Possible de charger un objet enregistre <hr>';
/**
 * Namespace endu
 */

 /**
 * Avec Param
 */

$objetn = $container->get('objet');
dump($objetn);

$info=$container->give('receive');

var_dump($info);
//$exc =$container->get('notFound');

