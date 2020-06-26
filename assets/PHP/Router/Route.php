<?php

include_once 'Request.php';
include_once 'Routeur.php';
$router = new Router(new Request);

/**
 * Route Site
 */

 // test de route avec plusieurs paramètre
$router->get('portfolio/{id}/test/{projectID}/blog', function ($id, $newID) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/test.php");
});

$router->get('portfolio', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/accueil.php");
});

$router->post('portfolio/data', function ($request) {
  return json_encode($request->getBody());
});

/**
 *  Route Admin
 */
$router->get('portfolio/login', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/login.php");
});

$router->get('portfolio/admin', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/admin.php");
});

$router->get('portfolio/admin/blog', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/blog.php");
});

$router->get('portfolio/admin/texte', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Texte.php");
});

$router->get('portfolio/admin/skills', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Competences.php");
});

$router->get('portfolio/admin/projects', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Projets.php");
});

$router->get('portfolio/admin/CV', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/CV.php");
});