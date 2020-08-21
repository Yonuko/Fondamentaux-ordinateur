<?php

/**
 * Route Site
 */
$router->get('/', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/site/accueil.php");
});

$router->get('/blog', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/site/blog.php");
});

$router->get('/skills', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/site/skills.php");
});

$router->get('/projects', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/site/projects.php");
});

$router->get('/contact', function () {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/site/contact.php");
});

$router->get('/projects/{id}/{test}/{coucou}', function ($id, $ids, $test) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/site/project.php");
});

$router->get('/projects/{id}', function ($id) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/site/project.php");
});

$router->get('/post/{id}', function ($id) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/site/post.php");
});

/**
 *  Route Admin
 */
$router->get('/login', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/login.php");
});

$router->post('/login', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/PHP/Connexion.php");
});

$router->post('/logout', function ($request){
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/PHP/logout.php");
  header("location:https://sacha-eghiazarian.fr/");
});

$router->get('/admin', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/admin.php");
});

$router->get('/admin/blog', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/blog/blog.php");
});

$router->get('/admin/blog/create', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/blog/PostCreate.php");
});

$router->post('/admin/blog/store', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/PHP/blog/store.php");
});

$router->get('/admin/blog/{id}', function ($id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/blog/PostEdit.php");
});

$router->post('/admin/blog/{id}/update', function ($request, $id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/PHP/blog/update.php");
});

$router->get('/admin/blog/{id}/active', function ($id){
  needAdmin();
  $rqt = "SELECT isShown FROM posts WHERE post_id = ?;";
  $isActive = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  $rqt = "UPDATE posts SET isShown = ? WHERE post_id = ?;";
  sendRequest($rqt, [!$isActive, $id], PDO::FETCH_ASSOC);
  header("Location:https://sacha-eghiazarian.fr/admin/blog");
});

$router->get('/admin/blog/{id}/delete', function ($id){
  needAdmin();
  $rqt = "SELECT logo FROM posts WHERE post_id = ?;";
  $filename = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  unlink($_SERVER['DOCUMENT_ROOT'] . "/assets/image/Uploads/Blog/" . $filename);
  $rqt = "DELETE FROM posts WHERE post_id = ?;";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  $rqt = "DELETE FROM post_descriptions WHERE post_id = ?";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  header("Location:https://sacha-eghiazarian.fr/admin/blog");
});

$router->get('/admin/texte', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/Texte.php");
});

$router->post('/admin/texte', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/PHP/TextUpdate.php");
});

$router->get('/admin/skills', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/skills/Competences.php");
});

$router->get('/admin/skills/create', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/skills/SkillCreate.php");
});

$router->post('/admin/skills/store', function ($request){
  needAdmin();
  $data = $request->getBody();
  $rqt = "INSERT skills VALUES (null, ?, ?, ?, 1, 0);";
  sendRequest($rqt, [$data["name"], $data["value"], $data["type"]], PDO::FETCH_ASSOC);
  header("Location:https://sacha-eghiazarian.fr/admin/skills");
});

$router->post('/admin/skills/update', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/PHP/skills/update.php");
});

$router->get('/admin/skills/{id}/delete', function ($id){
  needAdmin();
  $rqt = "DELETE FROM skills WHERE skill_id = ?;";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  header("Location:https://sacha-eghiazarian.fr/admin/skills");
});

$router->get('/admin/projects', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/Projets/Projets.php");
});

$router->get('/admin/projects/create', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/Projets/ProjectCreate.php");
});

$router->post('/admin/projects/store', function ($request){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/PHP/projects/store.php");
});

$router->post('/admin/projects/{id}/update', function ($request, $id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/PHP/projects/update.php");
});

$router->get('/admin/projects/{id}', function ($id){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/Projets/ProjetEdit.php");
});

$router->get('/admin/projects/{id}/active', function ($id){
  needAdmin();
  $rqt = "SELECT isShown FROM projects WHERE project_id = ?;";
  $isActive = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  $rqt = "UPDATE projects SET isShown = ? WHERE project_id = ?;";
  sendRequest($rqt, [!$isActive, $id], PDO::FETCH_ASSOC);
  header("Location:https://sacha-eghiazarian.fr/admin/projects");
});

$router->get('/admin/projects/{id}/delete', function ($id){
  needAdmin();
  $rqt = "SELECT logo FROM projects WHERE project_id = ?;";
  $filename = sendRequest($rqt, [$id], PDO::FETCH_NUM)[0][0];
  unlink($_SERVER['DOCUMENT_ROOT'] . "/assets/image/Uploads/Projets/" . $filename);
  $rqt = "DELETE FROM projects WHERE project_id = ?;";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  $rqt = "DELETE FROM project_types WHERE project_id = ?;";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  $rqt = "DELETE FROM projects_description WHERE project_id = ?";
  sendRequest($rqt, [$id], PDO::FETCH_ASSOC);
  header("Location:https://sacha-eghiazarian.fr/admin/projects");
});

$router->get('/admin/CV', function (){
  needAdmin();
  include_once($_SERVER['DOCUMENT_ROOT'] . "/assets/vues/admin/CV.php");
});