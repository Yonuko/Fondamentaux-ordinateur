<?php

/**
 * Route Site
 */
$router->get('portfolio', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/accueil.php");
});

$router->get('portfolio/blog', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/blog.php");
});

$router->get('portfolio/skills', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/skills.php");
});

$router->get('portfolio/projects', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/projects.php");
});

$router->get('portfolio/contact', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/contact.php");
});

$router->get('portfolio/projects/{id}/{test}/{coucou}', function ($id, $ids, $test) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/project.php");
});

$router->get('portfolio/projects/{id}', function ($id) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/project.php");
});

$router->get('portfolio/post/{id}', function ($id) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/site/post.php");
});

/**
 *  Route Admin
 */
$router->get('portfolio/login', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/login.php");
});

$router->post('portfolio/login', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/Connexion.php");
});

$router->post('portfolio/logout', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/logout.php");
  header("location:http://localhost/portfolio/");
});

$router->get('portfolio/admin', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/admin.php");
});

$router->get('portfolio/admin/blog', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/blog.php");
});

$router->get('portfolio/admin/blog/{id}', function ($id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/blog.php");
});

$router->get('portfolio/admin/blog/create', function ($id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/blog.php");
});

$router->get('portfolio/admin/texte', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Texte.php");
});

$router->get('portfolio/admin/skills', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Competences.php");
});

$router->get('portfolio/admin/skills/create', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Competences.php");
});

$router->get('portfolio/admin/projects', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/Projets.php");
});

$router->get('portfolio/admin/projects/create', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/ProjectCreate.php");
});

$router->post('portfolio/admin/projects/store', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/PHP/projects/store.php");
});

$router->get('portfolio/admin/projects/{id}', function ($id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/ProjetEdit.php");
});

$router->get('portfolio/admin/projects/{id}/active', function ($id){
  needAdmin();
  $rqt = "SELECT isShown FROM projects WHERE project_id = ?;";
  $isActive = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  $rqt = "UPDATE projects SET isShown = ? WHERE project_id = ?;";
  sendRequest($rqt, [!$isActive, $id], PDO::FETCH_ASSOC);
  header("Location:http://localhost/portfolio/admin/projects");
});

$router->get('portfolio/admin/CV', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio/assets/vues/admin/CV.php");
});